<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Menu;

class BaseFrontendController extends BaseController
{
    
    
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $menu = new Menu();
        $this->data['menu'] = $menu->where('type', 1)->orderBy('priority', 'desc')->findAll();
    }
}
