<?php

namespace App\Libraries;

use App\Libraries\ArrayLibrary as LibrariesArrayLibrary;
use Config\Main;
use stdClass;
use ArrayLibrary;

class ErrorMessage
{

    var $config;
    var $session;
    var $arrayLib;

    public function __construct()
    {
        $this->config = new Main();
        $this->session = \Config\Services::session();
        $this->arrayLib = new LibrariesArrayLibrary();
    }
    /**
     * @param status - typ zprávy - true - success, false - error
     * @param type - typ podle typu operace, která se stala (možnosti v configu main), např dbEdit
     * @param text - 
     */
    public function prepareMessage(bool $status, $type, $text = '', $real = true)
    {
        $data = new stdClass();
        $data->status = $status;
        if ($status) {
            $data->type = $type . 'Success';
            $data->class = 'success';
        } else {
            $data->type = $type . 'Error';
            $data->class = 'danger';
        }
        if ($real) {
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
    public function makeErrorMessage($error)
    {
        $result = array();
        foreach ($error as $row) {
            if ($row->real) {
                $mess = $row->type;
                $result[] = array(
                    'message' => $this->config->errorMessage[$mess],
                    'class' => 'success',
                    'real' => true
                );
            } else {
                $mess = $row[1] . 'Error';
                $result[] = array(
                    'message' => $this->config->errorMessage[$mess],
                    'class' => 'danger',
                    'real' => true
                );
            }
        }
        $this->session->setFlashdata('error', $result);
    }
    /**
     * @param $status - boolean podle toho, jestli byl success nebo error
     * @param $type - string, jaký typ operace proběhl, podle konfiguračního souboru - dbAdd, dbEdit, dbDel apod
     * @return - objekt se dvěma atributy - text hlášky v message a třída v class
     */
    public function prepapreMessage2($status, $type)
    {
        $result = new \stdClass();
        if ($status) {
            $result->class = "success";
            $shortType = $type . "success";
        } else {
            $result->class = "danger";
            $shortType = $type . "error";
        }
        $result->message = $this->config->errorMessage[$shortType];

        return $result;
    }
    /**
     * $data - pole, které obsahuje objekty, kde atribut result má boolean hodnotu, atribut type string podle typu operace, atribut id je id, se kterým se dělala operace
     */
    public function prepareMessage3($data)
    {
        $result = array();
        $pole = $this->arrayLib->groupArray($data, 'type');
        foreach ($pole as $key => $row) {
            $result2 = array();
            foreach ($row as $row2) {
                $subResult = new \stdClass();
                $subResult->success = 0;

                if ($row2->status) {
                    $subResult->success++;
                }
            }
            if ($subResult->success > 0) {
                $subResult->class = "success";
                $subResult->type = $key . "Success";
            } else {
                $subResult->class = "danger";
                $subResult->type = $key . "Error";
            }
            $subResult->message = $this->config->errorMessage[$subResult->type].$subResult->success;
            $subResult->real = true;
            $result[] = $subResult;
        }

        return $result;
    }
}

//type - 0 nebo 1 
//message
//real
