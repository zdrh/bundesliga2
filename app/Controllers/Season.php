<?php

namespace App\Controllers;

use App\Controllers\BaseBackendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Season as SeasonModel;
use Config\Main as MainConfig;
class Season extends BaseBackendController
{
    var $seasonModel;
    var $mainConfig;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->seasonModel = new SeasonModel();
        $this->mainConfig = new MainConfig();
        $this->data["form"] = $this->mainConfig->form;
        $this->data["year"] = $this->mainConfig->year;
        $this->data["tableTemplate"] = $this->mainConfig->template;
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
            $this->seasonModel->save($data);
        }
        
       
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
        $this->seasonModel->save($data);
        return redirect()->route('admin/seznam-sezon');
    }

    public function delete($id) {
        $this->seasonModel->delete($id);
        return redirect()->route('admin/seznam-sezon');
    }
}
