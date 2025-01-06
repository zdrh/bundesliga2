<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeasonGroup;
use App\Models\LeagueSeason;
use App\Models\TeamLeagueSeason;
use App\Models\Game as G;
use App\Models\GameTeam;
use App\Models\Stadium;

class Game extends BaseBackendController
{
    var $league_season_group;
    var $league_season;
    var $team_league_season;
    var $game;
    var $game_team;
    var $stadium;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->league_season_group = new LeagueSeasonGroup();
        $this->league_season = new LeagueSeason();
        $this->team_league_season = new TeamLeagueSeason();
        $this->game = new G();
        $this->game_team = new GameTeam();
        $this->stadium = new Stadium();
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

    public function edit($id_game)
    {

        $this->data["id"] = $id_game;
        $this->data["game"] = $this->game->find($id_game);
        $this->data['stadium'] = $this->game_team->join('game', $this->data['join']['game_game_team'], 'inner')->join('team_league_season', $this->data['join']['team_league_season_game_team_me'], 'inner')->join('stadium', $this->data['join']['stadium_team_league_season'], 'left')->join('city', $this->data['join']['city_stadium'], 'left')->where('field', 1)->where('game.id_game', $id_game)->findAll()[0];
        $this->data['allStadiums'] = $this->stadium->join('city', $this->data['join']['city_stadium'], 'inner')->orderBy('general_name', 'asc')->findAll();
        
        $this->data["game_team"] = $this->game_team->select('game_team.id_team_league_season as me_id_team, me.team_name_in_season as me_season_name, me_team.general_name as me_general_name, game_team.id_opponent as oppo_id_team, oppo.team_name_in_season as oppo_season_name, oppo_team.general_name as oppo_general_name, result_team, result_opponent, halftime_team, halftime_opponent, id_game_team, field')->join('team_league_season me', 'me.id_team_league_season=game_team.id_team_league_season', 'inner')->join('team_league_season oppo', 'oppo.id_team_league_season=game_team.id_opponent', 'inner')->join('team me_team', 'me.id_team=me_team.id_team', 'inner')->join('team oppo_team', 'oppo.id_team=oppo_team.id_team', 'inner')->where('field', 1)->where('id_game', $id_game)->findAll()[0];
        $this->data["league"] = $this->league_season->join('league_season_group', $this->data["join"]['league_season_league_season_group'], 'inner')->where('id_league_season_group', $this->data['game']->id_league_season_group)->findAll()[0];
        $this->data["team"] = $this->team_league_season->where('id_league_season_group', $this->data["league"]->id_league_season_group)->findAll();
        //var_dump($this->data["game_team"]);
        echo view('backend/game/edit', $this->data);
    }

    public function update() {
        $game_id = $this->request->getPost('game_id');
        $date = $this->request->getPost('date');
        $time = $this->request->getPost('time');
        $round = $this->request->getPost('kolo');
        $home = $this->request->getPost('home');
        $away = $this->request->getPost('away');
        $stadium = $this->request->getPost('stadium');
        $attendance = $this->request->getPost('attendance');
        $goal_home = $this->request->getPost('goal_home');
        $goal_away = $this->request->getPost('goal_away');
        $half_home = $this->request->getPost('half_home');
        $half_away = $this->request->getPost('half_away');

        
        $id_league_season = $this->game->join('league_season_group', $this->data['join']['game_league_season_group'], 'inner')->join('league_season', $this->data['join']['league_season_league_season_group'], 'inner')->where('id_game', $game_id)->findAll()[0]->id_league_season;
        $id_game_team_home = $this->game_team->where('field', 1)->where('id_game', $game_id)->findAll()[0]->id_game_team;
        $id_game_team_away = $this->game_team->where('field', 2)->where('id_game', $game_id)->findAll()[0]->id_game_team;

        $dataGame = array(
            'date' => $date,
            'id_game' => $game_id,
            'time' => $time,
            'round' => $round,
            'attendance' => $attendance,
            'id_stadium' => $stadium
        );

        $dataHome = array(
            'id_game_team' => $id_game_team_home,
            'id_team_league_season' => $home,
            'id_opponent' => $away,
            'result_team' => $goal_home,
            'result_opponent' => $goal_away,
            'halftime_team' => $half_home,
            'halftime_opponent' => $half_away

        );

        $dataAway = array(
            'id_game_team' => $id_game_team_away,
            'id_team_league_season' => $away,
            'id_opponent' => $home,
            'result_team' => $goal_away,
            'result_opponent' => $goal_home,
            'halftime_team' => $half_away,
            'halftime_opponent' => $half_home
        );
        var_dump($dataGame);
        var_dump($dataHome);
        var_dump($dataAway);
       $this->game->transStart();

        $this->game->save($dataGame);
        $this->game_team->save($dataHome);
        $this->game_team->save($dataAway);

        $this->game->transComplete();
        $result = $this->game->transStatus();



        $pole[] = $this->errorMessage->prepareMessage($result, 'dbEdit', 'Zápasy');
        $this->session->setFlashdata('error', $pole);
        return redirect()->to('admin/liga/' . $id_league_season . '/info#matches');
    }

    public function delete($id_game) {}
}
