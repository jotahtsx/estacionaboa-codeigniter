<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'session']);

$routes->get('usuarios/editar/(:num)', 'UserController::edit/$1');
$routes->post('usuarios/atualizar/(:num)', 'UserController::update/$1');

$routes->get('usuarios/cadastrar', 'UserController::create');
$routes->post('usuarios/cadastrar', 'UserController::store');

$routes->post('usuarios/delete/(:num)', 'UserController::delete/$1');

$routes->get('usuarios', 'UserController::index');
$routes->get('usuarios/show/(:num)', 'UserController::show/$1');





service('auth')->routes($routes);