<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('login', 'Auth::login');
$routes->post('login-complete', 'Auth::loginComplete');
$routes->get('logout', 'Auth::logout');



//administrace
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    //sezóny
    $routes->get('seznam-sezon', 'Season::index');
    $routes->get('sezona/pridat', 'Season::add');
    $routes->post('sezona/create', 'Season::create');
    $routes->get('sezona/(:num)/edit', 'Season::edit/$1');
    $routes->put('sezona/update', 'Season::update');
    $routes->delete('sezona/(:num)/delete', 'Season::delete/$1');
});
