<?php

namespace App\Models;


class Sql {
    var $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function query1($id_association) {
       $query = $this->db->query('SELECT season.*, association_season.id_association FROM season LEFT JOIN  association_season ON season.id_season=association_season.id_season AND association_season.id_association ='. $id_association. ' ORDER BY start ASC');
       $result = $query->getResult();
       
       return $result;

    }
}