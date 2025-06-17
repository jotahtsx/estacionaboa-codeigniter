<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends Controller
{
    public function loginForm()
    {
        // Se o usuário já estiver logado e tentar acessar o formulário de login,
        // redireciona-o para o dashboard do admin.
        if (auth()->loggedIn()) {
            return redirect()->to(url_to('dashboard'));
        }
        return view('auth/login');
    }

    /**
     * Tenta logar o usuário.
     *
     * @return RedirectResponse
     */
    public function login(): RedirectResponse
    {
        /** @var \Config\Auth $authConfig */
        $authConfig = config('Auth');

        // Se o usuário já está logado, redireciona para a página principal do admin.
        // Usar url_to() com um nome de rota específico é mais robusto.
        if (auth()->loggedIn()) {
            return redirect()->to(url_to('dashboard')); // <--- CORREÇÃO AQUI!
        }

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

        $remember = (bool) $this->request->getPost('remember');

        if (! auth()->attempt($credentials, $remember)) {
            $error = auth()->error() ?? lang('Auth.badAttempt');
            return redirect()->back()->withInput()->with('error', $error);
        }

        $user = auth()->user();

        if ($user === null) {
            auth()->logout();
            return redirect()->back()->with('error', lang('Auth.badAttempt') . ' Por favor, tente novamente.');
        }

        if ($user->isBanned()) {
            auth()->logout();
            return redirect()->back()->with('error', lang('Auth.userIsBanned'));
        }

        $name = $user->name ?? $user->username ?? 'Usuário';

        // Redirecionamento após login bem-sucedido para o dashboard do admin
        return redirect()->to(url_to('dashboard'))->with('success', "Bem-vindo(a) de volta, {$name}!");
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        session()->destroy(); // Garante que a sessão seja completamente destruída
        // Redireciona para o formulário de login usando o nome da rota
        return redirect()->to(url_to('login'))->with('success', 'Você saiu com sucesso.');
    }
}