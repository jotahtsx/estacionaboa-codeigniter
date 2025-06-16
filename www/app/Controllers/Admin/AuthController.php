<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends Controller
{
    public function loginForm()
    {
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

        // Se o usuário já está logado, redireciona para a página principal.
        if (auth()->loggedIn()) {
            return redirect()->to($authConfig->redirects['login']);
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

        // Sempre verifique se o usuário foi obtido com sucesso.
        $user = auth()->user();

        if ($user === null) {
            // Desloga preventivamente e informa o usuário.
            auth()->logout();
            return redirect()->back()->with('error', lang('Auth.badAttempt') . ' Por favor, tente novamente.');
        }

        // Verifica se o usuário está banido.
        if ($user->isBanned()) {
            auth()->logout();
            return redirect()->back()->with('error', lang('Auth.userIsBanned'));
        }

        $name = $user->name ?? $user->username ?? 'Usuário';

        return redirect()->to('/usuarios')->with('success', "Bem-vindo(a) de volta, {$name}!");
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Você saiu com sucesso.');
    }
}
