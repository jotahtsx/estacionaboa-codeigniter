<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index()
    {
        $activePage = 'usuarios';
        $titlePage = 'Usuários';
        $userModel = new UserModel();
        $users = $userModel->findAll();

        $usersData = [];
        foreach ($users as $user) {
            $createdAt = \Carbon\Carbon::parse($user->created_at);
            $shieldUser = auth()->getProvider()->findById($user->id);
            $isAdmin = $shieldUser && $shieldUser->inGroup('admin');
            $role = $isAdmin ? 'Administrador' : 'Usuário Comum';

            $usersData[] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $createdAt->format('d/m/Y H:i:s'),
                'active' => $user->active,
                'role' => $role,
                'test_field' => $user->test_field,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ];
        }

        return view('users/index', [
            'users' => $usersData,
            'active_page' => $activePage,
            'titlePage' => $titlePage,
        ]);
    }

    public function show($id = null)
    {
        $activePage = 'usuarios';
        $titlePage = 'Visualizar Usuário';
        $userModel = new \App\Models\UserModel();


        $user = $userModel->find($id);

        if (! $user) {
            return redirect()->to('/usuarios')->with('error', 'Usuário não encontrado.');
        }


        $db = \Config\Database::connect();
        $identity = $db->table('auth_identities')
            ->where('user_id', $id)
            ->where('type', 'email_password')
            ->get()
            ->getRow();

        $user->email = $identity->secret ?? '';

        $shieldUser = auth()->getProvider()->findById($id);
        if ($shieldUser) {
            $groups = $shieldUser->getGroups();
            $user->group = !empty($groups) ? $groups[0] : 'Nenhum grupo';
        } else {
            $user->group = 'Usuário não encontrado';
        }

        return view('users/show', [
            'user' => $user,
            'active_page' => $activePage,
            'titlePage' => $titlePage,
        ]);
    }


    public function create()
    {
        return view('users/create', [
            'active_page' => 'usuarios',
            'titlePage' => 'Cadastrar Usuário',
        ]);
    }

    public function store()
    {
        $rules = [
            'username'   => 'required|min_length[3]|max_length[50]',
            'first_name' => 'required|min_length[2]|max_length[255]',
            'last_name'  => 'required|min_length[2]|max_length[255]',
            'email'      => [
                'label'  => 'E-mail',
                'rules'  => 'required|valid_email|is_unique[auth_identities.secret]',
                'errors' => [
                    'is_unique' => 'Este e-mail já está em uso.',
                ],
            ],
            'password' => 'required|min_length[6]',
            'active'   => 'required|in_list[0,1]',
            'role'     => 'required|in_list[user,admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userModel = new UserModel();
        $userData = [
            'username'   => $this->request->getPost('username'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'active'     => (int) $this->request->getPost('active'),
        ];

        $userId = $userModel->insert($userData);

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->insert([
            'user_id' => $userId,
            'type'    => 'email_password',
            'secret'  => $this->request->getPost('email'),
            'secret2' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        $provider = auth()->getProvider();
        $shieldUser = $provider->findById($userId);

        if ($shieldUser) {
            $shieldUser->addGroup($this->request->getPost('role'));
        }

        return redirect()->to('/usuarios')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            return redirect()->to('/usuarios')->with('error', 'Usuário não encontrado.');
        }

        $shieldUser = auth()->getProvider()->findById($user->id);
        $grupo = 'user';
        if ($shieldUser && $shieldUser->inGroup('admin')) {
            $grupo = 'admin';
        }

        $user->group = $grupo;

        $data = [
            'user' => $user,
            'active_page' => 'usuarios',
            'titlePage' => 'Editar Usuário',
        ];

        return view('users/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => [
                'label' => 'E-mail',
                'rules' => "required|valid_email|is_unique[auth_identities.secret,user_id,{$id},type,email_password]",
                'errors' => [
                    'is_unique' => 'Este e-mail já está sendo utilizado.',
                ],
            ],
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
            ],
            'active' => 'required|in_list[0,1]',
            'role'   => 'required|in_list[user,admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userData = [
            'username'   => $this->request->getPost('username'),
            'active'     => (int) $this->request->getPost('active'),
        ];

        $userModel = new UserModel();
        $userModel->update($id, $userData);

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->set('secret', $this->request->getPost('email'));
        $builder->where('user_id', $id);
        $builder->where('type', 'email_password');
        $builder->update();

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $builder->set('secret2', password_hash($password, PASSWORD_DEFAULT));
            $builder->where('user_id', $id);
            $builder->where('type', 'email_password');
            $builder->update();
        }

        $novoGrupo = $this->request->getPost('role');
        $provider = auth()->getProvider();
        $shieldUser = $provider->findById($id);

        if ($shieldUser) {
            $shieldUser->removeGroup('admin');
            $shieldUser->removeGroup('user');
            $shieldUser->addGroup($novoGrupo);
        }

        return redirect()->to('/usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function delete($id = null)
    {
        $currentUserId = auth()->id();

        if ((int) $id === $currentUserId) {
            return redirect()->to('/usuarios')->with('error', 'Você não pode excluir o seu próprio usuário.');
        }

        $userModel = new UserModel();

        $user = $userModel->find($id);
        if (! $user) {
            return redirect()->to('/usuarios')->with('error', 'Usuário não encontrado.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->where('user_id', $id)->delete();

        $provider = auth()->getProvider();
        $shieldUser = $provider->findById($id);
        if ($shieldUser) {
            $shieldUser->removeGroup('admin');
            $shieldUser->removeGroup('user');
        }

        $userModel->delete($id, true);

        return redirect()->to('/usuarios')->with('success', 'Usuário excluído com sucesso!');
    }
}
