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

        return view('users/index', [
            'users' => $users,
            'active_page' => $activePage,
            'titlePage' => $titlePage,
        ]);
    }
}