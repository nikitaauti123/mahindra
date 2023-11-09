<?php

namespace App\Controllers\Users\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use App\Models\RolesPermissionModel;
use App\Models\UsersRolesModel;
use App\Models\RolesModel;
use App\Models\JobsModel;
use App\Models\PartsModel;
use App\Models\JobActionsModel;
use DateTime;

use Exception;

class UsersApiController extends BaseController
{
    use ResponseTrait;
    private $usersModel;
    private $usersRoleModel;
    private $rolespermissionModel;
    private $roleModel;
    private $jobsModel;
    private $PartsModel;
    private $jobactionsModel;


    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->rolespermissionModel = new RolesPermissionModel();
        $this->usersRoleModel = new UsersRolesModel();
        $this->roleModel = new RolesModel();
        $this->jobsModel = new jobsModel();
        $this->PartsModel = new PartsModel();
        $this->jobactionsModel = new JobActionsModel();
    }
    public function getOne($id)
    {
        try {
            $result = $this->usersModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            }
            return $this->respond([], 200);
        } catch (\Exception $e) {
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

            if (!$this->validate($rules)) {
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
            if (!$user) {
                throw new Exception(lang('Login.FailMsg'));
            }

            $hashed_pass = $user['password'];
            $authenticatePassword = password_verify($data['password'], $hashed_pass);

            if (!$authenticatePassword) {
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
        $users = $this->usersModel->findAll();

        $combinedData = [];
        helper('common_helper');
        foreach ($users as $user) {
            $user_id = $user['id'];
            $this->usersRoleModel->where('user_id', $user_id); // Filter by user_id
            $userRoles = $this->usersRoleModel->findAll();
            $roleNames = [];
            foreach ($userRoles as $userRole) {
                $role_id = $userRole['role_id'];
                $role = $this->roleModel->find($role_id);
                if ($role) {
                    $roleNames[] = $role['name'];
                }
            }
            // print_r($roleNames);
            $created_at = new DateTime($user['created_at']);
            $updated_at = new DateTime($user['updated_at']);

            $formatted_date = $created_at->format('d-m-Y h:i A');
            $formatted_date_updated = $updated_at->format('d-m-Y h:i A');

            $user['created_at'] =   $formatted_date;
            $user['updated_at'] =   $formatted_date_updated;

            $user['roles'] = implode(', ', $roleNames);
            $combinedData[] = $user;
        }
        return $this->respond($combinedData, 200);
        // return $this->respond($result, 200);
    }

    public function add()
    {
        try {
            helper(['form']);

            $rules = [
                'username'  => 'required|min_length[2]|max_length[50]',
                'password'  => 'required|min_length[3]|max_length[50]'
            ];

            if (!$this->validate($rules)) {
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
            $user_role['role_id'] =  $this->request->getVar('role_id');

            $data = array_filter($data, fn ($value) => !is_null($value) && $value !== '');
            $result['msg'] = lang('Users.UsersSuccessMsg');

            $result['id'] = $this->usersModel->insert($data, true);
            $user_role['user_id'] = $result['id'];
            $result['role_id'] = $this->usersRoleModel->insert($user_role, true);

            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function update($id)
    {

        try {
            helper(['form']);

            $rules = [
                'username'  => 'required|min_length[2]|max_length[50]',
            ];

            if (!$this->validate($rules)) {
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
            $user_role['role_id'] =  $this->request->getVar('role_id');

            $data = array_filter($data, fn ($value) => !is_null($value) && $value !== '');

            $user_role['user_id'] = $id;
            $this->usersRoleModel->where('user_id', $id)->delete();
            $result['role_id'] = $this->usersRoleModel->insert($user_role, true);

            $result['id'] = $this->usersModel->update($id, $data);
            $result['msg'] = lang('Users.UsersUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function update_is_active()
    {
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
    public function delete($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $result['is_deleted'] = $this->usersModel->delete($id);
            $result['msg'] = "Users deleted successfully!";
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function get_permission_names()
    {
        $id = $this->request->getVar('role_id');
        $this->rolespermissionModel->where('role_id', $id);
        $result = $this->rolespermissionModel->findAll();
        return $this->respond($result, 200);
    }

    public  function get_role_names()
    {
        $id = $this->request->getVar('user_id');


        $result['role_id']  = $this->usersRoleModel->Where('user_id', $id)
            ->first();

        if (isset($result['role_id']) && (!empty($result['role_id']))) {
            $result['role_name']  = $this->roleModel->Where('id', $result['role_id']['role_id'])
                ->first();
        }

        return $this->respond($result, 200);
    }

    public function get_all_count()
    {
        try {
            if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = $this->change_date_format($from_date) . " 00:00:00";
                $to_date = $this->request->getVar('to_date');
                $t_date = $this->change_date_format(($to_date)) . " 23:59:59";
                $this->jobactionsModel->where("start_time >= '" . $f_date . "'", null, false);
                $this->jobactionsModel->where("end_time <= '" . $t_date . "'", null, false);
            }
            $this->jobactionsModel->where('end_time IS NOT NULL', null, false);
            $this->jobactionsModel->join('parts', 'job_actions.part_id = parts.id');
            $results_complted = $this->jobactionsModel->findAll();
            $result['total_completed_jobs'] = count($results_complted);


            $result_left = $this->jobactionsModel->findAll();

            $result_c = $this->jobactionsModel
                ->select('parts.*,job_actions.side,job_actions.part_id,job_actions.id,job_actions.start_time,job_actions.end_time')
                ->join('parts', 'job_actions.part_id = parts.id')
                ->orderBy('job_actions.id', 'DESC')
                ->limit(5)
                ->get()
                ->getResult();;
            $result['completed_job'] = $result_c;

            $this->jobactionsModel->select("AVG(TIMESTAMPDIFF(MINUTE, job_actions.start_time, job_actions.end_time)) as average_time", false);
            $this->jobactionsModel->where('end_time IS NOT NULL', null, false);
           
            $this->jobactionsModel->join('parts', 'job_actions.part_id=parts.id');
            $av_result = $this->jobactionsModel->findAll();
            $totalTimeSum = 0;
            $totalCount = count($av_result);
            foreach ($av_result as $record) {
                $totalTimeSum += $record['average_time'];
            }
            if ($totalCount > 0) {
                $averageTimeInHours = $totalTimeSum / 60;
            }
            $result['averag_hour_required'] = $averageTimeInHours;

            echo json_encode($result);
            die();
        } catch (Exception $e) {
        }
    }
    private function change_date_format($str)
    {
        $date_str = explode("/", $str);
        return $date_str[2] . "-" . $date_str[0] . "-" . $date_str[1];
    }
}
