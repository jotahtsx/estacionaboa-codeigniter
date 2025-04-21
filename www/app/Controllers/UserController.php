<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Models\UserModel;

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
            ];
        }

        return view('users/index', [
            'users' => $usersData,
            'active_page' => $activePage,
            'titlePage' => $titlePage,
        ]);
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
                'rules' => "required|valid_email|is_unique[auth_identities.secret,user_id,{$id},type,email]",
                'errors' => [
                    'is_unique' => 'Este e-mail já está sendo utilizado.',
                ],
            ],
            'active' => 'required|in_list[0,1]',
            'role'   => 'required|in_list[user,admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'active'   => (int) $this->request->getPost('active'),
        ];

        $userModel = new UserModel();
        $userModel->update($id, $userData);

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->set('secret', $this->request->getPost('email'));
        $builder->where('user_id', $id);
        $builder->where('type', 'email');
        $builder->update();

        // Atualiza grupo
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
}
