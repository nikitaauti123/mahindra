<?php
/**  
 * UsersRolesModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersRolesModel_Class
 * @package  UsersRolesModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * UsersRolesModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersRolesModel_Class
 * @package  UsersRolesModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class UsersRolesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users_roles';
 
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'user_id',
    ];
    // Dates
    protected $useTimestamps = false;
   

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