<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // Rotas de Dashboard
$routes->get('/', 'Admin\Dashboard::index');
$routes->get('/dashboard', 'Admin\Dashboard::dashboard', ['filter' => 'session']);

// Rotas de Autenticação
$routes->get('/login', 'Admin\AuthController::loginForm', ['as' => 'login_form']);
$routes->post('/login', 'Admin\AuthController::login', ['as' => 'login_attempt']);
$routes->get('/logout', 'Admin\AuthController::logout', ['as' => 'logout']);

// Grupo de Rotas para Usuários (Administração)
$routes->group('usuarios', ['filter' => 'session', 'namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'UserController::index', ['as' => 'admin_users']);
    $routes->get('cadastrar', 'UserController::create', ['as' => 'admin_users_create']);
    $routes->post('cadastrar', 'UserController::store', ['as' => 'admin_users_store']);
    $routes->get('editar/(:num)', 'UserController::edit/$1', ['as' => 'admin_users_edit']);
    $routes->post('atualizar/(:num)', 'UserController::update/$1', ['as' => 'admin_users_update']);
    $routes->post('delete/(:num)', 'UserController::delete/$1', ['as' => 'admin_users_delete']);
    $routes->get('show/(:num)', 'UserController::show/$1', ['as' => 'admin_users_show']);
});

service('auth')->routes($routes, ['except' => ['login', 'logout', 'register']]);