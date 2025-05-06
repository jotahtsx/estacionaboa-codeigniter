<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Session implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userId = $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            $session->destroy();
            return redirect()->to('/login')->with('error', 'Sessão inválida. Faça login novamente.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não é necessário nada aqui
    }
}
