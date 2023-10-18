<?php

namespace App\Controllers\Parts\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ApiPartsModel;
use App\Models\ApiSidesModel;
use App\Models\PartsModel;

use Exception;

Class ApiPartsApiController extends BaseController
{
    use ResponseTrait;
    private $ApiPartsModel;
    private $ApiSidesModel;
    private $PartsModel;

    public function __construct()
    {
        $this->ApiPartsModel = new ApiPartsModel();
        $this->ApiSidesModel = new ApiSidesModel();
        $this->PartsModel = new PartsModel();
    }
    

    public function list()
    {
        $result = $this->ApiPartsModel->findAll();
        return $this->respond($result, 200);
    }

    public function getOne($id)
    {
        try {
            $result = $this->ApiPartsModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            }
            return $this->respond([], 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }

    public function add(){

        try {
            helper(['form']);

            $part_id = $this->request->getVar('part_id');
if(!empty($part_id)){
            
            
            $pins = $this->request->getVar('pins');
            $part_ids = $this->request->getVar('part_id');
            $side = $this->request->getVar('side');

            $pins_json = json_encode($pins);

            $data = [
                'part_id' => $part_id,
                'pins' => $pins_json
            ];
            $data1 = [
                'part_id' => $part_ids,
                'sides' => $side
            ];
            $result['id'] = $this->ApiPartsModel->insert($data, true);

            $result['side_id'] = $this->ApiSidesModel->insert($data1, true);
            $result['msg'] = "Api Part added successfully!";
            return $this->respond($result, 200);
        }else{
           // return $this->fail"($this->validator->getErrors(), 400, true);
           // throw new Exception("");
            $result['msg'] = "Api parts don't have data";
            return $this->respond($result, 200);
          
        }
        } catch (\Exception $e) {
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
                'part_name'  => 'required|min_length[2]|max_length[10]',
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
    public function get_api_data(){
        $result = $this->ApiPartsModel
        ->orderBy('id', 'DESC')
        ->limit(1) // Set the limit to 1 to fetch only one row
        ->get()
        ->getRow();
      
       $model = $this->PartsModel
       ->where('part_no', $result->part_id) // Order the results by 'id' in descending order (assuming 'id' is the primary key)
       ->first(); 
        if ($result) {
            // Access the 'pins' property of the result object and decode it from JSON
            $pins = json_decode($result->pins, true);
        
            if (is_array($pins)) {
                // Separate keys and values into comma-separated strings
                $keys = implode(',', array_keys($pins));
                $values = implode(',', $pins);
        
                // Create an associative array to store the formatted data
                $formattedData = [
                    'keys' => $keys,
                    'values' => $values,
                ];
        
                if($model){
                    $combinedData = [
                        'result' => $result,
                        'formattedData' => $formattedData,
                        'model'=>$model 
                    ];
                }else{
                    $combinedData = [
                        'result' => $result,
                        'formattedData' => $formattedData,
                        'model'=>'' 
                    ];  
                }
        
                return $this->respond($combinedData, 200);
            }
        }
        return $this->respond(['error' => 'No data available'], 404);
    }
}