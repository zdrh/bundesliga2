<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\AssociationSeason as AsocSeason;
use App\Models\Association;
use App\Models\Season;
use App\Models\Sql;

use App\Libraries\ArrayLibrary;
use App\Libraries\FileLibrary;

class AssociationSeason extends BaseBackendController
{
    var $assocSeason;
    var $association;
    var $season;
    var $arrayLib;
    var $sql;
    var $fileLib;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->assocSeason = new AsocSeason();
        $this->association = new Association();
        $this->season = new Season();
        $this->sql = new Sql();
        $this->arrayLib = new ArrayLibrary();
        $this->fileLib = new  FileLibrary();
    }

    public function index($id_association)
    {
        $this->data['svaz'] = $this->association->find($id_association);
        $sezony = $this->assocSeason->select('association_season.name as assoc_name, association_season.logo, season.start, season.finish, season.id_season, league_season.league_name_in_season, league.name as league_name')->join('season', 'season.id_season=association_season.id_season', 'inner')->join('league_season', 'league_season.id_assoc_season=association_season.id_assoc_season', 'inner')->join('league', 'league.id_league=league_season.id_league', 'inner')->where('association_season.id_association', $id_association)->orderBy('start', 'asc')->orderBy('league.level', 'asc')->findAll();
        $this->data['sezony'] = $this->arrayLib->groupArray($sezony, 'id_season');

        echo view('backend/association_season/index', $this->data);
    }

    public function add($id_association)
    {

        $this->data['svaz'] = $this->association->find($id_association);
        $this->data['sezony'] = $this->sql->query1($id_association);

        echo view('backend/association_season/add', $this->data);
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        $logo = $this->request->getFile('logo');
        $season = $this->request->getPost('season');
        $id_association = $this->request->getPost('id_association');
        $assoc = $this->association->find($id_association);
        $newName = "logo_" . $assoc->short_name . "_" . $id_association . "_" . $season;

        $logoUpload = $this->fileLib->uploadFile($logo, $this->data['uploadPath']['logoAssoc'], $newName);

        if ($logoUpload["uploaded"]) {
            $data = array(
                'id_season' => $season,
                'id_association' => $id_association,
                'name' => $name,
                'logo' => $logoUpload["name"]
            );

            $result = $this->assocSeason->save($data);
        } else {
            $result = false;
        }

        //generování hlášek
        $pole[] = [$logoUpload['uploaded'], 'upload'];
        $pole[] = [$result, 'dbAdd'];
        $this->errorMessage->makeErrorMessage($pole);

        return redirect()->to('admin/svaz/' . $id_association . '/seznam-sezon');
    }
}
