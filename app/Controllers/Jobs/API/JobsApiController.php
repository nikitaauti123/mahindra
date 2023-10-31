<?php

namespace App\Controllers\Jobs\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JobsModel;
use App\Models\PartsModel;
use Exception;

Class JobsApiController extends BaseController
{
    use ResponseTrait;
    private $jobsModel;
    private $PartsModel;

    public function __construct()
    {
        $this->jobsModel = new JobsModel();
        $this->PartsModel = new PartsModel();
    }

    public function list()
    {
        $result = $this->jobsModel->findAll();
        return $this->respond($result, 200);
    }

    public function getOne($id)
    {
        try {
            $result = $this->jobsModel->find($id);
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
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name']  = $this->request->getVar('part_name');
            $data['part_no']    = $this->request->getVar('part_no');
            $data['model']      = $this->request->getVar('model');
            $data['is_active']  = $this->request->getVar('is_active')?$this->request->getVar('is_active'):0;
            $data['pins']      =  $this->request->getVar('selected_pins');
            
            $result['id'] = $this->jobsModel->insert($data, true);
            $result['msg'] = "Job added successfully!";
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
                'part_name'  => 'required|min_length[2]|max_length[100]',
                'part_no'  => 'required|min_length[3]|max_length[100]',
                'model'  => 'required|min_length[3]|max_length[100]',
                'is_active'  => 'required'
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name'] = $this->request->getVar('part_name');
            $data['part_no']   = $this->request->getVar('part_no');
            $data['model']     = $this->request->getVar('model');
            $data['is_active'] = $this->request->getVar('is_active')?$this->request->getVar('is_active'):0;
            $data['pins']      =  $this->request->getVar('selected_pins');
            
            $result['is_updated'] = $this->jobsModel->update($id, $data);
            $result['msg'] = "Job updated successfully!";
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

            $result['is_deleted'] = $this->jobsModel->delete($id);
            $result['msg'] = "Job deleted successfully!";
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
            $result['msg'] =  lang('Jobs.StatusUpdateMsg');
            $result['id'] = $this->jobsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    public function get_api_data(){
        
       
        $result = $this->jobsModel
        ->select('jobs.*, parts.die_no,parts.part_name,parts.part_no,parts.model')
        ->join('parts', 'parts.id = jobs.part_id')
        ->orderBy('jobs.id', 'DESC')
        ->where('jobs.side', $this->request->getVar('side'))
        ->limit(1) // Set the limit to 1 to fetch only one row
        ->get()
        ->getRow();
     /// return $this->respond($result, 200);
        //joins with part table fetch other details 
      
    //    $model = $this->PartsModel
    //    ->where('part_no', $result->part_id) // Order the results by 'id' in descending order (assuming 'id' is the primary key)
    //    ->first();
        
        if ($result) {
             $pins = json_decode($result->pins, true);
            
            if (is_array($pins)) {
                // Separate keys and values into comma-separated strings
                $keys = implode(',', array_keys($pins));
                $values = implode(',', $pins);
        
                // Create an associative array to store the formatted data
                $result = [
                    'keys' => $keys,
                    'values' => $values,
                    'part_no'=>$result->part_no,
                    'part_name'=>$result->part_name,
                    'die_no'=>$result->die_no,
                    'model'=>$result->model,
                ];
        
        
                return $this->respond($result, 200);
            }
        }
        return $this->respond(['error' => 'No data available'], 404);
    }
    public  function completed_list(){
        //   print_r($this->request);
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
       // print_r($this->jobsModel->findAll());
        $combinedResults  =array();
        foreach($result as $result_arr){
            $partId = $result_arr['part_id']; // Assuming 'part_id' is a field in the jobs table.
            $this->PartsModel->where('id',$result_arr['part_id']);
            $partData = $this->PartsModel->first();
            if ($partData) {
                // Combine the data from the two tables and store it in the results array.
                $combinedResult = array_merge($result_arr, $partData);
                $combinedResults[] = $combinedResult;
            }
        }
      
        return $this->respond($combinedResults, 200);
    }
}