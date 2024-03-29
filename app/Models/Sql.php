<?php

namespace App\Models;


class Sql {
    var $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }
    /**
     * vrátí všechny sezony a k nim jestli ji daný svaz má nebo nemá
     */
    public function query1($id_association) {
       $query = $this->db->query('SELECT season.*, association_season.id_association FROM season LEFT JOIN  association_season ON season.id_season=association_season.id_season AND association_season.id_association ='. $id_association. ' ORDER BY start ASC');
       $result = $query->getResult();
       
       return $result;

    }
/** vrátí všechny sezony které má daná liga a danou asociace */
    public function query2($id_league, $id_association) {
        $query = $this->db->query('SELECT as_s.*, ls.id_league_season FROM (SELECT season.*, association_season.id_assoc_season FROM season LEFT JOIN association_season ON season.id_season=association_season.id_season WHERE association_season.id_association='.$id_association.')as_s LEFT JOIN (SELECT league_season.*, association_season.id_season FROM league_season inner join association_season ON league_season.id_assoc_season = association_season.id_assoc_season WHERE league_season.id_league = '.$id_league.')ls ON as_s.id_season = ls.id_season;');
        $result = $query->getResult();

       
        
        return $result;
    }
}