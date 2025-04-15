<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Models\UserModel;
use Carbon\Carbon;

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
            $createdAt = Carbon::parse($user->created_at);
            $shieldUser = auth()->getProvider()->findById($user->id);
            $isAdmin = $shieldUser && $shieldUser->inGroup('admin');
            $role = $isAdmin ? 'Admin' : 'Usuario Comum';

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

        $data = [
            'user' => $user,
            'active_page' => 'usuarios',
            'titlePage' => 'Editar Usuário',
        ];

        return view('users/edit', $data);
    }
}
