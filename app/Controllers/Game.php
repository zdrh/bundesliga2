<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeasonGroup;
use App\Models\TeamLeagueSeason;
use App\Models\Game as G;
use App\Models\GameTeam;

class Game extends BaseBackendController
{
    var $league_season_group;
    var $team_league_season;
    var $game;
    var $game_team;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->league_season_group = new LeagueSeasonGroup();
        $this->team_league_season = new TeamLeagueSeason();
        $this->game = new G();
        $this->game_team = new GameTeam();
    }

    public function add($id_group)
    {
        $this->data['skupina'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->join('league', $this->data['join']['league_league_season'], 'join')->find($id_group);
        $this->data['tymy'] = $this->team_league_season->join('team', $this->data['join']['team_team_league_season'], 'inner')->where('id_league_season_group', $id_group)->findAll();
        $this->data['pocetZapasu'] = round(Count($this->data['tymy']) / 2, 0, PHP_ROUND_HALF_DOWN);

        echo view('backend/game/add', $this->data);
    }

    public function create()
    {
        $datum = $this->request->getPost('date');
        $cas = $this->request->getPost('time');
        $kolo = $this->request->getPost('round');
        $home = $this->request->getPost('home');
        $away = $this->request->getPost('away');
        $goalsHome = $this->request->getPost('goalsHome');
        $goalsAway = $this->request->getPost('goalsAway');
        $id_group = $this->request->getPost('id_group');

        $this->game->transStart();
        foreach ($home as $row) {
            $dataGame = array(
                'date' => $datum,
                'time' => $cas,
                'id_league_season_group' => $id_group,
                'round' => $kolo
            );
            
            $this->game->save($dataGame);
            $insertID[] = $this->game->getInsertID();
        }
        $this->game->transComplete();
        $result = $this->game->transStatus();
       


        $pole[] = $this->errorMessage->prepareMessage($result, 'dbAdd', 'Zápasy');

         //pokud se v pořádku vložily zápasy, vkládáme i výsledky
        if ($result) {
            $this->game_team->transStart();
           foreach ($insertID as $key => $row2) {
                $dataHome = array(
                    'id_game' => $row2,
                    'id_team_league_season' => $home[$key],
                    'id_opponent' => $away[$key],
                    'result_team' => $goalsHome[$key],
                    'result_opponent' => $goalsAway[$key],
                    'field' => 1
                );

                $dataAway = array(
                    'id_game' => $row2,
                    'id_team_league_season' => $away[$key],
                    'id_opponent' => $home[$key],
                    'result_team' => $goalsAway[$key],
                    'result_opponent' => $goalsHome[$key],
                    'field' => 2
                );
               $this->game_team->save($dataHome);
                $this->game_team->save($dataAway);
            }
            $this->game_team->transComplete();
            $result2 = $this->game_team->transStatus();
            $pole[] = $this->errorMessage->prepareMessage($result2, 'dbAdd', 'Výsledky');
        }

        $this->session->setFlashdata('error', $pole);
        $liga = $this->league_season_group->find($id_group);
        return redirect()->to('admin/liga/' . $liga->id_league_season . '/info#liga-' . $id_group);
    }

    public function edit($id_game) {
        
    }
}
