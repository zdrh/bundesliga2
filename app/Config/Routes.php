<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Main::index');
$routes->get('login', 'Auth::login');
$routes->post('login-complete', 'Auth::loginComplete');
$routes->get('logout', 'Auth::logout');


//frontend
$routes->get('seznam-sezon', 'SeasonF::index');
$routes->post('sezona/view','SeasonF::view');
$routes->get('sezona/zobraz/(:any)/(:num)', 'SeasonF::show/$2');
$routes->get('sezona/(:any)/zobraz/liga/(:num)', 'LeagueSeasonF::show/$2');

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
    $routes->delete('liga/(:num)/sezona/(:num)/skupina/(:num)/delete', 'LeagueSeasonGroup::delete/$1/$2/$3');

    //týmy
    $routes->get('seznam-tymu', 'Team::index');
    $routes->get('tym/pridat', 'Team::add');
    $routes->post('tym/create', 'Team::create');
    $routes->get('tym/import', 'Team::import');
    $routes->post('tym/createImport', 'Team::createImport');
    $routes->get('tym/(:num)/edit', 'Team::edit/$1');
    $routes->put('tym/update', 'Team::update');
    $routes->delete('tym/(:num)/delete', 'Team::delete/$1');
    
    //Správa lig - přidání týmů, zápasů atd
    $routes->get('liga/(:num)/info', 'TeamLeagueSeason::index/$1');
    //seznam týmů skupiny
    $routes->get('liga/(:num)/seznam-tymu', 'TeamLeagueSeason::showGroup/$1');
    $routes->get('liga/(:num)/tym/pridat', 'TeamLeagueSeason::add/$1');
    $routes->post('liga/tym/create', 'TeamLeagueSeason::create');
    $routes->get('liga/(:num)/tym/(:num)/edit', 'TeamLeagueSeason::edit/$1/$2');
    $routes->put('liga/tym/update', 'TeamLeagueSeason::update');
    $routes->delete('liga/(:num)/tym/(:num)/delete', 'TeamLeagueSeason::delete/$1/$2');

    //sezony týmu
    $routes->get('tym/(:num)/seznam-sezon', 'TeamSeason::index/$1');
    
    //zápasy
    $routes->get('liga/skupina/(:num)/zapasy/pridat', 'Game::add/$1');
    $routes->post('liga/skupina/zapasy/create', 'Game::create');
    $routes->get('liga/skupina/(:num)/zapasy/(:num)/edit', 'Game::edit/$2');

    
});
