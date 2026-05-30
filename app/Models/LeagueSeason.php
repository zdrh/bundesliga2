<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Main;

class LeagueSeason extends Model
{
    private object $config;
    private array $join;

    protected $table            = 'league_season';
    protected $primaryKey       = 'id_league_season';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_league', 'id_assoc_season', 'logo', 'league_name_in_season', 'groups'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function __construct()
    {
        $this->config = new Main();
        $this->join = $this->config->joinTable;
        parent::__construct();
    }
    public function getLeagueSeasonByStart(int $start, int $idLeague)
    {
        $data =  $this->select('season.start, league_season.id_league_season')->join('association_season', $this->join['league_season_association_season'], 'inner')->join('season', $this->join['season_association_season'], 'inner')->where('league_season.deleted_at IS NULL')->where('association_season.deleted_at IS NULL')->where('start', $start)->where('league_season.id_league', $idLeague)->first();

        return $data;
    }

    public function getLegaueSeasonByGroup(int $idGroup){
        
    }
}
