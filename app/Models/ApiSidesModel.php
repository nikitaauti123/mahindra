<?php
/**  
 * ApiSidesModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category ApiSidesModel_Class
 * @package  ApiSidesModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * ApiSidesModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category ApiSidesModel_Class
 * @package  ApiSidesModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class ApiSidesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'apisides';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'part_id',
        'sides',  
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