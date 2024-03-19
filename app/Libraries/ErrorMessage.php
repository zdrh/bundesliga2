<?php

namespace App\Libraries;

use Config\Main;

class ErrorMessage
{

    var $config;
    var $session;

    public function __construct()
    {
        $this->config = new Main();
        $this->session = \Config\Services::session();
    }
    /**
     * vygeneruje hlášky pro jednotlivé stavy
     * @param $error - dvojrozměrné pole - první rozměr je pole s jednotlivými stavy, druhý rozměr je pole, kde pod klíčem 0 je stav (true, false) a pod druhým klíčem typ operace
     */
    public function makeErrorMessage($error) {
        $result = array();
        foreach ($error as $row) {
            if($row[0]) {
                $mess = $row[1].'Success';
                $result[] = array(
                    'message' => $this->config->errorMessage[$mess],
                    'class' => 'success',
                    'real' => true
                );
            } else {
                $mess = $row[1].'Error';
                $result[] = array(
                    'message' => $this->config->errorMessage[$mess],
                    'class' => 'danger',
                    'real' => true
                );
            }
        }
        $this->session->setFlashdata('error', $result);
        
    }
}



