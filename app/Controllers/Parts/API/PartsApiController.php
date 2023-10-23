<?php

namespace App\Controllers\Parts\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PartsModel;
use Exception;

Class PartsApiController extends BaseController
{
    use ResponseTrait;
    private $partsModel;

    public function __construct()
    {
        $this->partsModel = new PartsModel();
    }

    public function list()
    {
        $result = $this->partsModel->findAll();
        return $this->respond($result, 200);
    }

    public function getOne($id)
    {
        try {
            $result = $this->partsModel->find($id);
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
                'die_no'  => 'required|min_length[2]|max_length[100]',
                'is_active'  => 'required'
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name']  = $this->request->getVar('part_name');
            $data['part_no']    = $this->request->getVar('part_no');
            $data['model']      = $this->request->getVar('model');
            $data['die_no']      = $this->request->getVar('die_no');
            $data['is_active']  = $this->request->getVar('is_active');
            $data['pins']      =  $this->request->getVar('selected_pins');
            
            $result['id'] = $this->partsModel->insert($data, true);
            $result['msg'] = "Part added successfully!";
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
                'die_no'  => 'required|min_length[2]|max_length[100]',
                'is_active'  => 'required'
            ];

            if(!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $data['part_name'] = $this->request->getVar('part_name');
            $data['part_no']   = $this->request->getVar('part_no');
            $data['model']     = $this->request->getVar('model');
            $data['die_no']      = $this->request->getVar('die_no');
            $data['is_active'] = $this->request->getVar('is_active');
            $data['pins']      =  $this->request->getVar('selected_pins');
            
            $result['is_updated'] = $this->partsModel->update($id, $data);
            $result['msg'] = "Part updated successfully!";
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

            $result['is_deleted'] = $this->partsModel->delete($id);
            $result['msg'] = "Part deleted successfully!";
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
}