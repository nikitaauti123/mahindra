<?php
/**  
 * JobsApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsApiController_Class
 * @package  JobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Jobs\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Phpspreadsheet;
use App\Models\JobsModel;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
use App\Models\NotificationModel;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLS;
use DateTime;
use Exception;

/**
 * JobsApiController Class Doc Comment
 * 
 * JobsApiController Class
 * 
 * @category JobsApiController_Class
 * @package  JobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class JobsApiController extends BaseController
{
    use ResponseTrait;
    private $_jobsModel;
    private $_PartsModel;
    private $_session;
    private $_jobshistoryModel;
    private $_JobActionsModel;
    private $_phpspreadsheet;
    private $_notificationModel;
    /**
     * Constructor for the JobsApiController class.
     */
    public function __construct()
    {
        $this->_jobsModel = new JobsModel();
        $this->_PartsModel = new PartsModel();
        $this->_jobshistoryModel = new JobsHistoryModel();
        $this->_session = \Config\Services::session();
        $this->_JobActionsModel = new JobActionsModel();
        $this->_phpspreadsheet = new Phpspreadsheet();
        $this->_notificationModel = new NotificationModel();
    }
    /**
     * Method for handling list in the  JobsController.
     * 
     * @return \Illuminate\Http\Response; 
     */
    public function list()
    {
        $result = $this->_jobsModel->findAll();
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
    
    /**
     * Method for handling single value in the  JobsController.
     *
     * @param $id get id of jobs.
     * 
     * @return text;
     */
    public function getOne($id)
    {
        try {
            $result = $this->_jobsModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            }
            return $this->respond([], 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling add opration  JobsController.
     * 
     * @return text;
     */
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
            $data['is_active'] = $this->request->getVar('is_active') 
            ? $this->request->getVar('is_active') 
            : 0;
            $data['pins'] =  $this->request->getVar('selected_pins');

            $result['id'] = $this->_jobsModel->insert($data, true);
            $result['msg'] = lang('Jobs.JobsSuccessMsg');

            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling update opration  JobsController.
     * 
     * @param $id update job id of jobs.
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
            $data['is_active'] = $this->request->getVar('is_active')
             ? $this->request->getVar('is_active')
              : 0;
            $data['pins']      =  $this->request->getVar('selected_pins');

            $result['is_updated'] = $this->_jobsModel->update($id, $data);
            $result['msg'] = lang('Jobs.JobsSuccessUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling delete opration  JobsController.
     * 
     * @param $id update job id of jobs.
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

            $result['is_deleted'] = $this->_jobsModel->delete($id);
            $result['msg'] = "Job deleted successfully!";
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling update active records opration  JobsController.
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
            $result['msg'] =  lang('Jobs.StatusUpdateMsg');
            $result['id'] = $this->_jobsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for getting api data opration  JobsController.
     *  
     * @return text;
     */
    public function getApiData()
    {
        $part_id = $this->request->getVar('part_id');
        if (!empty($part_id)) {
            $result = $this->_jobsModel
                ->select(
                    'parts.pins,
                    jobs.side,
                    parts.id,
                    parts.die_no,
                    parts.part_name,
                    parts.part_no,
                    parts.model'
                )
                ->join('parts', 'jobs.part_id = parts.id', 'right')
                ->orderBy('jobs.id', 'DESC')
                // ->where('jobs.side', $this->request->getVar('side'))
                ->where('parts.id', $this->request->getVar('part_id'))
                ->limit(1) // Set the limit to 1 to fetch only one row
                ->get()
                ->getRow();
        } else {
            $result = $this->_jobsModel
                ->select(
                    'parts.pins,
                    jobs.side,
                    parts.id,
                    parts.die_no,
                    parts.part_name,
                    parts.part_no,
                    parts.model'
                )
                ->join('parts', 'jobs.part_id = parts.id', 'right')
                ->orderBy('jobs.id', 'DESC')
                // ->where('jobs.side', $this->request->getVar('side'))
                //->where('parts.id', $this->request->getVar('part_id'))
                ->limit(1) // Set the limit to 1 to fetch only one row
                ->get()
                ->getRow();
        }

        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond(['error' => 'No data available'], 404);
    }
    /**
     * Method for showing list completed jobs.
     *  
     * @return text;
     */
    public  function completedList()
    {
        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = date("Y-m-d", strtotime($from_date));
                $to_date = $this->request->getVar('to_date');
                $t_date = date("Y-m-d", strtotime($to_date));
                $date = date("Y-m-d", strtotime('2023-10-31 00:00:00'));
                $this->_jobsModel->where(
                    "DATE_FORMAT(created_at, '%Y-%m-%d') >= '" . $f_date . "'",
                    null, 
                    false
                );
                $this->_jobsModel->where(
                    "DATE_FORMAT(created_at, '%Y-%m-%d') <= '" . $t_date . "'",
                    null, 
                    false
                );
            }
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->_jobsModel->where(
                'part_id', 
                $this->request->getVar('part_name')
            );
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->_jobsModel->where(
                'part_id', 
                $this->request->getVar('part_no')
            );
        }
        if (!empty($this->request->getVar('model'))) {
            $this->_jobsModel->where(
                'part_id',
                $this->request->getVar('model')
            );
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->_jobsModel->where(
                'part_id',
                $this->request->getVar('die_no')
            );
        }
        $result = $this->_jobsModel->findAll();
        $combinedResults  = array();
        foreach ($result as $result_arr) {
            $partId = $result_arr['part_id']; 
            $this->_PartsModel->where('id', $result_arr['part_id']);
            $partData = $this->_PartsModel->first();
            if ($partData) {
                $combinedResult = array_merge(
                    $result_arr, $partData
                );
                $combinedResults[] = $combinedResult;
            }
        }

        return $this->respond($combinedResults, 200);
    }
    /**
     * Method for showing list of job history .
     *  
     * @return text;
     */
    public function historyList()
    {
        if (!empty($this->request->getVar('die_no'))) {
            $this->_jobshistoryModel->where(
                'jobs_history.part_id',
                $this->request->getVar('die_no')
            );
        }
        if (!empty($this->request->getVar('part_no'))) {
            $this->_jobshistoryModel->where(
                'jobs_history.part_id', 
                $this->request->getVar('part_no')
            );
        }
        if (!empty($this->request->getVar('model'))) {
            $this->_jobshistoryModel->where(
                'jobs_history.part_id',
                $this->request->getVar('model')
            );
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->_jobshistoryModel->where(
                'jobs_history.part_id',
                $this->request->getVar('part_name')
            );
        }

        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = date("Y-m-d", strtotime($from_date));
                $to_date = $this->request->getVar('to_date');
                $t_date = date("Y-m-d", strtotime($to_date));
                
                $this->_jobshistoryModel->where(
                    "DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') >= '" .
                    $f_date . "'",
                    null,
                    false
                );
                
                $this->_jobshistoryModel->where(
                    "DATE_FORMAT(jobs_history.created_at, '%Y-%m-%d') <= '" .
                     $t_date . "'",
                    null,
                    false
                );
            }
            
        }

        $this->_jobshistoryModel->select('parts.*');
        $this->_jobshistoryModel->join('parts', 'jobs_history.part_id = parts.id');
        $result = $this->_jobshistoryModel->findAll();
        return $this->respond($result, 200);
        //    return $result;
    }
    /**
     * Method for setting/adding api jobs .
     *  
     * @return text;
     */
    public function setApiJobs()
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

        $this->_jobsModel->where('part_id', $this->request->getVar('part_id'));
        $jobs =  $this->_jobsModel->first();
        if (empty($jobs)) {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'created_by' => $this->_session->get('id'),
                'start_time' => date('Y-m-d H:i:s')
            ];
            $result_arr['id'] = $this->_jobsModel->insert($data, true);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->_jobshistoryModel->insert(
                $history_data,
                true
            );
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessMsg');
        } else {
            $data = [
                'part_id' => $this->request->getVar('part_id'),
                'side' => $this->request->getVar('side'),
                'pins' => $json_pins,
                'updated_by' => $this->_session->get('id'),
                'end_time' => date('Y-m-d H:i:s')
            ];
            $id = $jobs['id'];
            $result_arr['id'] = $this->_jobsModel->update($id, $data);
            $history_data = [
                'part_id' => $this->request->getVar('part_id'),
                'job_id' => $result_arr['id'],
                'pins' => $json_pins,
                'is_active' => '1',
            ];
            $result_history['id'] = $this->_jobshistoryModel->insert(
                $history_data,
                true
            );
            $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
        }
        return $this->respond($result_history, 200);
    }
    /**
     * Method for setting/adding api jobs .
     *  
     * @return text;
     */
    public function addJob()
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

            $this->_jobsModel->where('part_id', $part_id);
            $this->_jobsModel->orderBy('id', 'desc');
            $jobs =  $this->_jobsModel->first();

            if (empty($jobs)) {
                $data = [
                    'part_id' => $part_id,
                    'side' => $side,
                    'pins' => $json_pins,
                    'created_by' => 1,
                    'start_time' => date('Y-m-d H:i:s')
                ];
                $result_arr['id'] = $this->_jobsModel->insert($data, true);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->_jobshistoryModel->insert(
                    $history_data, 
                    true
                );
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
                $result_arr['id'] = $this->_jobsModel->update($id, $data);
                $history_data = [
                    'part_id' => $part_id,
                    'job_id' => $result_arr['id'],
                    'pins' => $json_pins,
                    'is_active' => '1',
                ];
                $result_history['id'] = $this->_jobshistoryModel->insert(
                    $history_data,
                    true
                );
                $result_history['msg'] =  lang('Jobs.JobsapiSuccessUpdateMsg');
            }
            return $this->respond($result_history, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    /**
     * Method to start jobs and end jobs.
     * 
     * @param String $part_id - Part Id
     * @param String $side - side
     *  
     * @return text;
     */
    public function setJobActions()
    {
        try {
            $user_id = $this->_session->get('id') ? $this->_session->get('id') : 1;

            if ($this->request->getVar('time') == 'end_time') {
             
                $id  = $this->request->getVar('job_id')?$this->request->getVar('job_id'):$this->request->getVar('id');
                
                $affected = $this->_JobActionsModel->updateData(
                    $id,
                    $this->request->getVar('side'), 
                    $user_id, 
                    date('Y-m-d H:i:s')
                );
                if ($affected > 0) {
                    $result['msg'] = lang('Jobs.UpdateJobbActionSuccss');
                } else {
                    throw new Exception("Not updated");
                }
            } else {

                $data = [
                    'part_id' => $this->request->getVar('part_id'),
                    'side' => $this->request->getVar('side'),
                    'start_time' => date('Y-m-d H:i:s'),
                    'created_by' => $user_id,
                ];
                $result['id'] = $this->_JobActionsModel->insert($data, false);
                $result['msg'] = lang('Jobs.AddJobbActionSuccss');
                $result['lastInsertid'] = $this->_JobActionsModel->insertID();

                $data = [
                    'job_action_id' => $result['lastInsertid'],
                    'part_id' => $this->request->getVar('part_id'),
                    'side' => $this->request->getVar('side'),
                    'pins' => '',
                    'created_by' => 1,
                    'start_time' => date('Y-m-d H:i:s')
                ];
                $result_arr['id'] = $this->_jobsModel->insert($data, true);
            }
            return $this->respond($result, 200);
        } catch (Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for setting/adding api jobs .
     *  
     * @param $id job image id to update image
     * 
     * @return text;
     */
    public function updateImage($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $rules = [
                'image_url'  => 'required|max_length[255]'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $this->_JobActionsModel = new JobActionsModel();

            $data['image_url'] = $this->request->getVar('image_url');

            if($this->request->getVar('wrong_pins')) {
                $data['wrong_pins'] = $this->request->getVar('wrong_pins');
            }
            if($this->request->getVar('correct_pins')) {
                $data['correct_pins'] = $this->request->getVar('correct_pins');
            }
            if($this->request->getVar('pin_up_time')) {
                $data['pin_up_time'] = $this->request->getVar('pin_up_time');
            }
            if($this->request->getVar('pin_down_time')) {    
                $data['pin_down_time'] = $this->request->getVar('pin_down_time');
            }    

            $result['is_updated'] = $this->_JobActionsModel->update($id, $data);
            $result['msg'] = lang('Jobs.JobsSuccessUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for getting job status .
     *  
     * @return text;
     */
    public function getJobStatus()
    {

        //ini_set('max_execution_time', 1200);

        $this->_JobActionsModel = new JobActionsModel();

        $side = $this->request->getVar('side');

        if (!empty($side)) {
            $result = $this->_JobActionsModel
                ->select('id, part_id, side, start_time, end_time')
                ->orderBy('id', 'DESC')
                ->where('end_time IS NULL')
                ->where('side', $side)
                ->limit(1) // Set the limit to 1 to fetch only o ne row
                ->get()
                ->getRow();        //->getResult();
        } else {
            $result = $this->_JobActionsModel
                ->select('id, part_id, side, start_time, end_time')
                ->orderBy('id', 'DESC')
                ->where('end_time IS NULL')
                ->limit(1) // Set the limit to 1 to fetch only o ne row
                ->get()
                ->getRow(); 
        }

        if ($result) {
            return $this->respond($result, 200);
        }
        return $this->respond(
            ['error' => true, 'message' => 'No job started'],
            404
        );
    }
    /**
     * Method for get job status by die no.
     *  
     * @return JSON;
     */
    public function getJobStatuByDieNo()
    {

        try {

            $this->_JobActionsModel = new JobActionsModel();
        
            $die_no = $this->request->getVar('die_no');
            if(empty($die_no)) {
                throw new Exception("Die no is required");
            }
    
            if (!empty($die_no)) {
                $result = $this->_JobActionsModel
                    ->select(
                        'job_actions.id as job_id, 
                        job_actions.part_id as part_id, 
                        job_actions.side as side, 
                        job_actions.start_time as start_time, 
                        job_actions.end_time as end_time,
                        job_actions.wrong_pins as wrong_pins,
                        job_actions.correct_pins as correct_pins'
                    )
                    ->join('parts', 'job_actions.part_id = parts.id')
                    ->where('parts.die_no', $die_no)
                    ->orderBy('job_actions.id', 'DESC')
                    ->limit(1) // Set the limit to 1 to fetch only o ne row
                    ->get()
                    ->getRow();
            } else {
                $result = $this->_JobActionsModel
                    ->select(
                        'job_actions.id as job_id, 
                        job_actions.part_id as part_id, 
                        job_actions.side as side, 
                        job_actions.start_time as start_time, 
                        job_actions.end_time as end_time,
                        job_actions.wrong_pins as wrong_pins,
                        job_actions.correct_pins as correct_pins'
                    )
                    ->join('parts', 'job_actions.part_id = parts.id')
                    ->orderBy('job_actions.id', 'DESC')
                    ->limit(1) // Set the limit to 1 to fetch only o ne row
                    ->get()
                    ->getRow(); 
            }
    
            if ($result) {
                return $this->respond($result, 200);
            }
            return $this->respond(
                ['error' => true, 'message' => 'No job started'],
                404
            );

        } catch(Exception $e) {
            return $this->respond(
                [
                    'error' => true, 
                    'message' => $e->getMessage()
                ],
                404
            );
        }

    }
    /**
     * Method for changing date formate .
     *  
     * @param $str string for date 
     * 
     * @return string;
     */
    private function _changeDateFormat($str)
    {
        $date_str = explode("/", $str);
        return $date_str[2] . "-" . $date_str[0] . "-" . $date_str[1];
    }
    /**
     * Method reports of completed list.
     *  
     * @return text;
     */
    public  function reportCompletedList()
    {
        $result = [];
        $this->_JobActionsModel = new JobActionsModel();
        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = $this->_changeDateFormat($from_date) . " 00:00:00";
                $to_date = $this->request->getVar('to_date');
                $t_date = $this->_changeDateFormat(($to_date)) . " 23:59:59";
                $this->_JobActionsModel->where(
                    "job_actions.start_time >= '" . $f_date . "'",
                    null,
                    false
                );
                $this->_JobActionsModel->where(
                    "job_actions.end_time <= '" . $t_date . "'", 
                    null, 
                    false
                );
            }
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->_JobActionsModel->where(
                'parts.part_name',
                $this->request->getVar('part_name')
            );
        }
    
        if (!empty($this->request->getVar('part_no'))) {
            $this->_JobActionsModel->where(
                'parts.part_no',
                $this->request->getVar('part_no')
            );
        }
        
        if (!empty($this->request->getVar('model'))) {
            $this->_JobActionsModel->where(
                'parts.model',
                $this->request->getVar('model')
            );
        }
        
        if (!empty($this->request->getVar('die_no'))) {
            $this->_JobActionsModel->where(
                'parts.die_no',
                $this->request->getVar('die_no')
            );
        }
        
        if (!empty($this->request->getVar('job_Action_id'))) {
            $this->_JobActionsModel->where(
                'job_actions.id',
                $this->request->getVar('job_Action_id')
            );
        }
        $result =  $this->_JobActionsModel
            ->select(
                'parts.*,
                job_actions.id as job_action_id,
                job_actions.part_id,
                job_actions.side,
                job_actions.image_url,
                job_actions.wrong_pins,
                job_actions.correct_pins,
                jobs.pins as detail_pins,
                job_actions.start_time,
                job_actions.end_time,
                job_actions.created_by,
                job_actions.updated_by'
            )   
            ->join('parts', 'job_actions.part_id = parts.id')
            ->join('jobs', 'job_actions.id = jobs.job_action_id')    
            ->where('job_actions.end_time IS NOT NULL')
            ->findAll();
 
                /* helper('debug');
                last_q();
                exit("sss"); */

        foreach ($result as $key => $result_arr) {
            if (isset($result_arr['start_time'])) {
                $result[$key]['start_time'] = date(
                    "d-m-Y h:i A",
                    strtotime($result_arr['start_time'])
                );
            }

            if (isset($result_arr['end_time'])) {
                $result[$key]['end_time'] = date(
                    "d-m-Y h:i A",
                    strtotime($result_arr['end_time'])
                );
            }

            $startTime = strtotime($result_arr['start_time']);
            $endTime = strtotime($result_arr['end_time']);
            $timeDiffSeconds = $endTime - $startTime;
            $totalTime = gmdate('H:i:s', $timeDiffSeconds);
            $result[$key]['total_time'] = $totalTime;
            $result[$key]['image_url'] = '-'; 

            if ($result_arr['part_id'] == '') {
                $result[$key]['image_url'] = '-';
            } else {
                ///  echo "not";
                $pins_detail = $this->_jobsModel
                    ->select('jobs.pins')
                    ->where('jobs.job_action_id', $result_arr['job_action_id'])
                    ->get()
                    ->getFirstRow();
                if ($pins_detail !== null) {
                    $result[$key]['image_url'] = $this->display_popup($key, $pins_detail);
                    $result[$key]['json'] =  $pins_detail;
                }
            }
        }

        return $this->respond($result, 200);
    }

    /**
     *  Display pins on popup
     * 
     * @param String $key           key
     * @param Object $pins_detail  pins data
     * 
     * @return String html
     */
    private function display_popup($key, $pins_detail) 
    {
        $poup_html = 
        '<button type="button" class="btn btn-primary" data-toggle="modal"
            data-target="#compl-'.$key.'">View</button>
        <!-- Modal -->
        <div class="modal fade" id="compl-'.$key.'" tabindex="-1" 
        role="dialog" aria-labelledby="complLabel" aria-hidden="true">
            <div class="modal-dialog
            modal-dialog-centered" role="document" style="max-width: 80%;">
            <div class="modal-content mx-auto" >
                <div class="modal-header">
                <h5 class="modal-title" id="complLabel">Pins</h5>
                <button type="button" class="close" 
                data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">';

                helper('common');

                $poup_html .= display_pins($pins_detail->pins);

                $poup_html .= '
                        </div>
                    </div>
                </div>
            </div>
            <!-- Your existing pins display HTML here -->
            <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" 
                  data-dismiss="modal">Close</button>
                 </div>
              </div>
            </div>
        </div>';

        return $poup_html;
    }

    /**
     * Method for report list for dashboard.
     * 
     * @return text;
     */
    public function reportListDashboard()
    {
        $result = $this->_JobActionsModel
            ->select(
                'parts.*,
                job_actions.id,
                job_actions.part_id,
                job_actions.end_time'
            )
            ->join('parts', 'job_actions.part_id = parts.id')
            ->orderBy('job_actions.id', 'DESC')
            ->where('job_actions.end_time IS NOT NULL', null, false)
            ->limit(10)
            ->get()
            ->getResult();
        $combinedData = [];
        foreach ($result as $result_arr) {
            $created_at = new DateTime($result_arr->end_time);
            $formatted_date = $created_at->format('d-m-Y h:i A');
            $result_arr->completed_time = $formatted_date;
            $combinedData[] = $result_arr;
        }
        return $this->respond($combinedData, 200);
    }
    
    /**
     * Method for export excel for completed job.
     * 
     * @return string;
     */
    public function exportCompletedJob()
    {
        $pdf_data = array();
        $date = date('Y-m-d H:i:s');
        $from_date =  date('d_m_Y', strtotime($this->request->getVar('from_date')));
        $to_date = date('d_m_Y', strtotime($this->request->getVar('to_date')));

        $file_name = "completed_jobs";


        $pdf_data['title'] = $file_name;
       
        $pdf_data['file_name'] = $file_name . '_' . $from_date . '_to_' . $to_date .
         '.xlsx';

        $col[] = 'Part No.';
        $col[] = 'Part Name';
        $col[] = 'Model';
        $col[] = 'Die No.';
        $col[] = 'Start Time';
        $col[] = 'End Time';
        $col[] = 'Total Time';
        $col[] = 'Image';
        $headers = excel_columns($col, 2);
        $pdf_data['headers'] = $headers;
        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {        
                $from_date = $this->request->getVar('from_date');
                $f_date = $this->_changeDateFormat($from_date) . " 00:00:00";
                $to_date = $this->request->getVar('to_date');
                $t_date = $this->_changeDateFormat(($to_date)) . " 23:59:59";

                $this->_JobActionsModel->where(
                    "start_time >= '" . $f_date . "'",
                    null,
                    false
                );
                $this->_JobActionsModel->where(
                    "end_time <= '" . $t_date . "'", 
                    null,
                    false
                );
            }
        }
        if (!empty($this->request->getVar('part_name'))) {
            $this->_JobActionsModel->where(
                'parts.part_name',
                $this->request->getVar('part_name')
            );
        }

        if (!empty($this->request->getVar('part_no'))) {
            $this->_JobActionsModel->where(
                'parts.part_no',
                $this->request->getVar('part_no')
            );
        }
        if (!empty($this->request->getVar('model'))) {
            $this->_JobActionsModel->where(
                'parts.model', 
                $this->request->getVar('model')
            );
        }
        if (!empty($this->request->getVar('die_no'))) {
            $this->_JobActionsModel->where(
                'parts.die_no',
                $this->request->getVar('die_no')
            );
        }

        $this->_JobActionsModel->select('*');
        $this->_JobActionsModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->_JobActionsModel->findAll();
        $data = array();
        $i = 1;
        if (count($result) > 0) {
            foreach ($result as $row) {
                $data[$i][] = (
                    (isset($row['part_no']) && !empty($row['part_no']))
                    ? $row['part_no']
                    : " "
                );
                                         
                $data[$i][] = (
                    (isset($row['part_name']) && !empty($row['part_name'])) 
                    ? $row['part_name'] 
                    : " "
                );
                $data[$i][] = (
                    (isset($row['model']) && !empty($row['model']))
                    ? $row['model'] 
                    : " "
                );
                $data[$i][] = (
                    (isset($row['die_no']) && !empty($row['die_no'])) 
                    ? $row['die_no'] 
                    : " "
                );
                $created_at = new DateTime($row['start_time']);
                $formatted_date = $created_at->format('d-m-Y h:i A');

                $created_at_start = new DateTime($row['end_time']);
                $formatted_date_start = $created_at_start->format('d-m-Y h:i A');
                $startTime = strtotime($row['start_time']);
                $endTime = strtotime($row['end_time']);
                $timeDiffSeconds = $endTime - $startTime;
                $totalTime = gmdate('H:i:s', $timeDiffSeconds);
                $data[$i][] = (
                    (isset($formatted_date) && !empty($formatted_date))
                    ? $formatted_date
                    : " "
                );                
                $data[$i][] = (
                    (isset($formatted_date_start) && !empty($formatted_date_start))
                    ? $formatted_date_start
                    : " "
                );                
                $data[$i][] = (
                    (isset($totalTime) && !empty($totalTime))
                    ? $totalTime
                    : " "
                );                
                $data[$i][] = (
                    (isset($row['image_url']) && !empty($row['image_url']))
                    ? $row['image_url']
                    : " "
                );
                $i++;
            }
        }
        $body = excel_columns($data, 2);

        $pdf_data['data'] = $body;
        $pdf_data['sheet'] = 'completed-jobs';
        $style_array =  array(
            'fill' => array(
                'color' => array('rgb' => 'FF0000')
            ),
            'font'  => array(
                'bold'  =>  true,
                'color' =>     array('rgb' => 'FF0000')
            )
        );
          $pdf_data['style_array'] = $style_array;
          $this->_phpspreadsheet->set_data($pdf_data);
    }
     /**
      * Method for pdf export for completed job.
      * 
      * @return string;
      */
    public function pdfCompletedJob()
    {
        $pdf_data = array();
        $date = date('Y-m-d H:i:s');
        $from_date =  date('d_m_Y', strtotime($this->request->getVar('from_date')));
        $to_date = date('d_m_Y', strtotime($this->request->getVar('to_date')));
        $file_name = "completed_jobs";
        $file_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $file_name);
        $pdf_data['title'] =  $file_name . '_' . $from_date . '_to_' . $to_date;
         
        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = $this->_changeDateFormat($from_date) . " 00:00:00";
                $to_date = $this->request->getVar('to_date');
                $t_date = $this->_changeDateFormat(($to_date)) . " 23:59:59";
                $this->_JobActionsModel->where(
                    "start_time >= '" . $f_date . "'",
                    null,
                    false
                );
                $this->_JobActionsModel->where(
                    "end_time <= '" . $t_date . "'",
                    null,
                    false
                );
            }
        }
        
        if (!empty($this->request->getVar('part_name'))) {
            $this->_JobActionsModel->where(
                'parts.part_name',
                $this->request->getVar('part_name')
            );
        }
        
        if (!empty($this->request->getVar('part_no'))) {
            $this->_JobActionsModel->where(
                'parts.part_no',
                $this->request->getVar('part_no')
            );
        }
        
        if (!empty($this->request->getVar('model'))) {
            $this->_JobActionsModel->where(
                'parts.model',
                $this->request->getVar('model')
            );
        }
        
        if (!empty($this->request->getVar('die_no'))) {
            $this->_JobActionsModel->where(
                'parts.die_no',
                $this->request->getVar('die_no')
            );
        }
       
        $this->_JobActionsModel->select('*');
        $this->_JobActionsModel->join('parts', 'job_actions.part_id = parts.id');
        $result = $this->_JobActionsModel->findAll();
        $inputPath = '' . FCPATH . '\assets\img\Mahindra_Logo_hor.jpg';
        // Start building the HTML content
        $htmlContent = '<h3 style="text-align:center">Completed Jobs</h3>
        <table border="1" style="border-collapse:collapse,width: 100%;">
        <thead>
            <tr style="background-color:#3465a4;width: 100%;color:white">
            <th  style="color:white">Sr. No.</th>
                <th  style="width: 80px;color:white">Part No.</th>
                <th  style="width: 120px;color:white">Part Name</th>
                <th  style="width: 80px;color:white">Model</th>
                <th style="width: 80px;color:white">Die No.</th>
                <th style="width: 80px;color:white">Start Time</th>
                <th style="width: 80px;color:white">End Time</th>
                <th style="width: 80px;color:white">Total Time</th>
                <th style="width: 80px;color:white">Not Ok Pins</th>
                <th style="width: 80px;color:white">OK Pins</th>
                <th style="width: 80px;color:white">Total Pins</th>
                <th style="width: 80px;color:white">OK Pins (%)</th>
                <th style="width: 120px;color:white">Image</th>
            </tr>
        </thead>
        <tbody>';

        $k = 1;
        foreach ($result as $row) {
            $created_at = new DateTime($row['start_time']);
            $formatted_date = $created_at->format('d-m-Y h:i A');

            $created_at_start = new DateTime($row['end_time']);
            $formatted_date_start = $created_at_start->format('d-m-Y h:i A');

            $startTime = strtotime($row['start_time']);
            $endTime = strtotime($row['end_time']);
            $timeDiffSeconds = $endTime - $startTime;
            $totalTime = gmdate('H:i:s', $timeDiffSeconds);
            $defalut_img = '' . FCPATH . '\assets\img\no_image_found.png';
            $htmlContent .= '<tr>';
            $htmlContent .= '<td  style="width: 40px;" >' . $k++ . '</td>';

            $htmlContent .= '<td style="width: 80px;">' .
            htmlspecialchars(isset($row['part_no']) ? $row['part_no'] : '') .
            '</td>';
            $htmlContent .= '<td style="width: 120px;">' . 
            htmlspecialchars(isset($row['part_name']) ? $row['part_name'] : '') . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(isset($row['model']) ? $row['model'] : '') . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(isset($row['die_no']) ? $row['die_no'] : '') . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(isset($formatted_date) ? $formatted_date : '') . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(
                isset($formatted_date_start) ? $formatted_date_start : ''
            ) . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(
                isset($totalTime) ? $totalTime : ''
            ) . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(isset($row['wrong_pins']) ? $row['wrong_pins'] : 0) . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(
                isset($row['correct_pins']) ? $row['correct_pins'] : 0
            ) . 
            '</td>';
            $htmlContent .= '<td style="width: 80px;">' . 
            htmlspecialchars(
                isset($row['pins']) ? count(explode(",", $row['pins'])) : 0
            ) . 
            '</td>';
            $correctPins = isset($row['correct_pins']) ? $row['correct_pins'] : 0;
            $pinsCount = count(explode(",", $row['pins']));
            $percentage = number_format($correctPins / $pinsCount * 100, 2);
            
            $htmlContent .= '<td style="width: 80px;">
            ' . htmlspecialchars($percentage) . '
            </td>';      
            $htmlContent .= '<td style="width: 120px;">' . 
            (isset($row['image_url']) ? 
                '<a href="' . base_url() . 'assets/img/' . $row['image_url'] . '" >
                <img src="' . FCPATH . 'assets/img/' . $row['image_url'] . '">
                </a>' : 
                '<img src="' . $defalut_img . '" height="60" width="100">') . 
            '</td>';
            $htmlContent .= '</tr>';
        }

       

        $htmlContent .= '</tbody></table>';
        // print_r($htmlContent);exit;
        $pdf_data['pdfdata'] = $htmlContent;
        $this->_phpspreadsheet->set_pdf($pdf_data);
    }
    /**
     * Method for get part details.
     * 
     * @param $id job_action_id  to get part details
     * 
     * @return text;
     */
    public function sendPartDetails($id)
    {
        try{
            //$id=71;
            $result_job = $this->_JobActionsModel
                ->select(
                    'parts.*,
                job_actions.id,
                job_actions.part_id,
                job_actions.image_url,
                job_actions.part_id,
                job_actions.side,
                job_actions.start_time,
                job_actions.end_time,
                job_actions.correct_pins,
                job_actions.wrong_pins,
                parts.pins as total_pins
                ')
                ->join('parts', 'parts.id = job_actions.part_id', 'left') 
                ->where('job_actions.id', $id)
                ->get()
                ->getFirstRow();
                
                $pins_detail = $this->_jobsModel
                    ->select('jobs.pins')
                    ->where('jobs.part_id', $result_job->part_id)
                    ->get()
                    ->getFirstRow();
                  //  print_r($result_job);exit;
                $array = explode(',', $result_job->total_pins);
                $countedValues = array_count_values($array);
                $body = '<p>Dear Sir/Madam,</p>';
                $body .= '<p>Here are the job details:</p>';

                // Start of the table
                $body .= '<table border="1">';
                $totalTime = strtotime($result_job->end_time) 
            - strtotime($result_job->start_time);
            if ($result_job->correct_pins != 0 && $result_job->total_pins != 0) {
                $correct_pins_count = (
                    $result_job->correct_pins / $result_job->total_pins
                ) * 100;                 
               
            } else {
                    $correct_pins_count = 000;
            }

                    $correct_pins_count_formatted = number_format(
                        $correct_pins_count,
                        2
                    );
                $defaultImagePath = FCPATH . 'assets/img/no_image_found.png';
                $startTime = new DateTime($result_job->start_time);
                $endTime = new DateTime($result_job->end_time);
                $body .= '<tr>
    <td><b>Part Name</b></td>
    <td>' . $result_job->part_name . '</td>
    <td><b>Ok Pins</b></td>
    <td>' . $result_job->correct_pins . '</td>
    </tr>
    <tr> 
    <td><b>Part No.</b></td><td>' . $result_job->part_no . ' </td>
    <td><b>Not Ok Pins</b></td><td>' . $result_job->wrong_pins . '</td>
    </tr>
    <tr> <td><b>Die No.</b></td><td>' . $result_job->die_no . ' </td>
    <td><b> Total Pins</b></td><td>' . count($countedValues) . '</td>
    </tr>
    <tr><td><b> Start Time</b></td><td>' . $startTime->format('d-m-y h:i A') . '</td>
    <td class="green_color"><b> Ok Pins(%)</b></td>
    <td class="green_color"><b>' . $correct_pins_count_formatted . '</b></td>
    </tr>
    <tr>
    <td><b> End Time</b></td><td>' . $endTime->format('d-m-y h:i A') . '</td>
    <td class="green_color"><b> Total Time</b></td><td class="green_color">
    <b>' . gmdate("H:i:s", $totalTime) . '</b></td>               
    </tr>';

                 $body .= '</table><div class="row">
    <div class="col-12">
        <div class="pins-display-wrapper">
            <div class="arrow-center">
            </div>
            <div class="pins-display no-click">
';
                $pin_states = $pins_detail->pins;
                $pin_states = json_decode($pin_states, true);
                $alphabets = 'A B C D E F G H I J K L M N O P Q R S T U V W X Y Z ' .
                'AA AB';
                 $col_array = explode(" ", $alphabets);
            for ($i = 1; $i <= 14; $i++) {
                for ($j = 0; $j < count($col_array); $j++) {
                    $pin_id = $col_array[$j] . $i;
                    if (isset($pin_states[$pin_id])) {
                        $pin_value = $pin_states[$pin_id];
                        $pin_class = ($pin_value == 1) ? 'pin-box green-pin' :
                        'pin-box red-pin';
                    } else {
                        $pin_class = 'pin-box gray-pin';
                    }
                    $body .= '<div id="' . $pin_id . '" title="' . $pin_id . '" ' .
                      'class="' . $pin_class . '">' . $pin_id . '</div>';

                    if (($j + 1) % 14 == 0 && ($j / 14) % 2 == 0) {
                        $body .= '<div class="x-axis-line"></div>';
                    }
                }
                if (($i + 1) % 8 == 0) {
                    $body .= '<div class="y-axis-line"></div>';
                }
            }

                    $body .= '</div>
    <div class="arrow-center">
    <div class="front">Front</div>

    </div>
</div>
</div>
</div>';


     

                $body .= '<p>Thank You</p>';
                $body .= '<p>==================================================' .
                '==============================================================' .
                '========================================== ' .
                'Do not reply to this email, this is an automated email.
</p>
    <style>
    .pins-display .pin-box {
        float: left;
        width: 34px;
        height: 34px;
        margin: 2px;
        text-align: center;
        background-color: #ffffff;
        line-height: 35px;
        font-size: 10px;
        cursor: pointer;
        border-radius: 50%;
        color: rgba(255, 255, 255, 1);
    }
   
    .front {
        font-size: 2vw;
        font-weight: bold;
        color: red;
        position: relative;
        left: -130px;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
      }
    .gray-pin{
        background: grey;
    }
    .green_color{
        background: #9add9a;
    }
    .pins-display {
        width: 1110px;
        overflow: hidden;
      
        position: relative;
        background-color: #FFF;
    }
    .pins-display-wrapper {
        overflow: auto;
        position: relative;
    }
    .pins-display div.gray-pin {
        background-color: var(--gray);
        background: gray;
    }
    .arrow-center {
        margin: 0 auto;
        width: 1110px;
        text-align: center;
        background: #fff;
        padding: 10px;
    }
   
    
    .pins-display div.gray-pin {
        background-color: var(--gray);
        background: gray;
    }
    .pins-display div.red-pin {
        background-color: var(--gray);
        background: red;
    }
    .pins-display div.green-pin {
        background-color: var(--gray);
        background: green;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }
    .dark-mode .card {
        background-color: #343a40;
        color: #fff;
    }
    .card {
       
        word-wrap: break-word;
        
    }
    .pins-display .x-axis-line {
        width: 3px;
        height: 30px;
        background-color: black;
        float: left;
        margin-bottom: -11px;
        margin: 0 3px;
    }
    .pins-display .y-axis-line {
        width: 99%;
        background-color: black;
        height: 3px;
        float: left;
        margin: 3px 0px;
    }
    </style>';
    //  print_r($body);exit;
            if (send_email(env('To_Email'), 'Jobs Details', $body,'')) {
                    $result['msg'] = lang('Jobs.JobDetailMailSuccess');
            } else {
                $result['msg'] = 'mail failed';
        
            }
       
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
     /**
     * Method for update notification status .
     *  
     * @return boolean  return update status result notification ;
     */
    public function changeNotificationStatus(){
        try {
            $id=$this->request->getVar('id');
            if(empty($id)) {
                throw new Exception('id is required');
            }
            $data['status'] = "viewed";
            $this->_notificationModel->update($id, $data);
            $result['msg'] = lang('Jobs.NotificationViewd');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
     /**
     * Method for getting all notification .
     *  
     * @return array  return all notification ;
     */
    public  function getAllNotification(){
        try {
            $result['notification'] = $this->_notificationModel
            ->select('*')
            ->where('status', 'pending')
            ->get()
            ->getResult();
           return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    /**
     * Method for handling add notifications.
     * 
     * @return text;
     */
    public function addNotification()
    {

        try {
            helper(['form']);

            $rules = [
                'die_no'  => 'required|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['die_no']    = $this->request->getVar('die_no');
            $data['msg']       = 'Layout of die no ('.$data['die_no'].') is not configured in this system';
            $data['status']    = 'pending';

            $result['id'] = $this->_notificationModel->insert($data, true);
            
            $result['msg'] = lang('Jobs.NotificationAdded');

            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}
