<?php

namespace App\Libraries;
use \stdClass;

class AlertLibrary {

    var $stdClass;
    public function __construct() {

        $this->stdClass = new stdClass();
    }
/**
 * @param $status - status operace (T/F)
 * @param $method - typ operace - dbAdd apod.
 * @param $id - id vloženého záznamu, pokud se něco vložilo
 */
    public function createAlert($status, $method, $id) {
        $this->stdClass->status = $status;
        $this->stdClass->type = $method;
        $this->stdClass->id = $id;

        return $this->stdClass;
    }
}