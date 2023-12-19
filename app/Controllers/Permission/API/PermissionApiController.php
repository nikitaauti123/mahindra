<?php
/**  
 * PermissionApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionApiController_Class
 * @package  PermissionApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Permission\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PermissionModel;
use Exception;
/**  
 * PermissionApiController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionApiController_Class
 * @package  PermissionApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class PermissionApiController extends BaseController
{
    use ResponseTrait;
    private $_permissionsModel;
    /**
     * Constructor for the PermissionApiController class.
     */
    public function __construct()
    {
        $this->_permissionsModel = new PermissionModel();
    }
    /**
     * Method for handling list in the permission.
     * 
     * @return text; 
     */
    public function list()
    {
        $result = $this->_permissionsModel->findAll();
        return $this->respond($result, 200);
    }
    /**
     * Method for handling list in the permission.
     * 
     * @param $id using id to get details of permission
     * 
     * @return text; 
     */
    public function getOne($id)
    {

        try {
            $result = $this->_permissionsModel->find($id);
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
     * Method for handling add operation in the permission.
     * 
     * @return text; 
     */
    public function add()
    {

        try {
            helper(['form']);

            $rules = [
                'permission_id'  => 'required|min_length[2]',

            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }

            $this->_permissionsModel->where('is_active', '1');
            $this->_permissionsModel->where('deleted_at IS NULL');
            $this->_permissionsModel->where(
                'permission_id', 
                $this->request->getVar('permission_id')
            );
            $res = $this->_permissionsModel->find();


            if (!empty($res)) {
                return $this->fail(lang('Permission.DuplicatePermission'));
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {

                $isactive = 1;
            }

            $data['permission_id']  = $this->request->getVar('permission_id');
            $data['description']  = $this->request->getVar('description');

            $data['is_active']  = $isactive;

            $result['id'] = $this->_permissionsModel->insert($data, true);
            $result['msg'] = lang('Permission.PermissionSuccessMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling add update in the permission.
     * 
     * @param $id id according update permission perform
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
                'permission_id'  => 'required|min_length[2]',

            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 400, true);
            }
            if ($id != '') {
                $this->_permissionsModel->where('id !=', $id);
            }
            $this->_permissionsModel->where('is_active', '1');
            $this->_permissionsModel->where('deleted_at IS NULL');
            $this->_permissionsModel->where(
                'permission_id', 
                $this->request->getVar('permission_id')
            );
            $res = $this->_permissionsModel->find();


            if (!empty($res)) {
                return $this->fail(lang('Permission.DuplicatePermission'));
            }
            $isactive = 0;
            if ($this->request->getVar('is_active') == 'on') {

                $isactive = 1;
            }

            $data['permission_id'] = $this->request->getVar('permission_id');
            $data['description']  = $this->request->getVar('description');

            $data['is_active'] = $isactive;
            $result['is_updated'] = $this->_permissionsModel->update($id, $data);
            $result['msg'] = lang('Permission.PermissionUpdateMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling delete in the permission.
     * 
     * @param $id id according delete permission perform
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

            $result['is_deleted'] = $this->_permissionsModel->delete($id);
            $result['msg'] =  lang('Roles.DeleteMsg');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
    /**
     * Method for handling add update is  active in the permission.
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
            $result['msg'] =  lang('Permission.StatusUpdateMsg');
            $result['id'] = $this->_permissionsModel->update($id, $data);
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
        }
    }
}
