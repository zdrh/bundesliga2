<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\TeamLeagueSeason as Tls;
use App\Models\LeagueSeason;
use App\Models\LeagueSeasonGroup;

use App\Libraries\ArrayLibrary;
use App\Libraries\FootballLibrary;
use App\Libraries\FileLibrary;
use stdClass;

class TeamLeagueSeason extends BaseBackendController
{
    var $team_league_season;
    var $league_season;
    var $league_season_group;
    var $arrayLib;
    var $footballLib;
    var $fileLib;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->team_league_season = new Tls();
        $this->league_season = new LeagueSeason();
        $this->league_season_group = new LeagueSeasonGroup();
        $this->arrayLib = new ArrayLibrary();
        $this->footballLib = new FootballLibrary();
        $this->fileLib = new FileLibrary();
    }

    public function index($idLeagueSeason)
    {
        $this->data['liga'] = $this->league_season->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->where('association_season.deleted_at IS NULL')->find($idLeagueSeason);
        $skupiny = $this->league_season_group->where('id_league_season', $idLeagueSeason)->orderBy('regular', 1)->findAll();
        $this->data['skupiny'] = $this->arrayLib->fillNames($skupiny, $this->data['liga']->league_name_in_season);
       
        $tymy = $this->team_league_season->join('league_season_group', $this->data['join']['league_season_group_team_league_season'], 'inner')->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('team', $this->data['join']['team_team_league_season'], 'inner')->where('league_season.id_league_season', $idLeagueSeason)->where('league_season_group.deleted_at IS NULL')->where('league_season.deleted_at IS NULL')->findAll();

        $this->data['tymy'] = $this->footballLib->getRealNamesTeams($this->arrayLib->groupArray($tymy, 'id_league_season_group'));
        $zapasy = $this->league_season->select('date, time, round, league_season_group.id_league_season_group,team_league_season.team_name_in_season as team, oppo.team_name_in_season as oppo,result_team, result_opponent, game.id_game')->join('league_season_group', $this->data['join']['league_season_league_season_group'],'inner')->join('game', $this->data['join']['game_league_season_group'], 'inner')->join('game_team', $this->data['join']['game_game_team'], 'inner')->join('team_league_season', $this->data['join']['team_league_season_game_team_me'], 'inner')->join('team_league_season as oppo', 'oppo.id_team_league_season=game_team.id_opponent', 'inner')->where('game_team.field', 1)->orderBy('round', 'asc')->findAll();
       
        
        
        $group1 = new StdClass();
        $group1->column = 'id_league_season_group';
        $group1->orderBy = 'asc';
        $group2 = new stdClass();
        $group2->column = 'round';
        $group2->orderBy = 'asc';
        $this->data['zapasy'] = $this->arrayLib->groupArrayTwolevel($zapasy, $group1, $group2);

           // var_dump($this->data['zapasy']);
        echo view('backend/team_league_season/index', $this->data);
    }

    public function showGroup($idGroup)
    {
        $this->data['tymy'] = $this->team_league_season->join('team', $this->data['join']['team_team_league_season'], 'inner')->orderBy('general_name', 'asc')->where('id_league_season_group', $idGroup)->findAll();
        $this->data['liga'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where($this->delRows['league_season'])->where($this->delRows['association_season'])->find($idGroup);
        
        echo view('backend/team_league_season/showGroup', $this->data);
    }

    public function add($idGroup)
    {
        $this->data['skupina'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->find($idGroup);
        $this->data['tymy'] = $this->arrayLib->arrayToDropdown($this->footballLib->getAvailableTeams($idGroup), 'id_team', 'general_name');
       
        echo view('backend/team_league_season/add', $this->data);
    }

    public function create()
    {
        $team = $this->request->getPost('team');
        $id_group = $this->request->getPost('id_group');
        $team = array_unique($team);
        $this->team_league_season->transStart();
        foreach ($team as $row) {
            $data = array(
                'id_league_season_group' => $id_group,
                'id_team' => $row
            );
            $this->team_league_season->save($data);
        }

        $this->team_league_season->transComplete();
        $result = $this->team_league_season->transStatus();
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data2);

        $idLeagueSeason = $this->league_season_group->find($id_group)->id_league_season;
        return redirect()->to('admin/liga/' . $idLeagueSeason . '/info');
    }

    public function edit($idGroup, $idTeam)
    {
        $this->data['skupina'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->find($idGroup);
        $this->data['tym'] = $this->team_league_season->join('team', $this->data['join']['team_team_league_season'], 'inner')->find($idTeam);

        echo view('backend/team_league_season/edit', $this->data);
    }

    public function update()
    {

        $name = $this->request->getPost('name_in_season');
        $logo = $this->request->getFile('logo');
        $id_team_in_season = $this->request->getPost('id_team_in_season');

        $data = array(
            'team_name_in_season' => $name,
            'id_team_league_season' => $id_team_in_season
        );
        $updateDB = true;

        //zjistím id týmu a id sezony
        $id_team = $this->team_league_season->find($id_team_in_season)->id_team;
        $id_league_season_group = $this->team_league_season->find($id_team_in_season)->id_league_season_group;
        $id_season = $this->league_season_group->join('league_season', $this->data['join']['league_season_league_season_group'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->where($this->delRows['league_season'])->where($this->delRows['association_season'])->find($id_league_season_group)->id_season;
        //jestli se uploadovalo
        if ($logo->getName() != "") {
            $newName = "logo_tym_" . $id_team . "_" . $id_season;
            $logoUpload = $this->fileLib->uploadFile($logo, $this->data['uploadPath']['logoTeam'], $newName);

            if ($logoUpload["uploaded"]) {
                $data['logo'] = $logoUpload["name"];
            } else {
                //upload se nepodařil
                $result = false;
                $updateDB = false;
            }

            $data2[] =  $this->errorMessage->prepareMessage($logoUpload['uploaded'], 'upload');
        }

        if ($updateDB) {
            $result = $this->team_league_season->save($data);

           
           
            $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
            $this->session->setFlashdata('error', $data2);
            return redirect()->to('admin/liga/' .$id_league_season_group . '/seznam-tymu');
        }
    }
}
