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

    //svazy
    $routes->get('seznam-svazu', 'Association::index');
    $routes->get('svaz/pridat', 'Association::add');
    $routes->post('svaz/create', 'Association::create');
    $routes->get('svaz/(:num)/edit', 'Association::edit/$1');
    $routes->put('svaz/update', 'Association::update');
    $routes->delete('svaz/(:num)/delete', 'Association::delete/$1');

    //sezony svazu
    $routes->get('svaz/(:num)/seznam-sezon', 'AssociationSeason::index/$1');
    $routes->get('svaz/(:num)/sezona/pridat', 'AssociationSeason::add/$1');
    $routes->post('svaz/sezona/create', 'AssociationSeason::create');
});
