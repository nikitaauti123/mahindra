<?php
/**  
 * JobsActionsModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsActionsModel_Class
 * @package  JobsActionsModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * JobsActionsModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsActionsModel_Class
 * @package  JobsActionsModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */

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

    
    /**
     * Method for update data of jobActions table.
     * 
     * @param int    $id       Update id of the job action table.
     * @param string $side     Side (left/right) for the statement.
     * @param $by_id    userid for 
     * @param $end_time endtime of jobs
     * 
     * @return row; 
     */
    public function updateData($id, $side, $by_id, $end_time)
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