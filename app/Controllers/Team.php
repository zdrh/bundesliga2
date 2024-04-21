<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Team as T;

use App\Libraries\ArrayLibrary;

class Team extends BaseBackendController
{

    var $team;
    var $arrayLib;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->team = new T();
        $this->arrayLib = new ArrayLibrary();
    }

    public function index()
    {
        $tymy = $this->team->orderBy('general_name', 'asc')->paginate($this->mainConfig->perPage);
        $seznamTymu = $this->team->findAll();
        $this->data['tymy'] = $this->arrayLib->addFollower($tymy, $seznamTymu);
        $this->data['pager'] = $this->team->pager;
        //var_dump($this->data);
        echo view('backend/team/index', $this->data);
    }

    public function add()
    {
        $this->data['tymy'] = $this->team->orderBy('general_name', 'asc')->findAll();
        echo view('backend/team/add', $this->data);
    }

    public function create()
    {
        $name = $this->request->getPost('name');
        $shortName = $this->request->getPost('short_name');
        $founded = $this->request->getPost('founded');
        $dissolved = $this->request->getPost('dissolved');
        $follower = $this->request->getPost('follower');
        $this->team->transStart();
        foreach ($name as $key => $row) {
            if($follower[$key] == "") {
                $follow = NULL;
            } else {
                $follow = $follower[$key];
            }
            if($dissolved[$key] == "") {
                $dissolve = NULL;
            } else {
                $dissolve = $follower[$key];
            }
            $dataDb = array(
                'founded' => $founded[$key],
                'general_name' => $row,
                'short_name' => $shortName[$key],
                'dissolve' => $dissolve,
                'follower' => $follow
            );
            $this->team->save($dataDb);
        }

        $this->team->transComplete();
        $result = $this->team->transStatus();

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data);


        return redirect()->to('admin/seznam-tymu');
    }

    public function import()
    {

        echo view('backend/team/import', $this->data);
    }

    public function createImport()
    {
        $teams = $this->request->getFile('import');
        $string = fopen($teams->getTempName(), "r");
        while (($data = fgetcsv($string, 1000, ";")) !== FALSE) {
            $array[] = $data;
        }

        fclose($string);
        $names = array('founded', 'general_name', 'short_name', 'dissolve', 'follower');
        $result = $this->arrayLib->testArray($array, $names);

        $this->team->transStart();
        foreach ($result as $row) {
            $data = array(
                'founded' => $row->founded,
                'general_name' => $row->general_name,
                'short_name' => $row->short_name,
                'dissolve' => $row->dissolve,
                'follower' => $row->follower
            );

            $this->team->save($data);
        }

        $this->team->transComplete();
        $result = $this->team->transStatus();

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data);


        return redirect()->to('admin/seznam-tymu');
    }

    public function edit($id_team)
    {
        $this->data['tym'] = $this->team->find($id_team);
        $this->data['tymy'] = $this->team->orderBy('general_name', 'asc')->findAll();
        echo view('backend/team/edit', $this->data);
    }

    public function update() {
        $name = $this->request->getPost('name');
        $shortName = $this->request->getPost('short_name');
        $founded = $this->request->getPost('founded');
        $dissolved = $this->request->getPost('dissolved');
        $follower = $this->request->getPost('follower');
        $id_team = $this->request->getPost('id_team');
        if($dissolved == 0) {
            $dissolved = NULL;
        }
        $dataDb = array(
            'founded' => $founded,
            'general_name' => $name,
            'short_name' => $shortName,
            'dissolve' => $dissolved,
            'follower' => $follower,
            'id_team' => $id_team
        );
       $result = $this->team->save($dataDb);

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data);

        return redirect()->to('admin/seznam-tymu');
    }

    public function delete($idTeam) {
        $result = $this->team->delete($idTeam);

        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);

        return redirect()->to('admin/seznam-tymu');
    }
}
