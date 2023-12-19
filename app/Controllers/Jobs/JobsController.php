<?php
/**  
 * JobsController file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsController_Class
 * @package  JobsController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Jobs;

use App\Controllers\BaseController;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;
/**
 * JobsController Class Doc Comment
 * 
 * JobsController Class
 * 
 * @category JobsController_Class
 * @package  JobsController_Class
 * @author   Author <author@domain.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */
class JobsController extends BaseController
{
    protected $partModel;
    protected $jobshistoryModel;
    protected $jobActionModel;
    /**
     * Constructor for the JobsController class.
     */
    function __construct()
    {
        $this->partModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->jobActionModel = new JobActionsModel();
    }
    /**
     * Method for handling list in the  JobsController.
     * 
     * @return view; 
     */
    public function list()
    {
        $data['request'] = $this->request;
        return view('jobs/list', $data);
    }
    /**
     * Method for handling add operation in the  JobsController.
     * 
     * @return view; 
     */
    public function create()
    {
         $data['parts'] =$this->partModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('jobs/add', $data);
    }
    /**
     * Method for handling add create left job page.
     * 
     * @return view; 
     */
    public function createLeft()
    {
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('jobs/add_left', $data);
    }
    /**
     * Method for handling add right job page.
     * 
     * @return view; 
     */
    public function rightJob()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
        $data['jobs'] = $this->jobActionModel
            ->where('end_time IS NULL')
            ->where('side', 'right')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->findAll();
        $data['request'] = $this->request;
        return view('jobs/right_job', $data);
    }
    /**
     * Method for handling add create left job page.
     * 
     * @return view; 
     */
    public function leftJob()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] = $partsModel->where('is_active', '1')->findAll(); 

        $data['jobs'] = $this->jobActionModel
            ->where('end_time IS NULL')
            ->where('side', 'left')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->findAll();

        $data['request'] = $this->request;
        return view('jobs/left_job', $data);
    }
    /**
     * Method for handling add right side tv page .
     * 
     * @return view; 
     */
    public function rightSideTv()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
        $data['jobs'] = $this->jobActionModel
            ->where('end_time IS NULL')
            ->where('side', 'right')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->findAll();

        $data['request'] = $this->request;
        return view('jobs/right_side_tv', $data);
    }
    /**
     * Method for handling add right side tv page .
     * 
     * @return view; 
     */
    public function leftSideTv()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] = $partsModel->where('is_active', '1')->findAll(); 

        $data['jobs'] = $this->jobActionModel
            ->where('end_time IS NULL')
            ->where('side', 'left')
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->findAll();

        $data['request'] = $this->request;
        return view('jobs/left_side_tv', $data);
    }
    /**
     * Method for handling edit operation .
     * 
     * @param $id id of job for edit operatioon
     * 
     * @return view; 
     */
    public function edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('jobs/edit', $data);
    }
    /**
     * Method for handling remove operation .
     * 
     * @return view; 
     */
    public function remove()
    {
        $data['request'] = $this->request;
        return view('jobs/remove', $data);
    }
    /**
     * Method for handling add right side tv page .
     * 
     * @return view; 
     */
    public function completedJobs()
    {
        $data['request'] = $this->request;
        $data['part'] = $this->partModel
            ->select(
                'parts.id,
                 parts.die_no,
                 parts.part_name,
                 parts.part_no,
                 parts.model'
            )      
            ->join('jobs', 'jobs.part_id=parts.id')->findAll();  
        return view('jobs/completed_job', $data);
    }

    /**
     * Method for handling job histroy page .
     * 
     * @return view; 
     */
    public function jobHistory()
    {
        $data['request'] = $this->request;
        $data['request'] = $this->request;
        $this->jobshistoryModel->distinct();
        $this->jobshistoryModel->select('parts.*');
        $this->jobshistoryModel->join('parts', 'jobs_history.part_id = parts.id');
        $data['part'] =  $this->jobshistoryModel->findAll();
        return view('jobs/job_history', $data);
    }

    /**
     * Method for handling add right side tv page .
     * 
     * @return view; 
     */
    public function completedJobsList()
    {
        $data['request'] = $this->request;
        $uri = service('uri'); 
        
        if (!empty($uri->getSegment(4))) {
            $part_id = $uri->getSegment(4);
                    $result = $this->jobActionModel
                        ->where('id', $part_id)
                        ->first();
                    $data['part_id'] = $result['part_id'];
        }
         // exit;
        $all_parts = $this->partModel
            ->select(
                'parts.id, 
                 parts.die_no,
                 parts.part_name,
                 parts.part_no, 
                 parts.model'
            )
            ->where('parts.is_active', '1')->findAll();
        $data['part'] = $all_parts;
        return view('jobs/completed_job_list', $data);
    }
}
