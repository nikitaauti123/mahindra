<?php
/**  
 * NextJobsApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category NextJobsApiController_Class
 * @package  NextJobsApiController_Class
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
use App\Models\NextJobsModel;

use DateTime;
use Exception;

/**
 * NextJobsApiController Class Doc Comment
 * 
 * NextJobsApiController Class
 * 
 * @category NextJobsApiController_Class
 * @package  NextJobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class NextJobsApiController extends BaseController
{
    use ResponseTrait;
    private $_session;
    private $_nextjobsModel;
    /**
     * Constructor for the NextJobsApiController class.
     */
    public function __construct()
    {
        $this->_nextjobsModel = new NextJobsModel();
    }

     /**
     * Fetch all data from next jobs table
     * 
     * @return \Illuminate\Http\Response; 
     */
    public function list()
    {
        $result = $this->_nextjobsModel->findAll();
        
        return $this->respond($result, 200);
    }
    
    /**
     * Get details on one id from next jobs table
     *
     * @param $id get id of jobs.
     * 
     * @return text;
     */
    public function getOne($id)
    {
        try {
            $result = $this->_nextjobsModel->find($id);
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
     * Add next job details in the table
     * 
     * @return JSON;
     */
    public function add()
    {

        try {
            helper(['form']);

            $rules = [
                'die_no'     => 'required',
                'side'       => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['die_no']  = $this->request->getVar('die_no');
            $data['side']    = $this->request->getVar('side');
            $data['is_started'] = $this->request->getVar('is_started');
            $data['start_time'] = $this->request->getVar('start_time');
            $data['end_time']   =  $this->request->getVar('end_time');

            $result['id'] = $this->_nextjobsModel->insert($data, true);
            $result['msg'] = lang('Jobs.nextJobAdded');

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
     * @return JSON;
     */
    public function update($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $rules = [
                'die_no'  => 'required',
                'side'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['die_no']  = $this->request->getVar('die_no');
            $data['side']    = $this->request->getVar('side');
            $data['is_started'] = $this->request->getVar('is_started');
            $data['start_time'] = $this->request->getVar('start_time');
            $data['end_time']   =  $this->request->getVar('end_time');


            $result['is_updated'] = $this->_nextjobsModel->update($id, $data);
            $result['msg'] = lang('Jobs.nextJobUpdated');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    /**
     * Add and Update next job details
     * 
     * @param $id update job id of jobs.
     * 
     * @return JSON;
     */
    public function add_update()
    {

        try {
            helper(['form']);


            $rules = [
                'die_no'  => 'required',
                'side'  => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['die_no']  = $this->request->getVar('die_no');
            $data['side']    = $this->request->getVar('side');
            if($this->request->getVar('is_started')) {
                $data['is_started'] = $this->request->getVar('is_started');
            }
            if($this->request->getVar('start_time')) {
                $data['start_time'] = $this->request->getVar('start_time');
            }
            if($this->request->getVar('end_time')) {
                $data['end_time']   =  $this->request->getVar('end_time');
            }    

            $check_rows = $this->_nextjobsModel
            ->select('*')
            ->where('side', $this->request->getVar('side'))
            ->limit(1)
            ->get()
            ->getRow();

            if($check_rows) {
                $result['is_updated'] = $this->_nextjobsModel->update($check_rows->id, $data);
                $result['msg'] = lang('Jobs.nextJobUpdated');
            } else {
                $this->_nextjobsModel->insert($data, true);
                $result['is_updated'] = false;
                $result['msg'] = lang('Jobs.nextJobAdded');
            }          
            
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

}    