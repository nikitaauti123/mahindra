<?php

namespace App\Controllers\Roles\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RolesModel;
use App\Models\RolesPermissionModel;
use App\Models\PermissionModel;


use Exception;

Class RolesApiController extends BaseController
{
    use ResponseTrait;
    private $rolesModel;
    private $rolespermissionModel;
    private $permissionModel;

    public function __construct()
    {
        $this->rolesModel = new RolesModel();
        $this->permissionModel = new PermissionModel();
        $this->rolespermissionModel = new RolesPermissionModel();
    }

    public function list()
    {
        $role = $this->rolesModel->findAll();
       // $role = $this->respond($result, 200);
        $combinedData = [];
        foreach ($role as $roles) {
            $role_id = $roles['id'];
            $this->rolespermissionModel->where('role_id', $role_id); // Filter by user_id
            $Rolespermission = $this->rolespermissionModel->findAll();
         
            $permission_ids = [];
            foreach ($Rolespermission as $Rolespermission_res) {
                
                $permission_id = $Rolespermission_res['permission_id'];
                 if (!in_array($permission_id, $permission_ids)) {
                $permission_ids[] = $permission_id;
                }
            }
            $permission_names = [];
            foreach ($permission_ids as $permission_id) {
                $permission = $this->permissionModel->find($permission_id);
                if ($permission) {
                    $permission_names[] = $permission['permission_id'];
                }
            }
            $roles['permission'] = implode(', ', $permission_names);
            $combinedData[] = $roles;
        }
        return $this->respond($combinedData, 200);
    }

    public function getOne($id)
    {

        try {
            $result = $this->rolesModel->find($id);
            if(!empty($result)) {
                return $this->respond($result, 200);
            } 
            return $this->respond([], 200);
        } catch(\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function add(){

        try {
            helper(['form']);
            
            $rules = [
                'name'  => 'required|min_length[2]|max_length[10]',
                
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
            $permission_id = $this->request->getVar('permission_id');
         
            $data['name']  = $this->request->getVar('name');
            $data['is_active']  = $isactive;
            
            $result['id'] = $this->rolesModel->insert($data, true);
            foreach ($permission_id as $permission_id_arr) {
                $rolePermissionData[]  = [
                    'role_id' => $result['id'],
                    'permission_id' => $permission_id_arr,
                ];
            }
            $result['permission_id'] = $this->rolespermissionModel->insertBatch($rolePermissionData, true);
           
            $result['msg'] = lang('Roles.RolesSuccessMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }

    public function update($id){

        try {
            helper(['form']);

            if(!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }
            
            $rules = [
                'name'  => 'required|min_length[2]|max_length[10]',
               
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
            $permission_id = $this->request->getVar('permission_id');

            $data['name'] = $this->request->getVar('name');
             $data['is_active'] = $isactive;
             $result['is_updated'] = $this->rolesModel->update($id, $data);
             $user_role['role_id'] =$id;                          
             $user_role['role_id'] =$id;                          
                $this->rolespermissionModel->where('role_id', $id)->delete();                 
                foreach ($permission_id as $permission_id_arr) {
                    $rolePermissionData[]  = [
                        'role_id' => $id,
                        'permission_id' => $permission_id_arr,
                    ];
                }
                $result['permission_id'] = $this->rolespermissionModel->insertBatch($rolePermissionData, true);
             
            $result['msg'] = lang('Roles.RolesUpdateMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }

    public function delete($id){

        try {
            helper(['form']);

            if(!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $result['is_deleted'] = $this->rolesModel->delete($id);
            $result['msg'] =  lang('Roles.DeleteMsg');
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    public function update_is_active(){
        try {
            $id = $this->request->getVar('id');
            $is_Active = $this->request->getVar('is_active');
            if (($is_Active) == 1) {
                $data['is_active'] = '0';
            } else {
                $data['is_active'] = '1';
            }
            $result['msg'] =  lang('Roles.StatusUpdateMsg');
            $result['id'] = $this->rolesModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}