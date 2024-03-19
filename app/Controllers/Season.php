<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Season as SeasonModel;


class Season extends BaseBackendController
{
    var $seasonModel;
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->seasonModel = new SeasonModel();
        
       
    }

    public function index()
    {
        $this->data["sezony"] = $this->seasonModel->orderBy('start', 'asc')->findAll();
        echo view('backend/season/index', $this->data);
    }

    public function add() {

        echo view('backend/season/add', $this->data);

    }

    public function create() {
        $start = $this->request->getPost('start');
        $finish = $this->request->getPost('finish');

        $data = array(
            'start' => $start,
            'finish' => $finish,
        );
        foreach($start as $key => $row) {
            $data = array(
                'start' => $row,
                'finish' => $finish[$key]
            );
           $result =  $this->seasonModel->save($data);
        }

        //generování hlášek
        
        $pole[] = [$result, 'dbAdd'];
        $this->errorMessage->makeErrorMessage($pole);
        
       
        return redirect()->route('admin/seznam-sezon');
    }

    public function edit($id) {
        
        $this->data['sezona'] = $this->seasonModel->find($id);
        echo view('backend/season/edit', $this->data);
    }

    public function update() {
        $start = $this->request->getPost('start');
        $finish = $this->request->getPost('finish');
        $id_season = $this->request->getPost('id_season');
        $data = array(
            'start' => $start,
            'finish' => $finish,
            'id_season' => $id_season
        );
        $result = $this->seasonModel->save($data);

        $pole[] = [$result, 'dbEdit'];
        $this->errorMessage->makeErrorMessage($pole);


        return redirect()->route('admin/seznam-sezon');
    }

    public function delete($id) {
        $result = $this->seasonModel->delete($id);

        $pole[] = [$result, 'dbDelete'];
        $this->errorMessage->makeErrorMessage($pole);

        return redirect()->route('admin/seznam-sezon');
    }
}
