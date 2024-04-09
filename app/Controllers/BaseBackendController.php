<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Menu;



class BaseBackendController extends BaseController
{
    var $mainConfig;
    

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $menu = new Menu();
        $this->data['menu'] = $menu->where('type', 2)->orderBy('priority', 'desc')->findAll();
        
       
        
       
        $this->data["year"] = $this->mainConfig->year;
       
        $this->data["tableTemplateFixture"] = $this->mainConfig->templateFixture;
        $this->data["uploadFolder"] = $this->mainConfig->uploadPath;
    }
}
