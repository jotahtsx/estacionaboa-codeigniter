<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::dashboard', ['filter' => 'session']); // Adicionada a rota para o dashboard


$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');


$routes->group('usuarios', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'UserController::index'); // Listagem de usuários em /usuarios
    $routes->get('cadastrar', 'UserController::create');
    $routes->post('cadastrar', 'UserController::store');
    $routes->get('editar/(:num)', 'UserController::edit/$1');
    $routes->post('atualizar/(:num)', 'UserController::update/$1');
    $routes->post('delete/(:num)', 'UserController::delete/$1');
    $routes->get('show/(:num)', 'UserController::show/$1');
});


service('auth')->routes($routes, ['except' => ['login', 'logout', 'register']]);