<?php

namespace App\Libraries;

use Config\Main;
use stdClass;

class ErrorMessage
{

    var $config;
    var $session;

    public function __construct()
    {
        $this->config = new Main();
        $this->session = \Config\Services::session();
    }

    public function prepareMessage($status, $type, $text = '', $real = true) {
        $data = new stdClass();
        $data->status = $status;
        if($status) {
            $data->type = $type.'Success';
            $data->class = 'success';

        } else {
            $data->type = $type.'Error';
            $data->class = 'danger';
        }
        if($real){
            $data->message = $this->config->errorMessage[$data->type];
        } else {
            $data->message = "";
        }
        
        $data->text = $text;
        $data->real = $real;
        return $data;

    }
    /**
     * vygeneruje hlášky pro jednotlivé stavy
     * @param $error - dvojrozměrné pole - první rozměr je pole s jednotlivými stavy, druhý rozměr je pole, kde pod klíčem 0 je stav (true, false) a pod druhým klíčem typ operace
     */
    public function makeErrorMessage($error) {
        $result = array();
        foreach ($error as $row) {
            if($row->real) {
                $mess = $row->type;
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

//type - 0 nebo 1 
//message
//real

