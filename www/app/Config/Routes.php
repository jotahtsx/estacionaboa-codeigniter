<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'session']);

$routes->group('usuarios', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('cadastrar', 'UserController::create');
    $routes->post('cadastrar', 'UserController::store');
    $routes->get('editar/(:num)', 'UserController::edit/$1');
    $routes->post('atualizar/(:num)', 'UserController::update/$1');
    $routes->post('delete/(:num)', 'UserController::delete/$1');
    $routes->get('show/(:num)', 'UserController::show/$1');
});

service('auth')->routes($routes);
