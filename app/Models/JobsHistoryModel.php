<?php
/**  
 * JobsHistory file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsHistory_Class
 * @package  JobsHistory_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;

/**  
 * JobsHistory file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsHistory_Class
 * @package  JobsHistory_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class JobsHistoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jobs_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'part_id',
        'job_id',
        'pins',
        'is_active',
        'created_by',
        'created_at'
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

    
}