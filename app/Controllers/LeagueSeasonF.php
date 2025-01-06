<?php

namespace App\Controllers;

use App\Controllers\BaseFrontendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Season;
use App\Models\LeagueSeason;
Use App\Models\Team;

use App\Libraries\FootballLibrary;
use App\Libraries\ArrayLibrary;

class LeagueSeasonF extends BaseFrontendController
{

    var $season;
    var $league_season;
    var $team;
    var $arrayLib;
    var $footballLib;
    var $frontendNavbar;
    var $subMenu;
    

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->season = new Season();
        $this->league_season = new LeagueSeason();
        $this->team = new Team();
        $this->arrayLib = new ArrayLibrary();
        $this->footballLib = new FootballLibrary();
        $this->data['frontendNavbar'] = 'navbar_season';
        $this->data['subMenu'] = $this->menu->where('type', 3)->orderBy('priority', 'DESC')->findAll();
        $this->data['id_season'] = NULL;
        $this->data['id_league_season'] = NULL;
    }
    public function show($id_league_season)
    {
        $this->data['id_league_season'] = $id_league_season;
        $this->data['sezona'] = $this->league_season->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->join('league', $this->data['join']['league_league_season'], 'inner')->find($id_league_season);

        $this->data['tatoSezona'] = $this->data['sezona']->id_season;
        $this->data['soutezeTatoSezona'] = $this->league_season->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->where('association_season.id_season', $this->data['tatoSezona'])->findAll();

        $this->data['tymy'] = $this->team->join('team_league_season', $this->data['join']['team_team_league_season'], 'inner')->join('league_season_group', $this->data['join']['team_league_season_league_season_group'], 'inner')->where('league_season_group.id_league_season', $id_league_season)->findAll();

        $sezona = $this->data['sezona']->start."-".$this->data['sezona']->finish;
        $this->data['navbarLogo'] = array(
            'url' => 'sezona/zobraz/'.$sezona."/".$this->data["sezona"]->id_season,
            'text' =>  $this->data['sezona']->league_name_in_season . " - " . $sezona
        );
        echo view('frontend/league_season/show', $this->data);
    }
}
