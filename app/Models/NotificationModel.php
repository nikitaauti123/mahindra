<?php
/**  
 * NotificationModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationModel_Class
 * @package  NotificationModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * NotificationModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationModel_Class
 * @package  NotificationModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class NotificationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notification';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'die_no',
        'msg',  
        'status',           
        'created_date',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $updatedField = false;
    protected $deletedField = false;

    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_date';
    
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