<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\TeamLeagueSeason as Tls;
use App\Models\LeagueSeason;
use App\Models\LeagueSeasonGroup;
use App\Models\Stadium;

use App\Libraries\ArrayLibrary;
use App\Libraries\FootballLibrary;
use App\Libraries\FileLibrary;
use stdClass;

class TeamLeagueSeason extends BaseBackendController
{
    private object $team_league_season;
    private object $league_season;
    private object $league_season_group;
    private object $stadium;
    private object $arrayLib;
    private object $footballLib;
    private object $fileLib;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->team_league_season = new Tls();
        $this->league_season = new LeagueSeason();
        $this->league_season_group = new LeagueSeasonGroup();
        $this->stadium = new Stadium();
        $this->arrayLib = new ArrayLibrary();
        $this->footballLib = new FootballLibrary();
        $this->fileLib = new FileLibrary();
    }

    public function index(int $idLeagueSeason)
    {
        $this->data['liga'] = $this->league_season->join('league_season_group', $this->data['join']['league_season_league_season_group'])->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->where('association_season.deleted_at IS NULL')->find($idLeagueSeason);

        $idLeagueSeason = $this->data['liga']->id_league_season;
        $skupiny = $this->league_season_group->where('id_league_season', $idLeagueSeason)->orderBy('regular', 'asc')->findAll();
        $this->data['skupiny'] = $this->arrayLib->fillNames($skupiny, $this->data['liga']->league_name_in_season);

        $tymy = $this->team_league_season->join('league_season_group', $this->data['join']['league_season_group_team_league_season'], 'inner')->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('team', $this->data['join']['team_team_league_season'], 'inner')->where('league_season.id_league_season', $idLeagueSeason)->where('league_season_group.deleted_at IS NULL')->where('league_season.deleted_at IS NULL')->findAll();

        $this->data['tymy'] = $this->footballLib->getRealNamesTeams($this->arrayLib->groupArray($tymy, 'id_league_season_group'));
        $zapasy = $this->league_season->select('date, time, round, league_season_group.id_league_season_group,team_league_season.team_name_in_season as team, oppo.team_name_in_season as oppo,result_team, result_opponent, game.id_game')->join('league_season_group', $this->data['join']['league_season_league_season_group'], 'inner')->join('game', $this->data['join']['game_league_season_group'], 'inner')->join('game_team', $this->data['join']['game_game_team'], 'inner')->join('team_league_season', $this->data['join']['team_league_season_game_team_me'], 'inner')->join('team_league_season as oppo', 'oppo.id_team_league_season=game_team.id_opponent', 'inner')->where('game_team.field', 1)->orderBy('round', 'asc')->findAll();


        $group1 = new StdClass();
        $group1->column = 'id_league_season_group';
        $group1->orderBy = 'asc';
        $group2 = new stdClass();
        $group2->column = 'round';
        $group2->orderBy = 'asc';
        $this->data['zapasy'] = $this->arrayLib->groupArrayTwolevel($zapasy, $group1, $group2);


        $this->data["rozhodci"] = $this->league_season->select('league_season.*, person.*, country.*, city.*')->join('referee_season', $this->data['join']['league_season_referee_season'], 'inner')->join('person', $this->data['join']['referee_season_person'], 'inner')->join('city', $this->data['join']['person_city'], 'left')->join('country', $this->data['join']['person_country'], 'inner')->where('referee_season.id_league_season', $idLeagueSeason)->orderBy('last_name', 'asc')->findAll();

        $thisSeason = $this->data['liga']->start;
        $nextSeason = $thisSeason + 1;
        $lastSeason = $thisSeason - 1;

        $idLeague = $this->data['liga']->id_league;
        $this->data['lastSeasonData'] = $this->league_season->getLeagueSeasonByStart($lastSeason, $idLeague);
        $this->data['nextSeasonData'] = $this->league_season->getLeagueSeasonByStart($nextSeason, $idLeague);


        echo view('backend/team_league_season/index', $this->data);
    }

    public function showGroup(int $idGroup)
    {
        $this->data['tymy'] = $this->team_league_season->select('team_league_season.id_team, team_league_season.id_team_league_season, team.general_name as general_name, team_league_season.team_name_in_season, team_league_season.logo, stadium.general_name as stadium_general_name, team_league_season.stadium_name_in_season, city.name_de ')->join('team', $this->data['join']['team_team_league_season'], 'inner')->join('stadium', $this->data['join']['team_league_season_stadium'], 'left')->join('city', $this->data['join']['city_stadium'], 'left')->orderBy('team.general_name', 'asc')->where('id_league_season_group', $idGroup)->findAll();
        //var_dump($this->data['tymy']);
        $this->data['liga'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where($this->delRows['league_season'])->where($this->delRows['association_season'])->find($idGroup);
        $idLeague = $this->data['liga']->id_league;


        $thisSeason = $this->data['liga']->start;
        $nextSeason = $thisSeason + 1;
        $lastSeason = $thisSeason - 1;

        $this->data['lastSeason'] = $this->league_season->getLeagueSeasonByStart($lastSeason, $idLeague);
        $this->data['nextSeason'] = $this->league_season->getLeagueSeasonByStart($nextSeason, $idLeague);

        var_dump($this->data['lastSeason']);
        var_dump($this->data['nextSeason']);
        echo view('backend/team_league_season/showGroup', $this->data);
    }

    public function add(int $idGroup)
    {
        $this->data['skupina'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->find($idGroup);
        $this->data['tymy'] = $this->arrayLib->arrayToDropdown($this->footballLib->getAvailableTeams($idGroup), 'id_team', 'general_name');
        // $tym = $this->footballLib->getAvailableTeams($idGroup);

        $startSezona = $this->data['skupina']->start;
        $skupina = $this->data['skupina']->id_league_season_group;
        $this->data['minulaSezonaTymy'] = $this->footballLib->getTeamsFromLastSeason($startSezona, $skupina);
        $this->data['tatoSezonaTymy'] = $this->arrayLib->transformArray($this->team_league_season->join('team', $this->data['join']['team_league_season_team'], 'inner')->where('id_league_season_group', $idGroup)->findAll(), 'id_team');

        echo view('backend/team_league_season/add', $this->data);
    }

    public function create()
    {
        $team = $this->request->getPost('team');
        $id_group = $this->request->getPost('id_group');
        $team = array_unique($team);

        $vlozeneTymy = $this->arrayLib->transformArray($this->team_league_season->where('id_league_season_group', $id_group)->findAll(), 'id_team');
        $tymy = $this->arrayLib->compareArrays($team, $vlozeneTymy, 'id_team', 'status');

        $this->team_league_season->transStart();
        foreach ($tymy as $row) {
            $data = array(
                'id_league_season_group' => $id_group,
                'id_team' => $row->id_team
            );
            switch ($row->status) {
                case 0:
                    break;
                case 1:
                    $this->team_league_season->save($data);
                    break;
                case 2:
                    $data['id_team_league_season'] = $this->team_league_season->where('id_team', $row->id_team)->where('id_league_season_group', $id_group)->findAll()[0]->id_team_league_season;
                    $this->team_league_season->save($data);
                    break;
                default:
                    break;
            }
        }

        $this->team_league_season->transComplete();
        $result = $this->team_league_season->transStatus();
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data2);

        $idLeagueSeason = $this->league_season_group->find($id_group)->id_league_season;
        return redirect()->to('admin/liga/' . $idLeagueSeason . '/info');
    }

    public function edit(int $idGroup, int $idTeam)
    {
        $this->data['skupina'] = $this->league_season_group->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->find($idGroup);
        $teamLeagueSeason = $this->team_league_season->where('id_team', $idTeam)->where('id_league_season_group', $idGroup)->findAll()[0]->id_team_league_season;

        $this->data['tym'] = $this->team_league_season->join('team', $this->data['join']['team_team_league_season'], 'inner')->find($teamLeagueSeason);
        $this->data['stadion'] = $this->stadium->join('city', $this->data['join']['city_stadium'], 'inner')->orderBy('name_de', 'asc')->findAll();

        $stadiumName = $this->stadium->orderBy('general_name', 'asc')->findAll();
        $this->data['stadiumName'] = json_encode($this->arrayLib->arrayToDropdown($stadiumName, 'id_stadium', 'general_name'));

        $thisSeason = $this->data['skupina']->start;

        $lastSeason = $thisSeason - 1;


        $this->data['lastSeasonData'] = $this->team_league_season->select('team_league_season.*, stadium.*, city.*, league_season_group.id_league_season')->join('stadium', $this->data['join']['team_league_season_stadium'], 'inner')->join('city', $this->data['join']['stadium_city'], 'inner')->join('league_season_group', $this->data['join']['team_league_season_league_season_group'], 'inner')->join('league_season', $this->data['join']['league_season_group_league_season'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->where('start', $lastSeason)->where('team_league_season.id_team', $idTeam)->first();

        echo view('backend/team_league_season/edit', $this->data);
    }

    public function update()
    {

        $name = $this->request->getPost('name_in_season');
        $logo = $this->request->getFile('logo');
        $stadium = $this->request->getPost('stadium');
        $id_team_in_season = $this->request->getPost('id_team_in_season');
        $stadium_name_in_season = $this->request->getPost('stadium_name_in_season');
        $logoPath = $this->request->getPost('logoPath');

        $data = array(
            'team_name_in_season' => $name,
            'id_team_league_season' => $id_team_in_season,
            'id_stadium' => $stadium,
            'stadium_name_in_season' => $stadium_name_in_season
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
        } else{
            if($logoPath != ""){
                $data['logo'] = $logoPath;
            }
        }

        if ($updateDB) {
            $result = $this->team_league_season->save($data);



            $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
            $this->session->setFlashdata('error', $data2);
            return redirect()->to('admin/liga/' . $id_league_season_group . '/seznam-tymu');
        }
    }
    /**
     * $idTym - id_team_league_season
     */
    public function delete(int $idLiga, int $idTym)
    {


        $result = $this->team_league_season->delete($idTym);

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->to('admin/liga/' . $idLiga . '/seznam-tymu');
    }

    public function editAll($idGroup) {}

    public function manageTeam(int $idGroup, int $idTeam)
    {

        $this->data['team'] = $this->team_league_season->where('id_league_season_group', $idGroup)->where('id_team', $idTeam)->findAll()[0];
        echo view('backend/team_league_season/manage', $this->data);
    }
}
