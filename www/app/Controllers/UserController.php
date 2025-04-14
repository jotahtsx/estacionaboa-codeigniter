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
            $usersData[] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'created_at' => $createdAt->format('d/m/Y H:i:s'),
            ];
        }

        return view('users/index', [
            'users' => $usersData,
            'active_page' => $activePage,
            'titlePage' => $titlePage,
        ]);
    }
}