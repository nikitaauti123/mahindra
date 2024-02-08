<?php
/**  
 * NextJobsModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category NextJobsModel_Class
 * @package  NextJobsModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * NextJobModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category NextJobModel_Class
 * @package  NextJobModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class NextJobsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'next_jobs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'die_no',
        'side',
        'is_started',
        'start_time',
        'end_time'
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
