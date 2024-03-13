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
        if($this->session->message) {
            $this->data['message'] = $this->session->message;
            $this->data['type'] = $this->session->type;
        }
        echo view('frontend/auth/loginform', $this->data);
    }

    public function logout()
    {
    }
}
