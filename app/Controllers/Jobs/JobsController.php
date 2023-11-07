<?php

namespace App\Controllers\Jobs;

use App\Controllers\BaseController;
use App\Models\PartsModel;
use App\Models\JobsHistoryModel;
use App\Models\JobActionsModel;

class JobsController extends BaseController
{
    protected $partModel;
    protected $jobshistoryModel;
    protected $jobActionModel;
    function __construct()
    {
        $this->partModel = new PartsModel();
        $this->jobshistoryModel = new JobsHistoryModel();
        $this->jobActionModel = new JobActionsModel();
    }
    public function List()
    {
        $data['request'] = $this->request;
        return view('jobs/list', $data);
    }

    public function Create()
    {
         $data['parts'] =$this->partModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('jobs/add', $data);
    }
    public function Create_left()
    {
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('jobs/add_left', $data);
    }
    public function Right_job()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
        $data['jobs'] = $this->jobActionModel->where('end_time IS NULL')->where('side', 'right')->orderBy('id', 'DESC')->limit(1)->findAll();

        $data['request'] = $this->request;
        return view('jobs/right_job', $data);
    }
    public function Left_job()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] = $partsModel->where('is_active', '1')->findAll(); 

        $data['jobs'] = $this->jobActionModel->where('end_time IS NULL')->where('side', 'left')->orderBy('id', 'DESC')->limit(1)->findAll();

        $data['request'] = $this->request;
        return view('jobs/left_job', $data);
    }

    public function Edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('jobs/edit', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('jobs/remove', $data);
    }

    public function completed_jobs(){
        $data['request'] = $this->request;
        $data['part'] = $this->partModel
        ->select('parts.id, parts.die_no,parts.part_name,parts.part_no,parts.model')      
        ->join('jobs', 'jobs.part_id=parts.id')->findAll();  
        return view('jobs/completed_job', $data);
    }

    public function job_history()
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
     *  
     */
    public function completed_jobs_list(){
        $data['request'] = $this->request;
        $all_parts = $this->partModel
        ->select('parts.id,parts.die_no,parts.part_name,parts.part_no,parts.model')      
        ->where('parts.is_active', '1')->findAll();
        $data['part'] = $all_parts;
        return view('jobs/completed_job_list', $data);
    }
}
