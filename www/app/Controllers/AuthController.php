<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $credentials = [
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        if (! auth()->attempt($credentials)) {
            return redirect()->back()->withInput()->with('error', 'Email ou senha inválidos.');
        }

        $user = auth()->user();
        $name = $user->name ?? $user->username ?? 'Usuário';

        return redirect()->to('/usuarios')->with('success', "Bem-vindo(a) de volta, {$name}!");
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to('/login')->with('success', 'Você saiu com sucesso.');
    }
}
