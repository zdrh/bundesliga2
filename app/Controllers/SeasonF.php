<?php

namespace App\Controllers;

use App\Controllers\BaseFrontendController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Season;

use App\Libraries\ArrayLibrary;
use App\Libraries\FootballLibrary;

use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class SeasonF extends BaseFrontendController
{
    var $season;
    var $arrayLib;
    var $footballLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->season = new Season();
        $this->arrayLib = new ArrayLibrary();
        $this->footballLib = new FootballLibrary();
    }
    public function index()
    {

        $sezony = $this->season->orderBy('start', 'desc')->findAll();
        $sezony = $this->footballLib->getSeasons($sezony, 'sezona', '-');
        $this->data['sezony'] = $this->arrayLib->arrayToDropdown($sezony, 'id_season', 'sezona');
        echo view ('frontend/season/index', $this->data);
    }

    public function view() {
        $sezona = $this->request->getPost('season');
        $season = $this->season->find($sezona);
        $sezonaString = $season->start.'-'.$season->finish;
        return redirect()->to('sezona/zobraz/'.$sezonaString.'/'.$season->id_season);
    }

    public function show($id_season)
    {
        $this->data['sezona'] = $this->season->find($id_season);
        $this->data['souteze'] = $this->season->select('league_season.league_name_in_season, league_season.id_league_season, association_season.name, association.id_association, league.level, league_season.logo')->join('association_season', $this->data['join']['association_season_season'],'inner')->join('league_season', $this->data['join']['association_season_league_season'])->join('league', $this->data['join']['league_league_season'], 'inner')->join('association', $this->data['join']['association_season_association'], 'inner')->where('season.id_season', $id_season)->where('association_season.deleted_at IS NULL')->where('league_season.deleted_at IS NULL')->orderBy('league.level', 'asc')->findAll();

        echo view ('frontend/season/show', $this->data);
    }
}
