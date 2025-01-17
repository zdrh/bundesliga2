<?php

namespace App\Controllers;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseFrontendController;
use Psr\Log\LoggerInterface;




class Main extends BaseFrontendController
{
    
    var $submenu;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->data['subMenu'] = NULL;
    }

    public function index()
    {
       
        echo view('frontend/main/index', $this->data);
    }
}
