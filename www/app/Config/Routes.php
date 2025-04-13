<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'session']);

$routes->get('/usuarios', 'UserController::index');

service('auth')->routes($routes);

