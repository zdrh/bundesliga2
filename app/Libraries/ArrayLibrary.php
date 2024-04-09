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

    public function groupArrayTwolevel($array, $grouped1, $grouped2)
    {   
        $column1 = $grouped1->column;
        $column2 = $grouped2->column;
        $result = $this->groupArray($array, $column1);
        if($grouped1->orderBy == 'asc') {
            asort($result);
        } else {
            ksort($result);
        }
        foreach($result as $key => $row) {
            $result[$key] = $this->groupArray($row, $column2);
            if($grouped2->orderBy == 'asc') {
                asort($result[$key]);
            } else {
                ksort($result[$key]);
            }
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
        foreach ($tymy as $row) {
            if (!is_null($row->follower)) {
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
    public function getFollower($id_team)
    {
        $team = $this->team->find($id_team);
        return $team->general_name;
    }
    /**
     * projde výpis skupin a pokud skupina nemá jméno (je jen vytvořena virtuálně kvůli linkům, doplní jí jméno podle názvu soutěže)
     */
    public function fillNames($groups, $leagueName)
    {
        $result = array();
        foreach ($groups as $row) {
            if ($row->groupname == NULL) {
                $row->groupname = $leagueName;
                $row->real = 0;
            } else {
                $row->real = 1;
            }
            $result[] = $row;
        }

        return $result;
    }
    /**
     * z pole objektů $all odebere ty prvky, které mají shodný hodnotu atributu $key jako prvky v poli $toRemove
     * @param $all - pole objektů, ze kterého chceme mazat
     * @param $toRemove - pole objektů, kde jsou hodnoty, které máme odebrat
     * @param $key - string, název atributu, který se má hledat a podle něj odebírat, musí být v obou polích
     */
    public function cleanArray($all, $toRemove, $key)
    {
        $result = array();
        foreach ($all as $row) {
            $value = $row->$key;
            if (!$this->findValueInArray($toRemove, $value, 'id_team')) {
                $result[] = $row;
            }
        }

        return $result;
    }

    public function findValueInArray($array, $value, $attribute)
    {
        $result = false;
        foreach ($array as $row) {
            if ($row->$attribute == $value) {
                $result = true;
            }
        }

        return $result;
    }
    /**
     * vezme pole objektů $array a převede ho na pole vhodné do dorpdownu, tj pole, kde klíčem bude hodnota $key a hodnotou $value
     */
    public function arrayToDropdown($array, $key, $value)
    {
        $result = array();
        foreach ($array as $row) {
            $result[$row->$key] = $row->$value;
        }

        return $result;
    }
}
