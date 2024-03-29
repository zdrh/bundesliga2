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
    $routes->get('svaz/(:num)/sezona/(:num)/edit', 'AssociationSeason::edit/$1/$2');
    $routes->put('svaz/sezona/update', 'AssociationSeason::update');
    $routes->delete('svaz/(:num)/sezona/(:num)/delete', 'AssociationSeason::delete/$1/$2');

    //ligy
    $routes->get('seznam-lig', 'League::index');
    $routes->get('liga/pridat', 'League::add');
    $routes->post('liga/create', 'League::create');
    $routes->get('liga/(:num)/edit', 'League::edit/$1');
    $routes->put('liga/update', 'League::update');
    $routes->delete('liga/(:num)/delete', 'League::delete/$1');

    //sezony lig
    $routes->get('liga/(:num)/seznam-sezon', 'LeagueSeason::index/$1');
    $routes->get('liga/(:num)/sezona/pridat', 'LeagueSeason::add/$1');
    $routes->post('liga/sezona/create', 'LeagueSeason::create');
    $routes->get('liga/(:num)/sezona/(:num)/edit', 'LeagueSeason::edit/$1/$2');
    $routes->put('liga/sezona/update', 'LeagueSeason::update');
    $routes->delete('liga/(:num)/sezona/(:num)/delete', 'LeagueSeason::delete/$1/$2');

    //skupiny ligy
    $routes->get('liga/(:num)/sezona/(:num)/seznam-skupin', 'LeagueSeasonGroup::index/$1/$2');
    $routes->get('liga/(:num)/sezona/(:num)/skupina/pridat', 'LeagueSeasonGroup::add/$1/$2');
    $routes->post('liga/sezona/skupina/create', 'LeagueSeasonGroup::create');
    $routes->get('liga/(:num)/sezona/(:num)/skupina/(:num)/edit', 'LeagueSeasonGroup::edit/$1/$2/$3');
    $routes->put('liga/sezona/skupina/update', 'LeagueSeasonGroup::update');
    $routes->delete('liga/(:num)/sezona/(:num)/skupina/$3/smazat', 'LeagueSeasonGroup::delete/$1/$2/$3');
});
