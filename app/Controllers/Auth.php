<?php

namespace App\Controllers;

use App\Controllers\BaseFrontendController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Auth extends BaseFrontendController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function login()
    {
       
        echo view('frontend/auth/login', $this->data);
        
    }

    public function loginComplete() {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('pswd');

        $loggedIn = $this->ionAuth->login($login, $password);
        if($loggedIn) {
            return redirect()->to('admin/dashboard');
        } else {
            $pole[] = [$loggedIn, 'login'];
            $this->errorMessage->makeErrorMessage($pole);
        
            return redirect()->to('login');
        }
    }

    public function logout()
    {
        $this->ionAuth->logout();
        return redirect()->to('/');
    }
}
