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

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->season = new Season();
        $this->league_season = new LeagueSeason();
        $this->team = new Team();
        $this->arrayLib = new ArrayLibrary();
        $this->footballLib = new FootballLibrary();
    }
    public function show($id_league_season)
    {
        $sezony = $this->season->orderBy('start', 'desc')->findAll();
        $sezony = $this->footballLib->getSeasons($sezony, 'sezona', '-');
        $this->data['sezony'] = $this->arrayLib->arrayToDropdown($sezony, 'id_season', 'sezona');
        $this->data['sezona'] = $this->league_season->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->join('league', $this->data['join']['league_league_season'], 'inner')->find($id_league_season);
        $this->data['tymy'] = $this->team->join('team_league_season', $this->data['join']['team_team_league_season'], 'inner')->join('league_season_group', $this->data['join']['team_league_season_league_season_group'], 'inner')->where('league_season_group.id_league_season', $id_league_season)->findAll();

        echo view('frontend/league_season/show', $this->data);
    }
}
