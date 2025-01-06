<?php

namespace App\Controllers;

use App\Controllers\BaseFrontendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Libraries\StringLibrary;

class Auth extends BaseFrontendController
{
    var $string;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->string = new StringLibrary();
        $this->data['subMenu'] = NULL;
    }

    public function login()
    {

        echo view('frontend/auth/login', $this->data);
    }

    public function loginComplete()
    {

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('pswd');

        $loggedIn = $this->ionAuth->login($login, $password);
        if ($loggedIn) {
            if (isset($this->session->lastPage)) {
                //var_dump($this->session->lastPage);
                $route = $this->string->getRoute($this->session->lastPage);
                $routeAdmin = $this->string->getAdmin($route);
                if ($routeAdmin) {
                    return redirect()->to($route);
                }
                return redirect()->to('admin/dashboard');
            } else {
                return redirect()->to('admin/dashboard');
            }
        } else {
            
            $data[] =  $this->errorMessage->prepareMessage($loggedIn, 'login');
            $this->session->setFlashdata('error', $data);
    

            return redirect()->to('login');
        }
    }

    public function logout()
    {
        $this->ionAuth->logout();
        return redirect()->to('/');
    }
}
