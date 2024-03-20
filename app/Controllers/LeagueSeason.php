<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeason as LgSeason;
Use App\Models\League;

class LeagueSeason extends BaseBackendController
{

    var $leagueSeason;
    var $league;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->leagueSeason = new LgSeason();
        $this->league = new League();
    }

    public function index($idLeague)
    {
        $this->data['liga'] = $this->league->find($idLeague);
        $this->data['sezony'] = $this->leagueSeason->select('season.start, season.finish, league.id_league, league.name as league_name, league_season.league_name_in_season, league_season.logo, league_season.groups, season.id_season')->join('league', 'league_season.id_league=league.id_league', 'inner')->join('association_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('season', 'association_season.id_season=season.id_season', 'inner')->where('league.id_league', $idLeague)->orderBy('start', 'asc')->findAll();
        //var_dump($this->data["sezony"]);

        echo view('backend/league_season/index', $this->data);
    }

    public function add($idLeague) {

    }
}
