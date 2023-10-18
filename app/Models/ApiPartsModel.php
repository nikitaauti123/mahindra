<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiPartsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'apiparts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'part_id',
        'pins',  
        'created_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $updatedField = false;
    protected $deletedField = false;

    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    
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