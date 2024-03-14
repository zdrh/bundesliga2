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

    }

    public function edit($id) {

    }

    public function update() {

    }

    public function delete() {

    }
}
