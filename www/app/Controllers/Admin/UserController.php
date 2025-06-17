<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use Carbon\Carbon;

class UserController extends Controller
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']);
    }

    /**
     * Exibe a listagem de usuários.
     * @return string
     */
    public function index(): string
    {
        $activePage = 'usuarios';
        $titlePage = 'Usuários';
        $users = $this->userModel->findAll();

        $usersData = [];
        foreach ($users as $user) {
            $createdAt = Carbon::parse($user->created_at);
            $shieldUser = auth()->getProvider()->findById($user->id);
            $isAdmin = $shieldUser && $shieldUser->inGroup('admin');
            $role = $isAdmin ? 'Administrador' : 'Usuário Comum';

            $usersData[] = [
                'id'         => $user->id,
                'username'   => $user->username,
                'email'      => $user->email,
                'created_at' => $createdAt->format('d/m/Y H:i:s'),
                'active'     => $user->active,
                'role'       => $role,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'image'      => $user->image,
                'gender'     => $user->gender,
            ];
        }

        // Caminho da view
        return view('admin/users/index', [
            'users'       => $usersData,
            'active_page' => $activePage,
            'titlePage'   => $titlePage,
        ]);
    }

    /**
     * Exibe os detalhes de um usuário específico.
     *
     * @param int|null $id ID do usuário.
     * @return string|RedirectResponse
     */
    public function show($id = null): string|RedirectResponse
    {
        if ($id === null) {
            return redirect()
                ->route('admin_usuarios')
                ->with('error', 'ID de usuário não fornecido para visualização.');
        }

        $provider = auth()->getProvider();
        $user = $provider->findById($id);

        if (! $user) {
            return redirect()
                ->route('admin_usuarios')
                ->with('error', 'Usuário não encontrado.');
        }

        $carbon = \CodeIgniter\I18n\Time::class;

        $userData = [
            'id'                => $user->id,
            'username'          => $user->username,
            'first_name'        => $user->first_name,
            'last_name'         => $user->last_name,
            'image'             => $user->image,
            'gender'            => $user->gender,
            'active'            => $user->active,
            'created_at'        => $user->created_at ? date('d/m/Y H:i:s', strtotime($user->created_at)) : 'N/A',
            'updated_at'        => $user->updated_at ? date('d/m/Y H:i:s', strtotime($user->updated_at)) : 'N/A',
            'last_login_at'     => $user->last_login_at ? date('d/m/Y H:i:s', strtotime($user->last_login_at)) : 'Nunca',
            'last_login_ip'     => $user->last_login_ip ?? 'N/A',
            'email_verified_at' => $user->email_verified_at ? date('d/m/Y H:i:s', strtotime($user->email_verified_at)) : 'Não verificado',
        ];

        $email = 'N/A';
        foreach ($user->getIdentities() as $identity) {
            if ($identity->type === 'email_password') {
                $email = $identity->secret;
                break;
            }
        }
        $userData['email'] = $email;

        $groups = $user->getGroups();
        $userData['role'] = in_array('admin', $groups) ? 'Administrador' : 'Usuário Comum';

        return view('admin/users/show', [
            'user'        => $userData,
            'active_page' => 'usuarios',
            'titlePage'   => 'Detalhes do Usuário',
        ]);
    }

    /**
     * Exibe o formulário para cadastrar um novo usuário.
     * @return string
     */
    public function create(): string
    {
        $users = $this->userModel->findAll();

        // Caminho da view
        return view('admin/users/create', [
            'users' => $users,
            'active_page' => 'usuarios',
            'titlePage'   => 'Cadastrar Usuário',
        ]);
    }

    /**
     * Armazena um novo usuário no banco de dados.
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $rules = [
            'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]', // Adicionado is_unique para username
            'first_name'       => 'required|min_length[2]|max_length[255]',
            'last_name'        => 'required|min_length[2]|max_length[255]',
            'email'            => [
                'label'  => 'E-mail',
                'rules'  => 'required|valid_email|is_unique[auth_identities.secret]',
                'errors' => [
                    'is_unique' => 'Este e-mail já está em uso.',
                ],
            ],
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required_with[password]|matches[password]', // Validação para confirmação de senha
            'active'           => 'required|in_list[0,1]',
            'role'             => 'required|in_list[user,admin]',
            'gender'           => 'permit_empty|in_list[male,female,other]',
            'image'            => [
                'rules'  => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,2048]',
                'errors' => [
                    'is_image'  => 'O arquivo não é uma imagem válida.',
                    'mime_in'   => 'A imagem deve ser do tipo JPG, JPEG, GIF, PNG ou WEBP.',
                    'max_size'  => 'A imagem é muito grande (máximo 2MB).',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $imagePath = null;
        $imageFile = $this->request->getFile('image');

        // Lógica do upload de imagem
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            try {
                $uploadsPath = FCPATH . 'uploads/';
                $usersPath = $uploadsPath . 'users/';

                // Cria a pasta 'uploads' se não existir
                if (!is_dir($uploadsPath)) {
                    if (!mkdir($uploadsPath, 0777, true) && !is_dir($uploadsPath)) {
                        throw new \RuntimeException('Não foi possível criar a pasta uploads.');
                    }
                }

                // Cria a pasta 'uploads/users' se não existir
                if (!is_dir($usersPath)) {
                    if (!mkdir($usersPath, 0777, true) && !is_dir($usersPath)) {
                        throw new \RuntimeException('Não foi possível criar a pasta uploads/users.');
                    }
                }

                $newName = $imageFile->getRandomName();
                $imageFile->move($usersPath, $newName);
                $imagePath = 'uploads/users/' . $newName; // Salva o caminho relativo ao FCPATH
            } catch (\RuntimeException $e) {
                // Loga o erro e redireciona com mensagem amigável
                log_message('error', 'Erro ao criar diretório ou mover imagem: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao fazer upload da imagem. Por favor, tente novamente.');
            }
        }

        // Prepara os dados para a tabela 'users'
        $userData = [
            'username'   => $this->request->getPost('username'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'active'     => (int) $this->request->getPost('active'),
            'image'      => $imagePath,
            'gender'     => $this->request->getPost('gender') ?? null,
        ];

        // Tenta inserir o usuário na tabela 'users'
        $userId = $this->userModel->insert($userData);

        if (!$userId) {
            // Se a inserção do usuário falhar, redireciona com erro
            log_message('error', 'Erro ao inserir usuário na tabela "users". Dados: ' . json_encode($userData));
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao cadastrar o usuário principal. Tente novamente.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $identityData = [
            'user_id' => $userId,
            'type'    => 'email_password',
            'secret'  => $this->request->getPost('email'),
            'secret2' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        if (!$builder->insert($identityData)) {
            $this->userModel->delete($userId); // Remove o usuário recém-criado
            log_message('error', 'Erro ao inserir identidade do usuário. User ID: ' . $userId);
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao configurar o e-mail/senha do usuário. O usuário não foi cadastrado.');
        }

        $provider = auth()->getProvider();
        $shieldUser = $provider->findById($userId);

        if ($shieldUser) {
            $shieldUser->addGroup($this->request->getPost('role'));
        } else {
            log_message('error', 'Shield User não encontrado após a criação do ID: ' . $userId . '. Possível inconsistência.');
            return redirect()->back()->withInput()->with('error', 'Erro interno: Usuário não configurado corretamente com a permissão. Contate o suporte.');
        }

        return redirect()->to(url_to('admin_usuarios'))->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um usuário.
     *
     * @param int $id ID do usuário a ser editado.
     * @return RedirectResponse|string
     */
    public function edit(int $id): RedirectResponse|string
    {
        $user = $this->userModel->find($id);

        if ($user === null) {
            log_message('error', 'Usuário não encontrado para edição: ' . $id);
            return redirect()->to(url_to('admin_usuarios'))->with('error', 'Usuário não encontrado.');
        }

        $shieldUser = auth()->getProvider()->findById($user->id);
        $grupo = 'user';
        if ($shieldUser && $shieldUser->inGroup('admin')) {
            $grupo = 'admin';
        }

        $user->group = $grupo;

        // Recupera o email da tabela auth_identities
        $db = \Config\Database::connect();
        $identity = $db->table('auth_identities')
            ->where('user_id', $id)
            ->where('type', 'email_password')
            ->get()
            ->getRow();

        // Adiciona o email ao objeto user
        $user->email = $identity->secret ?? '';

        $data = [
            'user'        => $user,
            'active_page' => 'usuarios',
            'titlePage'   => 'Editar Usuário',
        ];

        return view('admin/users/edit', $data);
    }

    /**
     * Atualiza um usuário no banco de dados.
     * @param int|null $id ID do usuário a ser atualizado.
     * @return RedirectResponse
     */
    public function update($id = null): RedirectResponse
    {
        if ($id === null) {
            return redirect()->to(url_to('admin_usuarios'))->with('error', 'ID de usuário não fornecido para atualização.');
        }

        $rules = [
            'username'         => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'first_name'       => 'required|min_length[2]|max_length[255]',
            'last_name'        => 'required|min_length[2]|max_length[255]',
            'email'            => [
                'label'  => 'E-mail',
                'rules'  => "required|valid_email|is_unique[auth_identities.secret,user_id,{$id},type,email_password]",
                'errors' => [
                    'is_unique' => 'Este e-mail já está sendo utilizado por outro usuário.',
                ],
            ],
            'password'         => 'permit_empty|min_length[6]',
            'password_confirm' => 'matches[password]',
            'active'           => 'required|in_list[0,1]',
            'role'             => 'required|in_list[user,admin]',
            'gender'           => 'permit_empty|in_list[male,female,other]',
            'image'            => [
                'rules'  => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[image,2048]',
                'errors' => [
                    'is_image'  => 'O arquivo não é uma imagem válida.',
                    'mime_in'   => 'A imagem deve ser do tipo JPG, JPEG, GIF, PNG ou WEBP.',
                    'max_size'  => 'A imagem é muito grande (máximo 2MB).',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $existingUser = $this->userModel->find($id);

        if (! $existingUser) {
            log_message('error', 'Tentativa de atualizar usuário não encontrado: ' . $id);
            return redirect()->to(url_to('admin_usuarios'))->with('error', 'Usuário não encontrado para atualização.');
        }

        $userData = [
            'username'   => $this->request->getPost('username'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'active'     => (int) $this->request->getPost('active'),
            'gender'     => $this->request->getPost('gender') ?? null,
        ];

        $file             = $this->request->getFile('image');
        $currentImagePath = $existingUser->image;
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            try {
                $uploadsPath = FCPATH . 'uploads/';
                $usersPath   = $uploadsPath . 'users/';
                if (!is_dir($uploadsPath) && !mkdir($uploadsPath, 0777, true)) {
                    throw new \RuntimeException('Não foi possível criar a pasta uploads.');
                }
                if (!is_dir($usersPath) && !mkdir($usersPath, 0777, true)) {
                    throw new \RuntimeException('Não foi possível criar a pasta uploads/users.');
                }

                $newName = $file->getRandomName();
                $file->move($usersPath, $newName);
                $userData['image'] = 'uploads/users/' . $newName;
                if (
                    !empty($currentImagePath) &&
                    !str_contains($currentImagePath, 'defaults/') &&
                    file_exists(FCPATH . $currentImagePath)
                ) {
                    unlink(FCPATH . $currentImagePath);
                    log_message('info', 'Imagem antiga excluída para o usuário ' . $id . ': ' . $currentImagePath);
                }
            } catch (\RuntimeException $e) {
                log_message('error', 'Erro no upload de imagem para atualização: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Erro ao fazer upload da nova imagem. Tente novamente.');
            }
        } else {
            $userData['image'] = $currentImagePath;
        }

        if (! $this->userModel->update($id, $userData)) {
            log_message('error', 'Erro ao atualizar usuário na tabela "users". ID: ' . $id . ' Dados: ' . json_encode($userData));
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar os dados principais do usuário. Tente novamente.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('auth_identities');
        $builder->set('secret', $this->request->getPost('email'));
        $builder->where('user_id', $id);
        $builder->where('type', 'email_password');
        if (! $builder->update()) { // Adicionado verificação de sucesso
            log_message('error', 'Erro ao atualizar email na auth_identities para o User ID: ' . $id);
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar o e-mail do usuário. Tente novamente.');
        }

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $builder->set('secret2', password_hash($password, PASSWORD_DEFAULT));
            $builder->where('user_id', $id);
            $builder->where('type', 'email_password');
            if (! $builder->update()) {
                log_message('error', 'Erro ao atualizar senha na auth_identities para o User ID: ' . $id);
                return redirect()->back()->withInput()->with('error', 'Erro ao atualizar a senha do usuário. Tente novamente.');
            }
        }

        $novoGrupo = $this->request->getPost('role');
        $provider  = auth()->getProvider();
        $shieldUser = $provider->findById($id);

        if ($shieldUser) {
            foreach ($shieldUser->getGroups() as $group) {
                $shieldUser->removeGroup($group);
            }
            $shieldUser->addGroup($novoGrupo);
        } else {
            log_message('error', 'Shield User não encontrado durante a atualização do grupo para o ID: ' . $id . '. Possível inconsistência.');
            return redirect()->back()->withInput()->with('error', 'Erro interno: Não foi possível atualizar a permissão do usuário. Contate o suporte.');
        }
        return redirect()->to(url_to('admin_usuarios_edit', $id))->with('success', 'Usuário atualizado com sucesso!');
    }

    public function delete($id = null): RedirectResponse
    {
        if ($id === null) {
            return redirect()->to(route_to('admin_usuarios'))
                ->with('error', 'ID do usuário não fornecido.');
        }

        $currentUserId = auth()->id();
        if ((int)$id === (int)$currentUserId) {
            return redirect()->to(route_to('admin_usuarios'))
                ->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        $userModel = model('App\Models\UserModel');
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to(route_to('admin_usuarios'))
                ->with('error', 'Usuário não encontrado.');
        }

        if (!empty($user->image)) {
            $imagePath = FCPATH . $user->image;

            if (file_exists($imagePath) && !str_contains($user->image, 'defaults/')) {
                try {
                    unlink($imagePath);
                } catch (\Throwable $e) {
                    log_message('error', 'Erro ao excluir imagem do usuário: ' . $e->getMessage());
                }
            }
        }

        if ($userModel->delete($id)) {
            return redirect()->to(route_to('admin_usuarios'))
                ->with('success', 'Usuário excluído com sucesso!');
        }

        return redirect()->to(route_to('admin_usuarios'))
            ->with('error', 'Erro ao tentar excluir o usuário.');
    }
}
