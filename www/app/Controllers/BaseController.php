<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = service('session');

        // Verificar se o usuário está logado e se a sessão expirou
        $this->checkSessionExpiration();
    }

    /**
     * Verifica se a sessão expirou
     *
     * @return void
     */
    protected function checkSessionExpiration()
    {
        if (session()->get('logged_in')) {
            $lastActivity = session()->get('last_activity');
            if (time() - $lastActivity > 60 * 60) {
                session()->destroy(); 
                return redirect()->to('/login')->with('error', 'Sua sessão expirou, por favor faça login novamente.');
            }
        }
        if (session()->get('logged_in')) {
            session()->set('last_activity', time());
        }
    }
}
