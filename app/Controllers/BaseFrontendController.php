<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Menu;
use App\Models\Season;


class BaseFrontendController extends BaseController
{
    var $menu;
    var $season;
    
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->menu = new Menu();
        $this->season = new Season();
        $this->data['menu'] = $this->menu->where('type', 1)->orderBy('priority', 'desc')->findAll();
        $logged = $this->ionAuth->loggedIn();
        if($logged) {
            $this->data['logged'] = true;
        } else {
            $this->data['logged'] = false;
        }

        $this->data["sezony"] = $this->season->orderBy('start', 'desc')->findAll();
        $this->data['subMenu'] = NULL;

    }
}
