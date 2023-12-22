<?php
/**  
 * PermissionModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionModel_Class
 * @package  PermissionModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * PermissionModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionModel_Class
 * @package  PermissionModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class PermissionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Permission';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'permission_id',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    // Dates
    protected $useTimestamps = true;
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
     * Method for handling users.
     * 
     * @return string; 
     */
    public function users()
    {

        $builder = $this->builder();
        $builder->select("*");
        $rows = $builder->get()->getResult($this->returnType);
        
        foreach ($rows as $k=>$data) {
            $id = $this->returnType == 'object' ? $data->id : $data['id'];
            $builder->select("users.*");
            $builder->where('users_roles.role_id', $id);
            $builder->join('users_roles', 'roles.id=users_roles.role_id', 'INNER');
            $builder->join('users', 'users_roles.user_id=users.id', 'INNER');
            $users = $builder->get()->getResult($this->returnType);
            
            if ($this->returnType == 'object') {
                $rows[$k]->users = $users;
            } else {
                $rows[$k]['users'] = $users;
            }
            
        }
        return $rows;
    }
}