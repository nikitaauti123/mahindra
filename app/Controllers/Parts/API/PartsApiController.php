<?php
/**  
 * PartsApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsApiController_Class
 * @package  JobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */

namespace App\Controllers\Parts\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PartsModel;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Exception;
use DateTime;
/**  
 * PartsApiController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category JobsApiController_Class
 * @package  JobsApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
Class PartsApiController extends BaseController
{
    use ResponseTrait;
    private $_partsModel;
    /**
     * Constructor for the PartApiController class.
     */
    public function __construct()
    {
        $this->_partsModel = new PartsModel();
    }
    /**
     * Method for handling list in the  PartApiController.
     * 
     * @return text; 
     */
    public function list()
    {
        $result = $this->_partsModel->findAll();
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
     * Method for getting single part details PartApiController.
     * 
     * @param $id to get single part
     * 
     * @return text; 
     */
    public function getOne($id)
    {
        try {
            $result = $this->_partsModel->find($id);
            if (!empty($result)) {
                return $this->respond($result, 200);
            } 
            return $this->respond((object)[], 200);
        } catch(\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
        /**
         * Method for handling add operation.
         *  
         * @return text; 
         */
    public function add()
    {       
        try {
            helper(['form']);
            
            $rules = [
                'part_name'  => 'required|min_length[2]|max_length[100]',
                 'model'  => 'required|min_length[3]|max_length[100]',
                 ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }
            $data['part_name']  = $this->request->getVar('part_name');
            $data['part_no']    = $this->request->getVar('part_no');
            $data['model']      = $this->request->getVar('model');
            $data['die_no']      = $this->request->getVar('die_no');          
            $data['is_active']  = $isactive;
            $data['pins']      =  $this->request->getVar('selected_pins');
            $result['id'] = $this->_partsModel->insert($data, true);
            $result['msg'] = "Part added successfully!";
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    /**
     * Method for handling add operation.
     *  
     * @param $id part id for update records.
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
                 'model'  => 'required|min_length[3]|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {
               
                $isactive = 1;
            }

            $data['part_name'] = $this->request->getVar('part_name');
            $data['part_no']   = $this->request->getVar('part_no');
            $data['model']     = $this->request->getVar('model'); 
            $data['die_no']      = $this->request->getVar('die_no');          
            $data['is_active']  = $isactive;
            $data['pins']      =  $this->request->getVar('selected_pins');
            
            $result['is_updated'] = $this->_partsModel->update($id, $data);
            $result['msg'] = "Part updated successfully!";
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    /**
     * Method for delete operation.
     *  
     * @param $id part id for update records.
     *  
     * @return view; 
     */
    public function delete($id)
    {

        try {
            helper(['form']);

            if (!$id) {
                return $this->fail('Please provide valid id', 400, true);
            }

            $result['is_deleted'] = $this->_partsModel->delete($id);
            $result['msg'] = "Part deleted successfully!";
            return $this->respond($result, 200);

        } catch (\Exception $e){
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }    
    }
    /**
     * Method for update active operation.
     * 
     * @return view; 
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
            $result['msg'] =   lang('Parts.StatusUpdateMsg');
            $result['id'] = $this->_partsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling add right side tv page .
     * 
     * @return view; 
     */
    public  function getApiUrl()
    {   

        $side = $this->request->getVar('side');

        if ($side == 'right') {
            $envVariables = [
                'WEBSOCKET_URL' => $_ENV['WEBSOCKET_URL_RIGHT'],          
            ];
        } else {
            $envVariables = [
                'WEBSOCKET_URL' => $_ENV['WEBSOCKET_URL'],          
            ];
        }
        
        return $this->respond($envVariables, 200);      
    }
}