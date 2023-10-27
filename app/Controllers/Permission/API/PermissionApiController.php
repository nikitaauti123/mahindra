<?php

namespace App\Controllers\Permission\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PermissionModel;
use Exception;

Class PermissionApiController extends BaseController
{
    use ResponseTrait;
    private $permissionsModel;

    public function __construct()
    {
        $this->permissionsModel = new PermissionModel();
    }

    public function list()
    {
        $result = $this->permissionsModel->findAll();
        return $this->respond($result, 200);
    }

    public function getOne($id)
    {

        try {
            $result = $this->permissionsModel->find($id);
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
                'permission_id'  => 'required|min_length[2]',
                
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
           
            $data['permission_id']  = $this->request->getVar('permission_id');
            $data['description']  = $this->request->getVar('description');
           
            $data['is_active']  = $isactive;
            
            $result['id'] = $this->permissionsModel->insert($data, true);
            $result['msg'] = lang('Permission.PermissionSuccessMsg');
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
                'permission_id'  => 'required|min_length[2]',
               
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }

            $data['permission_id'] = $this->request->getVar('permission_id');
            $data['description']  = $this->request->getVar('description');
           
             $data['is_active'] = $isactive;
             $result['is_updated'] = $this->permissionsModel->update($id, $data);
            $result['msg'] = lang('Permission.PermissionUpdateMsg');
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

            $result['is_deleted'] = $this->permissionsModel->delete($id);
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
            $result['msg'] =  lang('Permission.StatusUpdateMsg');
            $result['id'] = $this->permissionsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}