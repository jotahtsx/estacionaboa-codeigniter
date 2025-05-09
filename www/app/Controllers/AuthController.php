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
        $session = session();

        // Verifica se o usuário já está logado
        if (auth()->loggedIn()) {
            return redirect()->to('/usuarios');
        }

        // Validação dos campos
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

        try {
            if (! auth()->attempt($credentials)) {
                return redirect()->back()->withInput()->with('error', 'Email ou senha inválidos.');
            }
        } catch (\CodeIgniter\Shield\Exceptions\LogicException $e) {
            // Se já estiver logado, força logout antes de tentar novamente
            auth()->logout();
            $session->destroy(); // garante que os dados antigos foram limpos
            return redirect()->back()->with('error', 'Sessão anterior detectada. Faça login novamente.');
        }

        $user = auth()->user();
        $name = $user->name ?? $user->username ?? 'Usuário';

        return redirect()->to('/usuarios')->with('success', "Bem-vindo(a) de volta, {$name}!");
    }

    public function logout()
    {
        auth()->logout();
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Você saiu com sucesso.');
    }
}
