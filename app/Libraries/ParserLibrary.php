<?php

namespace App\Libraries;

use DateTime;
use stdClass;

class ParserLibrary
{

    public function __construct() {}

    public function getMatchInfo($string)
    {
        $result = array();
        $time = $string->find('span.hidden-mini', 1)->innertext;
        $date = $string->plaintext;
        $date2 = explode(' - ', $date);
        $date2 = $date2[2];
        $date2 = explode(', ', $date2);
        $date = $date2[1];
        $date = new DateTime($date);
        $result['date'] = $date->format('Y-m-d');

        $string2 = $string->find('span', 0)->plaintext;
        $string2 = explode(' - ', $string2);
        //var_dump($time);
        $string2 = explode(' ', $time);

        $result['time'] = $string2[0];

        //var_dump($string);
        return $result;
    }

    public function getTeam($string)
    {

        $nazev = $string->find('.verein-name', 0)->innertext;

        return $nazev;
    }

    public function getGoals($string, $final)
    {
        $string = $string->plaintext;

        if (!$final) {
            $string = explode(' - ', $string);
            $string = $string[1];
        }

        //var_dump($string);
        $goals = explode(':', $string);
        $result['home'] = $goals[0];
        $result['away'] = $goals[1];

        return $result;
    }

    public function getReferee($string)
    {

        $string = $string->find('a', 0)->href;

        return $string;
    }

    public function getPlace($string)
    {
        
        $string = $string->find('div.p10', 1)->find('p');
     
        foreach ($string as $key => $row) {
           
            switch ($key) {
                case 0:
                    $town = $row->find('b')->innertext;
                    break;
                case 1:
                    $stadium = $row->find('b')->innertext;
                    break;
                case 2:
                    $attendance = $row->find('b')->innertext;
                    $attendance = $this->removeChar($attendance, '.');
                    break;
                default:
                    break;
            }
        }
        $result = array(
            'town' => $town,
            'stadium' => $stadium,
            'attendance' => $attendance
        );

        return $result;
    }

    public function getEvent($string){
       $text = $string->find('div',0)->innertext;
       $link = $string->find('a')->href;
       $description = $string->find('div', 1)->plaintext;

       $return = array(
        $text, $link, $description
       );

       return $return;

    }

    public function removeChar($string, $char)
    {
        $result = str_replace($char, '', $string);

        return $result;
    }

    public function getScorers($string)
    {
        $result = array();
        $oldSkore = "0:0";
        foreach ($string->find('p') as $row) {
            $goal = new \stdClass();
            $goal->score = $row->find('span', 0)->plaintext;
            $goal->team = $this->getScoringTeam($goal->score, $oldSkore);
            $goal->player = $row->find('a', 0)->href;
            $goal->time = $row->find('span', 1)->plaintext;
            if (!is_null($row->find('span', 2))) {
                $type = $row->find('span', 2)->plaintext;
                $goalInfo = $this->infoGoal($type);
                $goal->poznamka = $goalInfo->description;
                if ($goalInfo->assist) {
                    $goal->asistence = $row->find('span', 2)->find('a', 0)->href;
                } else {
                    $goal->asistence = "";
                }
            }
            $result[] = $goal;
            $oldSkore = $goal->score;
        }
        return $result;
    }

    private function infoGoal($string)
    {
        $info = new \stdClass();
        $deleni = explode(': ', $string);
        $pocet = Count($deleni);
        echo "<hr>";
        var_dump($deleni);
        echo "<hr>";
        if ($pocet == 1) {
            if ($deleni[0] == "") {
                $info->assist = false;
                $info->description = "";
            } else if ($deleni[0] == "Vorl.") {
                // je to jen asistence, nic víc
                $info->assist = true;
                $info->description = "";
            } else {
                $info->assist = false;
                $info->description = $deleni[0];
            }
        } else {
            if ($deleni[0] == "Vorl.") {
                $info->assist = true;
                $info->description = "";
            } else {

                $deleni2 = explode(', ', $deleni[0]);
                var_dump($deleni2);
                echo "<hr>";
                $info->description = $deleni2[0];
                if ($deleni2[1] == "Vorl.") {
                    $info->assist = true;
                } else {
                    $info->assist = false;
                }
                
            }
        }



        return $info;
    }

    private function getScoringTeam($newScore, $oldScore)
    {
        $result = "";
        $old = explode(":", $oldScore);
        $new = explode(':', $newScore);
        if ($old[0] == $new[0]) {
            $result = "away";
        } else {
            $result = "home";
        }

        return $result;
    }

    public function getSoupiska($file, $type)
    {
        $result = new \stdClass();
        $result->rozestaveni = "";
        $result->hraci = array();
        $result->trener = "";
        if ($type == 1) {
            $result->rozestaveni = $file->find('.heim', 0)->plaintext;
            $result->hraci = $this->getPlayers($file->find('.box-aufstellung', 0), $file->find('.box-aufstellung', 2), 1);
            $result->trener = $this->getTrener($file->find('.box-aufstellung', 4));
        } else {
            $result->rozestaveni = $file->find('.gast', 0)->plaintext;
            $result->hraci = $this->getPlayers($file->find('.box-aufstellung', 1), $file->find('.box-aufstellung', 3), 2);
            $result->trener = $this->getTrener($file->find('.box-aufstellung', 5));
        }

        return $result;
    }

    private function getPlayers($zaklad, $lavicka, $field)
    {
        $result = array();

        foreach ($zaklad->find('p') as $key => $row) {
            if ($key != 0) {
                if($row->class == "wechsel"){
                    $substituon = $row->plaintext;
                    $lastKey = array_key_last($result);
                    $result[$lastKey]->substitution = $substituon;
                } else {
                    $player = $this->getPlayer($row, 1, $field);
                $result[] = $player;
                }
                
            }
        }

        foreach ($lavicka->find('p') as $key => $row) {
            if ($key != 0) {
                if($row->class == "wechsel"){
                    $substituon = $row->plaintext;
                    $lastKey = array_key_last($result);
                    $result[$lastKey]->substitution = $substituon;
                } else {
                $player = $this->getPlayer($row, 2, $field);
                $result[] = $player;
                }
            }
        }
        return $result;
    }
    /**
     * @param $string - dom object, kde je daná část soupisky
     * @param $type - jestli je to lavička - 2/základ - 1
     * @param $field - jestli domácí - 1, hosté - 2
     */
    private function getPlayer($string, $type, $field)
    {
        if ($field == 1) {
            $add = 0;
        } else {
            $add = 1;
        }
        $player = new \StdClass();
        $player->position = "";
        $player->link = "";
        $player->type = "";
        $player->substitution = "";

        $player->position = $string->find('span.box-rn', 0)->plaintext;
        $player->link = $string->find('a', 0)->href;
        $player->type = $type;

        return $player;
    }

    private function getTrener($string)
    {
        $trener = $string->find('a', 0)->href;

        return $trener;
    }
}
