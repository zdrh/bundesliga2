<?php

namespace App\Libraries;

use App\Models\LeagueSeasonGroup;
use App\Models\Team;

use App\Libraries\ArrayLibrary;

use Config\Main;

class FootballLibrary
{
    var $league_season_group;
    var $team;
    var $main;
    var $join;
    var $arrayLib;
    public function __construct()
    {

        $this->league_season_group = new LeagueSeasonGroup();
        $this->main = new Main();
        $this->join = $this->main->joinTable;
        $this->team = new Team();
        $this->arrayLib = new ArrayLibrary();
    }
    /**
     * vrátí pole objektů s id týmu a názvem týmu, které v dané sezoně nejsou v žádné zákaldní soutěži
     */
    public function getAvailableTeams($idGroup)
    {
        $vsechnyTymy = $this->team->orderBy('general_name', 'asc')->findAll();
        $groups = $this->getGroupsSameSeason($idGroup);
        $nedostupneTymy  = $this->team->join('team_league_season', $this->join['team_team_league_season'], 'inner')->whereIn('id_league_season_group', $groups)->findAll();
        $dostupneTymy = $this->arrayLib->cleanArray($vsechnyTymy, $nedostupneTymy, 'id_team');
        return $dostupneTymy;
    }
    /**
     * vrátí pole s id skupin, které se hrají ve stejné sezoně, jako skupina s idGroup, počítají se pouze zákaldní skupiny
     */
    public function getGroupsSameSeason($idGroup)
    {
        $idSeason = $this->getSeasonFromGroup($idGroup);
        $result2 = $this->league_season_group->join('league_season', $this->join['league_season_group_league_season'], 'inner')->join('association_season', $this->join['league_season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->where('association_season.id_season', $idSeason)->where('league_season_group.regular', 1)->findAll();

        $result = array();
        foreach ($result2 as $row) {
            $result[] = $row->id_league_season_group;
        }
        return $result;
    }
    /**
     * vrátí id sezony, ve které se dan skupina koná
     */
    public function getSeasonFromGroup($idGroup)
    {
        $result = $this->league_season_group->join('league_season', $this->join['league_season_group_league_season'], 'inner')->join('association_season', $this->join['league_season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->find($idGroup);

        return $result->id_season;
    }
    /**
     * dostane vourozměrné pole, kde v druhém rozměru jsou týmy, které hrají stejnou soutěž, vytvoří nové dvourozměrné pole, kde v druhém rozměru bude pouze skutečný název týmu a v závorce případný obený název, pokud ten je jiný než skutečný).
     */
    public function getRealNamesTeams($array)
    {
        $result = array();
        foreach ($array as $key => $row) {
            foreach($row as $row2) {
                $general_name = $row2->general_name;
                $name_in_season = $row2->team_name_in_season;
                if($general_name == $name_in_season or $name_in_season == NULL) {
                    $result[$key][] = $general_name;
                } else {
                    $result[$key][] = $name_in_season . "(" . $general_name . ")";
                }

            }
        }

        return $result;
    }
    /**
     * z pole , kde je seznam určitých sezon, vytáhne star a finish a dá je jako jeden parametr 
     **/

    public function getSeasons($array, $return, $delimiter) {
        $result = array();
        foreach($array as $row) {
            $row->$return = $row->start.$delimiter.$row->finish;
            $result[] = $row;
        }

        return $result;
    }
}
