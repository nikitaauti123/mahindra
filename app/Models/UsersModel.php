<?php
/**  
 * UsersModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersModel_Class
 * @package  UsersModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Models;

use CodeIgniter\Model;
/**  
 * UsersModel file Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersModel_Class
 * @package  UsersModel_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'phone',
        'emp_id',
        'profile_photo',
        'token',
        'is_active',
        'created_by',
        'updated_by'
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
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    /**
     * Method for handling hashpasswords.
     * 
     * @param $data is data on which hashpassword perform
     * 
     * @return string; 
     */
    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }
        // todo - need to add SALT and define strong algo
        $data['data']['password'] = password_hash(
            $data['data']['password'],
            PASSWORD_DEFAULT
        );

        return $data;
    }
    /**
     * Method for handling roles.
     * 
     * @return string; 
     */
    public function roles()
    {

        $builder = $this->builder();
        $builder->select("users.*");
        $rows = $builder->get()->getResult($this->returnType);
        
        foreach ($rows as $k=>$data) {
            $id = $this->returnType == 'object' ? $data->id : $data['id'];
            $builder->select("roles.*");
            $builder->where('users_roles.user_id', $id);
            $builder->join('users_roles', 'users.id=users_roles.user_id', 'INNER');
            $builder->join('roles', 'users_roles.role_id=roles.id', 'INNER');
            $roles = $builder->get()->getResult($this->returnType);
            if ($this->returnType == 'object') {
                $rows[$k]->roles = $roles;
            } else {
                $rows[$k]['roles'] = $roles;
            }
        }
        return $rows;
    }

}
