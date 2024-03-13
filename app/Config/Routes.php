<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
