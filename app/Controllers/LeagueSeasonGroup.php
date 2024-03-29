<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\LeagueSeasonGroup as LsGroup;
use App\Models\LeagueSeason;

class LeagueSeasonGroup extends BaseBackendController
{

    var $leagueSeasonGroup;
    var $leagueSeason;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->leagueSeasonGroup = new LsGroup();
        $this->leagueSeason = new LeagueSeason();
    }

    public function index($idLeague, $idSeason)
    {
        $idLeagueSeason = $this->leagueSeason->join('association_season', $this->data['join']['league_season_association_season'])->where('id_league', $idLeague)->where('id_season', $idSeason)->findAll()[0]->id_league_season;

        $this->data['liga'] = $this->leagueSeason->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->find($idLeagueSeason);
        $this->data['skupiny'] = $this->leagueSeasonGroup->where('id_league_season', $idLeagueSeason)->findAll();

        echo view('backend/league_season_group/index', $this->data);
    }

    public function add($idLeague, $idSeason)
    {
        $this->data['idLeagueSeason'] = $this->leagueSeason->join('association_season', $this->data['join']['league_season_association_season'])->where('id_league', $idLeague)->where('id_season', $idSeason)->findAll()[0]->id_league_season;
        $this->data['liga'] = $this->leagueSeason->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->find($this->data['idLeagueSeason']);

        echo view('backend/league_season_group/add', $this->data);
    }

    public function create()
    {
        $groupName = $this->request->getPost('groupname');
        $regular = $this->request->getPost('regular');
        $id_league_season = $this->request->getPost('id_league_season');

        $data = array(
            'groupname' => $groupName,
            'regular' => $regular,
            'id_league_season' => $id_league_season
        );

        $result = $this->leagueSeasonGroup->save($data);

        $pole[] = $this->errorMessage->prepareMessage($result, 'dbAdd');

        $this->session->setFlashdata('error', $pole);

        $liga = $this->leagueSeason->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->where('id_league_season', $id_league_season)->findAll()[0];

        return redirect()->to('admin/liga/' . $liga->id_league . '/sezona/' . $liga->id_season . '/seznam-skupin');
    }

    public function edit($idLeague, $idSeason, $idGroup)
    {
        $this->data['league_season_group'] = $this->leagueSeasonGroup->find($idGroup);
        $idLeagueSeason = $this->data['league_season_group']->id_league_season;
        $this->data['liga'] = $this->leagueSeason->join('league', $this->data['join']['league_season_league'], 'inner')->join('association_season', $this->data['join']['league_season_association_season'], 'inner')->join('season', $this->data['join']['season_association_season'], 'inner')->find($idLeagueSeason);

        echo view('backend/league_season_group/edit', $this->data);
    }


    public function update()
    {
        $groupName = $this->request->getPost('groupname');
        $regular = $this->request->getPost('regular');
        $id_league_season_group = $this->request->getPost('id_league_season_group');

        $data = array(
            'groupname' => $groupName,
            'regular' => $regular,
            'id_league_season_group' => $id_league_season_group
        );

        $result = $this->leagueSeasonGroup->save($data);

        $pole[] = $this->errorMessage->prepareMessage($result, 'dbEdit');

        $this->session->setFlashdata('error', $pole);
        $skupina = $this->leagueSeasonGroup->find($id_league_season_group);
        $liga = $this->leagueSeason->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->where('id_league_season', $skupina->id_league_season)->findAll()[0];

        return redirect()->to('admin/liga/' . $liga->id_league . '/sezona/' . $liga->id_season . '/seznam-skupin');
    }

    public function delete($idLeague, $idSeason, $idGroup)
    {
        $skupina = $this->leagueSeasonGroup->find($idGroup);
        $result = $this->leagueSeasonGroup->delete($idGroup);

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        
        $liga = $this->leagueSeason->join('association_season', $this->data['join']['association_season_league_season'], 'inner')->find($skupina->id_league_season);
        return redirect()->to('admin/liga/' . $liga->id_league . '/sezona/' . $liga->id_season . '/seznam-skupin');
    }
}
