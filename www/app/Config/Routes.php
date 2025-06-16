<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Admin\Dashboard::dashboard', ['filter' => 'session']);


$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');


$routes->group('usuarios', ['filter' => 'session'], function ($routes) {
    $routes->post('usuarios/toggle-active/(:num)', 'UserController::toggleActive/$1');

    $routes->get('/', 'UserController::index');
    $routes->get('cadastrar', 'UserController::create');
    $routes->post('cadastrar', 'UserController::store');
    $routes->get('editar/(:num)', 'UserController::edit/$1');
    $routes->post('atualizar/(:num)', 'UserController::update/$1');
    $routes->post('delete/(:num)', 'UserController::delete/$1');
    $routes->get('show/(:num)', 'UserController::show/$1');
});


service('auth')->routes($routes, ['except' => ['login', 'logout', 'register']]);
