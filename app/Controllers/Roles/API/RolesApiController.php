<?php
/**  
 * RolesApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category RolesApiController_Class
 * @package  RolesApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Roles\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RolesModel;
use App\Models\RolesPermissionModel;
use App\Models\PermissionModel;


use Exception;
/**  
 * RolesApiController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category RolesApiController_Class
 * @package  RolesApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
Class RolesApiController extends BaseController
{
    use ResponseTrait;
    private $_rolesModel;
    private $_rolespermissionModel;
    private $_permissionModel;
    /**
     * Constructor for the RolesApiController class.
     */
    public function __construct()
    {
        $this->_rolesModel = new RolesModel();
        $this->_permissionModel = new PermissionModel();
        $this->_rolespermissionModel = new RolesPermissionModel();
    }
    /**
     * Method for handling list in the permission.
     * 
     * @return text; 
     */
    public function list()
    {
        $role = $this->_rolesModel->findAll();
        $combinedData = [];
        foreach ($role as $roles) {
            $role_id = $roles['id'];
            $this->_rolespermissionModel->where('role_id', $role_id); 
            $Rolespermission = $this->_rolespermissionModel->findAll();
         
            $permission_ids = [];
            foreach ($Rolespermission as $Rolespermission_res) {
                
                $permission_id = $Rolespermission_res['permission_id'];
                if (!in_array($permission_id, $permission_ids)) {
                    $permission_ids[] = $permission_id;
                }
            }
            $permission_names = [];
            foreach ($permission_ids as $permission_id) {
                $permission = $this->_permissionModel->find($permission_id);
                if ($permission) {
                    $permission_names[] = $permission['permission_id'];
                }
            }
            $roles['permission'] = implode(', ', $permission_names);
            $combinedData[] = $roles;
        }
        return $this->respond($combinedData, 200);
    }
    /**
     * Method for handling list in the permission.
     * 
     * @param $id used to get single row details of role
     * 
     * @return text; 
     */
    public function getOne($id)
    {

        try {
            $result = $this->_rolesModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            } 
            return $this->respond([], 200);
        } catch(\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    } 
       /**
        * Method for handling list in the permission.
        * 
        * @return text; 
        */
    public function add()
    {

        try {
            helper(['form']);
            
            $rules = [
                'name'  => 'required|min_length[2]|max_length[10]',
                
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $this->_rolesModel->where('is_active', '1');
            $this->_rolesModel->where('deleted_at IS NULL');
            $this->_rolesModel->where('name', $this->request->getVar('name'));
            $res = $this->_rolesModel->find();


            if (!empty($res)) {
                return $this->fail(lang('Roles.DuplicateRoles'));
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
            $permission_id = $this->request->getVar('permission_id');
         
            $data['name']  = $this->request->getVar('name');
            $data['is_active']  = $isactive;
            
            $result['id'] = $this->_rolesModel->insert($data, true);
            foreach ($permission_id as $permission_id_arr) {
                $rolePermissionData[]  = [
                    'role_id' => $result['id'],
                    'permission_id' => $permission_id_arr,
                ];
            }
            $result['permission_id'] = $this->_rolespermissionModel->insertBatch(
                $rolePermissionData, 
                true
            );
           
            $result['msg'] = lang('Roles.RolesSuccessMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    } 
       /**
        * Method for handling list in the permission.
        * 
        * @param $id id update id of roles.
        *
        * @return text; 
        */
    public function update($id)    
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }
            
            $rules = [
                'name'  => 'required|min_length[2]|max_length[10]',
               
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            if ($id != '') {
                $this->_rolesModel->where('id !=', $id);
            }
            $this->_rolesModel->where('is_active', '1');
            $this->_rolesModel->where('deleted_at IS NULL');
            $this->_rolesModel->where('name', $this->request->getVar('name'));
            $res = $this->_rolesModel->find();


            if (!empty($res)) {
                return $this->fail(lang('Roles.DuplicateRoles'));
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
            $permission_id = $this->request->getVar('permission_id');

            $data['name'] = $this->request->getVar('name');
             $data['is_active'] = $isactive;
             $result['is_updated'] = $this->_rolesModel->update($id, $data);
             $user_role['role_id'] =$id;                          
             $user_role['role_id'] =$id;                          
                $this->_rolespermissionModel->where('role_id', $id)->delete();                 
            foreach ($permission_id as $permission_id_arr) {
                $rolePermissionData[]  = [
                    'role_id' => $id,
                    'permission_id' => $permission_id_arr,
                ];
            }
                $result['permission_id'] = $this->_rolespermissionModel->insertBatch($rolePermissionData, true);
             
            $result['msg'] = lang('Roles.RolesUpdateMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    /**
     * Method for handling list in the permission.
     * 
     * @param $id delete id of roles
     * 
     * @return text; 
     */
    public function delete($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $result['is_deleted'] = $this->_rolesModel->delete($id);
            $result['msg'] =  lang('Roles.DeleteMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    /**
     * Method for handling list in the permission.
     * 
     * @return text; 
     */
    public function updateIsActive()
    {
        try {
            $id = $this->request->getVar('id');
            $is_Active = $this->request->getVar('is_active');
            if (($is_Active) == 1) {
                $data['is_active'] = '0';
            } else {
                $data['is_active'] = '1';
            }
            $result['msg'] =  lang('Roles.StatusUpdateMsg');
            $result['id'] = $this->_rolesModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}