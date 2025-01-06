<?php

namespace App\Controllers;

use App\Controllers\BaseFrontendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\TeamLeagueSeason;
use App\Models\Team;

class TeamF extends BaseFrontendController
{

    var $teamLeagueSeason;
    var $team;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->teamLeagueSeason = new TeamLeagueSeason();
        $this->team = new Team();
    }

    public function showHistory($id_team)
    {
        $this->data['history'] = $this->teamLeagueSeason->select('season.start, season.finish, team_league_season.team_name_in_season, league_season.league_name_in_season, league_season_group.groupname, league_season.logo as leagueLogo, team_league_season.logo as teamLogo, league.level')->join('league_season_group', $this->data['join']['team_league_season_league_season_group'], 'inner')->join('league_season', $this->data['join']['league_season_league_season_group'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->join('league', $this->data['join']['league_league_season'])->where('team_league_season.id_team', $id_team)->orderBy('start', 'desc')->findAll();
        $this->data["team"] = $this->team->find($id_team);
        echo view('frontend/team/history', $this->data);
    }
}
