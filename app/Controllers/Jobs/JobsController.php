<?php

namespace App\Controllers\Jobs;

use App\Controllers\BaseController;
use App\Models\PartsModel;

class JobsController extends BaseController
{
    protected $partModel;
    function __construct()
    {
        $this->partModel = new PartsModel();
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
        $data['request'] = $this->request;
        return view('jobs/right_job', $data);
    }
    public function Left_job()
    {
        helper('WebSocketHelper');
        $partsModel = new PartsModel();
        $data['parts'] =$partsModel->where('is_active', '1')->findAll(); 
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
}
