<?php

namespace App\Models;

use CodeIgniter\Model;

class Zapasy extends Model
{
    protected $table            = 'x_zapasy';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['link', 'datum', 'cas', 'domaci', 'hoste', 'golyD', 'golyH', 'polocasD', 'polocasH', 'rozhodci', 'mistoZapasu', 'stadion', 'divaci', 'trenerD', 'trenerH', 'rozestaveniD', 'rozestaveniH', 'strelciZpracovano', 'soupiskaZpracovano', 'event'];

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
}
