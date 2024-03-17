<?php

namespace App\Libraries;

class ArrayLibrary {

    public function __construct() {

    }

    /**
     * dostane pole objektů a seskupí ho podle daného atributu
     * returnValue: array of array - klíč prvního pole je hodnota $grouped
     * @param $array - pole objektů, které budeme seskupovat
     * @param $grouped - atribut, podle kterého budeme seskupovat
     */
    
    public function groupArray($array, $grouped) {
        $result = array();
        foreach($array as $row) {
            $result[$row->$grouped][] = $row;
        }

        return $result;
    }
    
}