<?php

namespace App\Libraries;

use stdClass;
use App\Models\Team;

class ArrayLibrary
{
    var $team;
    public function __construct()
    {
        $this->team = new Team();

    }

    /**
     * dostane pole objektů a seskupí ho podle daného atributu
     * returnValue: array of array - klíč prvního pole je hodnota $grouped
     * @param $array - pole objektů, které budeme seskupovat
     * @param $grouped - atribut, podle kterého budeme seskupovat
     */

    public function groupArray($array, $grouped)
    {
        $result = array();
        foreach ($array as $row) {
            $result[$row->$grouped][] = $row;
        }

        return $result;
    }
    /**
     * dostane dvourozměnrné pole (typicky import z csv), zkontroluje, zda je v každém prvku daný počet podprvků a vrátí pole objektů
     * @param $array -dvourozměrné pole, které se bude testovat
     * @param $names - názvy atributů v objektu, který se bude vracet, musí být v pořadí v jakém jsou v prvním poli
     * 
     * @return - pole objektů, kde vnitřní pole bude objektem a klíče vnitřního pole budou atributy
     */
    public function testArray($array, $names)
    {
        $result = array();
        foreach ($array as $row) {

            //pole má správný počet řádků
            $subResult = new stdClass();
            foreach ($names as $key2 => $row2) {
                if ($key2 >= count($row)) {
                    $row[$key2] = NULL;
                }

                $subResult->$row2 = $row[$key2];
            }

            $result[] = $subResult;
        }

        return $result;
    }
    /**
     * projde pole objektů a pokud má klub nástupce, nahradí id jeho názvem
     */
    public function addFollower($tymy)
    {
        $result = array();
        foreach($tymy as $row) {
            if(!is_null($row->follower)) {
                $follower = $this->getFollower($row->follower);
                $row->follower = $follower;
            }
            $result[] = $row;
        }

        return $result;
    }
    /**
     * vrátí název nástupnického klubu na zákaldě id nástupce
     */
    public function getFollower($id_team) {
        $team = $this->team->find($id_team);
        return $team->general_name;
    }
}
