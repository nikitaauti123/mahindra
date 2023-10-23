<?php

namespace App\Controllers\Users\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use Exception;

Class UsersApiController extends BaseController
{
    use ResponseTrait;
    private $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }
    public function getOne($id)
    {
        try {
            $result = $this->usersModel->find($id);
            if(!empty($result)) {
                return $this->respond($result, 200);
            } 
            return $this->respond([], 200);
        } catch(\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function check_login()
    {

        try {

            helper(['form']);
            
            $rules = [
                'username'  => 'required|min_length[2]|max_length[50]',
                'password'  => 'required|min_length[3]|max_length[50]',
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $session = session();

            $data['username'] = $this->request->getVar('username');
            $data['password'] = $this->request->getVar('password');

            $user = $this->usersModel->Where('is_active', 1)
                                ->Where('username', $data['username'])
                                ->orWhere('email', $data['username'])
                                ->orWhere('phone', $data['username'])
                                ->first();        
            if ( !$user) {
                throw new Exception(lang('Login.FailMsg'));
            }                                
            
            $hashed_pass = $user['password'];
            $authenticatePassword = password_verify($data['password'], $hashed_pass);

            if( !$authenticatePassword ){
                throw new Exception(lang('Login.FailMsg'));
            }
                
            $ses_data = [
                'id' =>  $user['id'],
                'first_name' =>  $user['first_name'],
                'email' =>  $user['email'],
                'isLoggedIn' => TRUE
            ];
            $session->set($ses_data);             
                
            $result['msg'] =  lang('Login.SuccessMsg');
            $result['user'] =  $user;
            return $this->respond($result, 200);
            
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }        
    }

    public function list()
    {
        $result = $this->usersModel->findAll();
        return $this->respond($result, 200);
    }

    public function add(){
        try {
            helper(['form']);
            
            $rules = [
                'username'  => 'required|min_length[2]|max_length[50]',
                'password'  => 'required|min_length[3]|max_length[50]'
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
                $isactive = 1;
            }
            $data['username'] = $this->request->getVar('username');
            $data['password'] = $this->request->getVar('password');
            $data['email']    = $this->request->getVar('email');
            $data['phone']    = $this->request->getVar('phone_number');
            $data['emp_id']   = $this->request->getVar('employee_id');
            $data['first_name']      = $this->request->getVar('first_name');
            $data['last_name']       = $this->request->getVar('last_name');
            $data['is_active']       = $isactive;
          
            // $data['profile_photo']   =  isset($cropped_img) ? $cropped_img : '';
          
            // Remove attribute if value is null or blank
            $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');
            $result['msg'] = lang('Users.UsersSuccessMsg');
           
            $result['id'] = $this->usersModel->insert($data, true);
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }

    public function update($id){

        try {
            helper(['form']);
            
            $rules = [
                'username'  => 'required|min_length[2]|max_length[50]',
                          ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
           
            $data['username'] = $this->request->getVar('username');
            $data['password'] = $this->request->getVar('password');
            $data['email']    = $this->request->getVar('email');
            $data['phone']    = $this->request->getVar('phone_number');
            $data['emp_id']   = $this->request->getVar('employee_id');
            $data['first_name']      = $this->request->getVar('first_name');
            $data['last_name']       = $this->request->getVar('last_name');
            $data['is_active']       = $isactive;
           
            $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');
            $result['msg'] = lang('Users.UsersUpdateMsg');
           

            $result['id'] = $this->usersModel->update($id, $data);
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
            $result['msg'] =  lang('Users.StatusUpdateMsg');
            $result['id'] = $this->usersModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}