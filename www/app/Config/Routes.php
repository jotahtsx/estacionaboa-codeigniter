<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rotas de Dashboard
$routes->get('/', 'Admin\Dashboard::index');
$routes->get('/dashboard', 'Admin\Dashboard::dashboard', ['filter' => 'session']);

// Rotas de Autenticação
$routes->get('/login', 'Admin\AuthController::loginForm', ['as' => 'login']);
$routes->post('/login', 'Admin\AuthController::login', ['as' => 'login_attempt']);
$routes->get('/logout', 'Admin\AuthController::logout', ['as' => 'logout']);

// Grupo de Rotas para Administração
$routes->group('admin', ['filter' => 'session', 'namespace' => 'App\Controllers\Admin'], function ($routes) {

    //Rotas de usuários
    $routes->get('usuarios', 'UserController::index', ['as' => 'admin_usuarios']);
    $routes->get('usuarios/cadastrar', 'UserController::create', ['as' => 'admin_usuarios_create']);
    $routes->post('usuarios/store', 'UserController::store', ['as' => 'admin_usuarios_store']);
    $routes->get('usuarios/(:num)', 'UserController::show/$1', ['as' => 'admin_usuarios_show']);
    $routes->get('usuarios/editar/(:num)', 'UserController::edit/$1', ['as' => 'admin_usuarios_edit']);
    $routes->put('usuarios/atualizar/(:num)', 'UserController::update/$1', ['as' => 'admin_usuarios_update']);
    $routes->delete('usuarios/delete/(:num)', 'UserController::delete/$1', ['as' => 'admin_usuarios_delete']);

    //Rotas de configurações
    $routes->get('configuracoes', 'ParkingSettingController::edit');
    $routes->post('configuracoes', 'ParkingSettingController::update');

    //Rotas de precificações
    $routes->get('precificacoes', 'PricingController::index', ['as' => 'admin_precificacoes']);
    $routes->get('precificacoes/cadastrar', 'PricingController::create', ['as' => 'admin_precificacoes_create']);
    $routes->post('precificacoes/store', 'PricingController::store', ['as' => 'admin_precificacoes_store']);
    $routes->get('precificacoes/editar/(:num)', 'PricingController::edit/$1', ['as' => 'admin_precificacoes_edit']);
    $routes->post('precificacoes/atualizar/(:num)', 'PricingController::update/$1', ['as' => 'admin_precificacoes_update']);
    $routes->get('precificacoes/deletar/(:num)', 'PricingController::delete/$1', ['as' => 'admin_precificacoes_delete']);
});
