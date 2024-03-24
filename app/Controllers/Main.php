<?php

namespace App\Controllers;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseFrontendController;
use Psr\Log\LoggerInterface;




class Main extends BaseFrontendController
{
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
    }

    public function index()
    {
       // var_dump($this->session->lastPage);
        echo view('frontend/main/index', $this->data);
    }
}
