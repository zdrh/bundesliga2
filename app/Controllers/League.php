<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\League as LeagueModel;
use App\Models\Association;

class League extends BaseBackendController
{

    var $league;
    var $association;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->league = new LeagueModel();
        $this->association = new Association();
    }
    public function index()
    {
        
        $this->data['ligy'] = $this->league->join('association', 'association.id_association=league.id_association')->orderBy('active', 'DESC')->orderBy('level', 'ASC')->orderBy('name', 'asc')->findAll();

        echo view('backend/league/index', $this->data);
    }

    public function add()
    {
        $this->data['svazy'] = $this->association->orderBy('general_name', 'asc')->findAll();
        echo view('backend/league/add', $this->data);
    }

    public function create() {
        $name = $this->request->getPost('name');
        $level = $this->request->getPost('level');
        $active = $this->request->getPost('active');
        $association = $this->request->getPost('association');

        $data = array(
            'name' => $name,
            'level' => $level,
            'active' => $active,
            'id_association' => $association
        );

        $result =  $this->league->save($data);

        
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbAdd');
        $this->session->setFlashdata('error', $data2);


        return redirect()->route('admin/seznam-lig');
    }
    public function edit($id_league)
    {
        $this->data['liga'] = $this->league->find($id_league);
        $this->data['svazy'] = $this->association->orderBy('general_name', 'asc')->findAll();
        echo view('backend/league/edit', $this->data);
    }

    public function update() {
        $name = $this->request->getPost('name');
        $level = $this->request->getPost('level');
        $active = $this->request->getPost('active');
        $association = $this->request->getPost('association');
        $league = $this->request->getPost('league');

        $data = array(
            'name' => $name,
            'level' => $level,
            'active' => $active,
            'id_association' => $association,
            'id_league' => $league
        );

        $result =  $this->league->save($data);

        
        $data2[] =  $this->errorMessage->prepareMessage($result, 'dbEdit');
        $this->session->setFlashdata('error', $data2);


        return redirect()->route('admin/seznam-lig');
    }

    public function delete($id_league)
    {
        $result = $this->league->delete($id_league);

       
        $data[] =  $this->errorMessage->prepareMessage($result, 'dbDelete');
        $this->session->setFlashdata('error', $data);


        return redirect()->route('admin/seznam-lig');
    }
}
