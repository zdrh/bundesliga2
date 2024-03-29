<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeason as LgSeason;
use App\Models\League;
use App\Models\Sql;
use App\Models\AssociationSeason;
use App\Models\Season;
use App\Models\LeagueSeasonGroup;

use App\Libraries\FileLibrary;
use stdClass;

class LeagueSeason extends BaseBackendController
{

    var $leagueSeason;
    var $league;
    var $season;
    var $sql;
    var $fileLib;
    var $associationSeason;
    var $leagueSeasonGroup;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->leagueSeason = new LgSeason();
        $this->league = new League();
        $this->season = new Season();
        $this->sql = new Sql();
        $this->associationSeason = new AssociationSeason();
        $this->leagueSeasonGroup = new LeagueSeasonGroup();
        $this->fileLib = new FileLibrary();
    }

    public function index($idLeague)
    {
        $this->data['liga'] = $this->league->find($idLeague);
        $this->data['sezony'] = $this->leagueSeasonGroup->select('season.start, season.finish, league.id_league, league.name as league_name, league_season.league_name_in_season, league_season.logo, league_season.groups, season.id_season, association_season.name as association_name, league_season.id_league_season, Count(*) as pocet')->join('league_season', $this->data['join']['league_season_league_season_group'], 'inner')->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['association_season_season'], 'inner')->where('league.id_league', $idLeague)->groupBy('league_season.id_league_season')->orderBy('start', 'asc')->findAll();

        //var_dump($this->data['sezony']);
        echo view('backend/league_season/index', $this->data);
    }

    public function add($idLeague)
    {
        $this->data['liga'] = $this->league->find($idLeague);
        $id_association = $this->league->find($idLeague)->id_association;
       // $this->data['sezony'] = $this->sql->query2($idLeague, $id_association);
       $this->data['sezony'] = $this->season->join('association_season', 'season.id_season=association_season.id_season', 'inner')->join('league_season', 'league_season.id_assoc_season=association_season.id_assoc_season','left')->where('association_season.id_association', $id_association)->where('league_season.id_league', $idLeague)->orderBy('season.start', 'asc')->findAll();
      // var_dump($this->data['sezony']);
        echo view('backend/league_season/add', $this->data);
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        $logo = $this->request->getFile('logo');
        $season = $this->request->getPost('season');
        $groups = $this->request->getPost('groups');
        $id_association = $this->request->getPost('id_association');
        $id_league = $this->request->getPost('id_league');
        $groupsList = $this->request->getPost('groupsList');
        $groupsType = $this->request->getPost('groupsType');


        $id_assoc_season = $this->associationSeason->where('id_association', $id_association)->where('id_season', $season)->findAll()[0]->id_assoc_season;

        $newName = "logo_liga_" . $id_league . "_" . $season;

        $logoUpload = $this->fileLib->uploadFile($logo, $this->data['uploadPath']['logoLeague'], $newName);

        if ($logoUpload["uploaded"]) {
            $data = array(
                'id_league' => $id_league,
                'id_assoc_season' => $id_assoc_season,
                'logo' => $logoUpload["name"],
                'league_name_in_season' => $name,
                'groups' => $groups
            );
            $this->leagueSeason->transStart();
            $result = $this->leagueSeason->save($data);

            //vložení skupin do skupin
            $id_league_season = $this->leagueSeason->getInsertID();

            if ($groups == 2) {
                foreach ($groupsList as $key => $group) {
                    $dataGroup = array(
                        'groupname' => $group,
                        'regular' => $groupsType[$key],
                        'id_league_season' => $id_league_season
                    );
                    $this->leagueSeasonGroup->save($dataGroup);
                }
            } else {
                $dataGroup = array(
                    'regular' => 1,
                    'id_league_season' => $id_league_season
                );
               $this->leagueSeasonGroup->save($dataGroup);
            }

            $this->leagueSeason->transComplete();
            $result = $this->leagueSeason->transStatus();
        } else {
            $result = false;
        }

        //generování hlášek
        
        $pole[] = $this->errorMessage->prepareMessage($logoUpload['uploaded'], 'upload');
        $pole[] = $this->errorMessage->prepareMessage($result, 'dbAdd', 'Sezona ligy');
        
        $this->session->setFlashdata('error', $pole);

        return redirect()->to('admin/liga/' . $id_league . '/seznam-sezon');
    }

    public function edit($idLeague, $idSeason)
    {
        $id_association = $this->league->join('association_season', 'association_season.id_association=league.id_association')->where('association_season.id_season', $idSeason)->find($idLeague);
        $this->data['sezony'] = $this->sql->query2($idLeague, $id_association->id_association);
        $id_league_season = $this->leagueSeason->where('id_league', $idLeague)->where('id_assoc_season', $id_association->id_assoc_season)->findAll()[0]->id_league_season;
        $this->data['league_season'] = $this->leagueSeason->find($id_league_season);
        //  $this->data['league_season_groups'] = $this->leagueSeasonGroup->where('id_league_season', $id_league_season)->findAll();
        $this->data['league'] = $this->league->find($idLeague);
        echo view('backend/league_season/edit', $this->data);
    }

    public function update()
    {
        $name = $this->request->getPost('name');
        $logo = $this->request->getFile('logo');
        $season = $this->request->getPost('season');
        $groups = $this->request->getPost('groups');
        $id_league = $this->request->getPost('id_league');
        $id_assoc_season = $this->request->getPost('id_assoc_season');
        $id_league_season = $this->request->getPost('id_league_season');
        $groupsList = $this->request->getPost('groupsList');
        $groupsType = $this->request->getPost('groupsType');
        $data = array(
            'id_league' => $id_league,
            'id_assoc_season' => $id_assoc_season,
            'league_name_in_season' => $name,
            'groups' => $groups,
            'id_league_season' => $id_league_season
        );
        $updateDB = true;
        //jestli se uploadovalo
        if ($logo->getName() != "") {
            $newName = "logo_liga_" . $id_league . "_" . $season;
            $logoUpload = $this->fileLib->uploadFile($logo, $this->data['uploadPath']['logoLeague'], $newName);

            if ($logoUpload["uploaded"]) {
                $data['logo'] = $logoUpload["name"];
            } else {
                //upload se nepodařil
                $result = false;
                $updateDB = false;
            }
        }

        if ($updateDB) {
            $this->leagueSeason->transStart();
            $result = $this->leagueSeason->save($data);

            //vložení skupin do skupin


            foreach ($groupsList as $key => $group) {
                $dataGroup = array(
                    'groupname' => $group,
                    'regular' => $groupsType[$key],
                    'id_league_season' => $id_league_season
                );
                $this->leagueSeasonGroup->save($dataGroup);
            }

            $this->leagueSeason->transComplete();
            $result = $this->leagueSeason->transStatus();
        } else {
            $result = false;
        }
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbelete');
        $this->session->setFlashdata('error', $data);
        return redirect()->to('admin/liga/' . $id_league . '/seznam-sezon');
    }

    public function delete($id_league, $id_season) {
        $id_assoc_season = $this->associationSeason->join('association', 'association_season.id_association=association.id_association', 'inner')->join('league', 'league.id_association=association.id_association', 'inner')->where('league.id_league', $id_league)->where('association_season.id_season', $id_season)->findAll()[0]->id_assoc_season;
        $id_league_season = $this->leagueSeason->where('id_league', $id_league)->where('id_assoc_season', $id_assoc_season)->findAll()[0]->id_league_season;
        
        
        $this->leagueSeason->transStart();
        $result = $this->leagueSeason->delete($id_league_season);
        $this->leagueSeasonGroup->where('id_league_season', $id_league_season)->delete();
        $this->leagueSeason->transComplete();
        $result = $this->leagueSeason->transStatus();
        
       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


       return redirect()->to('admin/liga/' . $id_league . '/seznam-sezon');

    }
}
