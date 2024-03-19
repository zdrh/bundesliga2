<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Menu;
use App\Libraries\ErrorMessage;


class BaseBackendController extends BaseController
{
    var $mainConfig;
    var $errorMessage;

    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $menu = new Menu();
        $this->data['menu'] = $menu->where('type', 2)->orderBy('priority', 'desc')->findAll();
        
        $this->errorMessage = new ErrorMessage();
        
        $this->data["form"] = $this->mainConfig->form;
        $this->data["year"] = $this->mainConfig->year;
        $this->data["tableTemplate"] = $this->mainConfig->template;
        $this->data["uploadFolder"] = $this->mainConfig->uploadPath;
    }
}
