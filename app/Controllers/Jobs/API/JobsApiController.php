<?php

namespace App\Controllers\Jobs\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JobsModel;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
use DateTime;
use Exception;

class JobsApiController extends BaseController
{
    use ResponseTrait;
    private $jobsModel;
    private $PartsModel;
    private $session;
    private $jobshistoryModel;
    private $JobActionsModel;

    public function __construct()
    {
        $this->jobsModel = new JobsModel();
        $this->PartsModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->session = \Config\Services::session();
        $this->JobActionsModel = new JobActionsModel();
    }

    public function list()
    {
        $result = $this->jobsModel->findAll();
        $combinedData = [];
        foreach ($result as $result_arr) {
            $created_at = new DateTime($result_arr['created_at']);
            $formatted_date = $created_at->format('d-m-Y h:i A');
            $result_arr['created_at'] =   $formatted_date;

            $updated_at = new DateTime($result_arr['updated_at']);
            $formatted_date_update = $updated_at->format('d-m-Y h:i A');
            $result_arr['updated_at'] =   $formatted_date_update;

            $combinedData[] = $result_arr;
        }
        return $this->respond($combinedData, 200);
    }

    public function getOne($id)
    {
        try {
            $result = $this->jobsModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            }
            return $this->respond([], 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function add()
    {

        try {
            helper(['form']);

            $rules = [
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name']  = $this->request->getVar('part_name');
            $data['part_no']    = $this->request->getVar('part_no');
            $data['model']      = $this->request->getVar('model');
            $data['is_active']  = $this->request->getVar('is_active') ? $this->request->getVar('is_active') : 0;
            $data['pins']      =  $this->request->getVar('selected_pins');

            $result['id'] = $this->jobsModel->insert($data, true);
            $result['msg'] = lang('Jobs.JobsSuccessMsg');

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

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $rules = [
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name'] = $this->request->getVar('part_name');
            $data['part_no']   = $this->request->getVar('part_no');
            $data['model']     = $this->request->getVar('model');
            $data['is_active'] = $this->request->getVar('is_active') ? $this->request->getVar('is_active') : 0;
            $data['pins']      =  $this->request->getVar('selected_pins');

            $result['is_updated'] = $this->jobsModel->update($id, $data);
            $result['msg'] = lang('Jobs.JobsSuccessUpdateMsg');
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

            $result['is_deleted'] = $this->jobsModel->delete($id);
            $result['msg'] = "Job deleted successfully!";
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
            $result['msg'] =  lang('Jobs.StatusUpdateMsg');
            $result['id'] = $this->jobsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function get_api_data()
    {

        $result = $this->jobsModel
            ->select('jobs.pins, jobs.side, parts.id, parts.die_no,parts.part_name,parts.part_no,parts.model')
            ->join('parts', 'parts.id = jobs.part_id')
            ->orderBy('jobs.id', 'DESC')
            ->where('jobs.side', $this->request->getVar('side'))
            ->limit(1) // Set the limit to 1 to fetch only one row
            ->get()
            ->getRow();

        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond(['error' => 'No data available'], 404);
    }
    public  function completed_list()
    {
        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = date("Y-m-d", strtotime($from_date));
            $to_date = $this->request->getVar('to_date');
            $t_date = date("Y-m-d", strtotime($to_date));
            $date = date("Y-m-d", strtotime('2023-10-31 00:00:00'));
            $this->jobsModel->where("DATE_FORMAT(created_at, '%Y-%m-%d') >= '" . $f_date . "'", null, false);
            $this->jobsModel->where("DATE_FORMAT(created_at, '%Y-%m-%d') <= '" . $t_date . "'", null, false);
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('part_name'));
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->jobsModel->where('part_id', $this->request->getVar('die_no'));
        }
        $result = $this->jobsModel->findAll();
        $combinedResults  = array();
        foreach ($result as $result_arr) {
            $partId = $result_arr['part_id']; // Assuming 'part_id' is a field in the jobs table.
            $this->PartsModel->where('id', $result_arr['part_id']);
            $partData = $this->PartsModel->first();
            if ($partData) {
                // Combine the data from the two tables and store it in the results array.
                $combinedResult = array_merge($result_arr, $partData);
                $combinedResults[] = $combinedResult;
            }
        }

        return $this->respond($combinedResults, 200);
    }
    public function history_list()
    {
        if (!empty($this->request->getVar('die_no'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('die_no'));
        }
        if (!empty($this->request->getVar('part_no'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('part_no'));
        }
        if (!empty($this->request->getVar('model'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('model'));
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->jobshistoryModel->where('jobs_history.part_id', $this->request->getVar('part_name'));
        }

        if ($this->request->getVar('from_date') && $this->request->getVar('to_date')) {
            $from_date = $this->request->getVar('from_date');
            $f_date = date("Y-m-d", strtotime($from_date));
            $to_date = $this->request->getVar('to_date');
            $t_date = date("Y-m-d", strtotime($to_date));
            $this->jobshistoryModel->where("DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') >= '" . $f_date . "'", null, false);
            $this->jobshistoryModel->where("DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') <= '" . $t_date . "'", null, false);
        }

        $this->jobshistoryModel->select('parts.*');
        $this->jobshistoryModel->join('parts', 'jobs_history.part_id = parts.id');
        $result = $this->jobshistoryModel->findAll();
        return $this->respond($result, 200);
        //    return $result;
    }
    public function set_api_jobs()
    {
        $array = $this->request->getVar('pins');
        $result = array();
        foreach ($array as $key => $value) {
            $correct_inserted = trim($value['correct_inserted']);
            $correct_inserted_value = ($correct_inserted === 'true') ? 1 : 0;
            $result[$key] = $correct_inserted_value;
        }
        ksort($result);
        $json_pins = json_encode($result);

        $this->jobsModel->where('part_id', $this->request->getVar('part_id'));
        $jobs =  $this->jobsModel->first();
        if (empty($jobs)) {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'created_by' => $this->session->get('id'),
                'start_time' => date('Y-m-d H:i:s')
            ];
            $result_arr['id'] = $this->jobsModel->insert($data, true);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessMsg');
        } else {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'updated_by' => $this->session->get('id'),
                'end_time' => date('Y-m-d H:i:s')
            ];
            $id = $jobs['id'];
            $result_arr['id'] = $this->jobsModel->update($id, $data);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
        }
        return $this->respond($result_history, 200);
    }

    public function add_job()
    {

        try {

            $part_id = $this->request->getVar('part_id');

            if (empty($part_id)) {
                throw new Exception("Please provide 'part_id' parameter value");
            }

            $json_pins = $this->request->getVar('pins');

            if (empty($json_pins)) {
                throw new Exception("Please provide 'pins' parameter value");
            }

            $side = $this->request->getVar('side');

            if (empty($side)) {
                throw new Exception("Please provide 'side' parameter value");
            }


            /*$result = array();
            foreach ($array as $key => $value) {
                $correct_inserted = trim($value['correct_inserted']);
                $correct_inserted_value = ($correct_inserted === 'true') ? 1 : 0;
                $result[$key] = $correct_inserted_value;
            }
            ksort($result);
            $json_pins = json_encode($result); */

            $this->jobsModel->where('part_id', $part_id);
            $jobs =  $this->jobsModel->first();
            if (empty($jobs)) {
                $data = [
                    'part_id' => $part_id,
                    'side' => $side,
                    'pins' => $json_pins,
                    'created_by' => 1,
                    'start_time' => date('Y-m-d H:i:s')
                ];
                $result_arr['id'] = $this->jobsModel->insert($data, true);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
                $result_history['msg'] =  lang('Jobs.JobsapiSuccessMsg');
            } else {
                $data = [
                    'part_id' => $part_id,
                    'side' => $side,
                    'pins' => $json_pins,
                    'updated_by' => 1,
                    'end_time' => date('Y-m-d H:i:s')
                ];
                $id = $jobs['id'];
                $result_arr['id'] = $this->jobsModel->update($id, $data);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->jobshistoryModel->insert($history_data, true);
                $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
            }
            return $this->respond($result_history, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function set_job_actions()
    {
        try {
            if ($this->request->getVar('time') == 'start_time') {
                $data = [
                    'part_id' => $this->request->getVar('part_id'),
                    'side' => $this->request->getVar('side'),
                    'start_time' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->get('id'),
                ];
                $result['id'] = $this->JobActionsModel->insert($data, false);
                $result['msg'] = lang('Jobs.AddJobbActionSuccss');
                $result['lastInsertid'] = $this->JobActionsModel->insertID();
            } else {
            
                $id  = $this->request->getVar('id');
                $data = [
                    'side' => $this->request->getVar('side'),
                    'end_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->get('id'),
                ];
                $result['id'] = $this->JobActionsModel->update($id, $data);
                $result['msg'] = lang('Jobs.UpdateJobbActionSuccss');
            }
            return $this->respond($result, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }

    }

    public function get_job_status(){

        $this->JobActionsModel = new JobActionsModel();

        $result = $this->JobActionsModel
            ->select('part_id, side, start_time, end_time')
            ->orderBy('id', 'DESC')
            ->where('end_time IS NULL')
            //->limit(1) // Set the limit to 1 to fetch only one row
            ->get()
            ->getResult();

        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond([['error' => true, 'message' => 'No job started']], 404);
    }

}
