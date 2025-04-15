<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'session']);

$routes->get('/usuarios', 'UserController::index');
$routes->get('usuarios/editar/(:num)', 'UserController::edit/$1');

service('auth')->routes($routes);