<?php

namespace App\Models;

use CodeIgniter\Model;


class JobActionsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'job_actions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'part_id',
        'side',
        'image_url',
        'wrong_pins',
        'correct_pins',
        'start_time',
        'end_time',
        'created_by',
        'updated_by',
        'mail_send'
    ];


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
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

    

    public function update_data($id, $side, $by_id, $end_time)
    {

        $builder = $this->builder();
        $builder->set('end_time', $end_time)
                ->set('updated_by', $by_id)
                ->where('id', $id)
                ->where('side', $side)
                ->update();
                
        return $this->db->affectedRows();
    }
}