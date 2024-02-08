<?php
/**  
 * NotificationApiController file Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationApiController_Class
 * @package  NotificationApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Notification\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\NotificationModel;
use Exception;
/**  
 * NotificationApiController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationApiController_Class
 * @package  NotificationApiController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class NotificationApiController extends BaseController
{
    use ResponseTrait;
    private $_notificationModel;
    /**
     * Constructor for the NotificationApiController class.
     */
    public function __construct()
    {
        $this->_notificationModel = new NotificationModel();
    }
    /**
     * Method for handling list in the notification.
     * 
     * @return text; 
     */
    public function list()
    {
        if ($this->request->getVar('from_date')) {
            if ($this->request->getVar('to_date')) {
                $from_date = $this->request->getVar('from_date');
                $f_date = $this->_changeDateFormat($from_date) . " 00:00:00";
                $to_date = $this->request->getVar('to_date');
                $t_date = $this->_changeDateFormat(($to_date)) . " 23:59:59";
                $this->_notificationModel->where(
                    "created_date >= '" . $f_date . "'",
                    null,
                    false
                );
                $this->_notificationModel->where(
                    "created_date <= '" . $t_date . "'", 
                    null, 
                    false
                );
            }
        }
        
        $result = $this->_notificationModel
        ->get()->getResult();
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
            $result = $this->_notificationModel->find($id);
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
     * Method for update notification status .
     *  
     * @return boolean  return update status result notification ;
     */

    public function updateNotification(){
        $id=$this->request->getVar('id');
        $data['status'] = "viewed";
          try {
             $this->_notificationModel->update($id, $data);
            $result['msg'] = lang('Notification.NotificationSuccess');
            return $this->respond($result, 200);
        } catch (\Exception $e) {
            $result['msg'] =  $e->getMessage();
            return $this->fail($result, 400, true);
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
     * Method for handling add operation in the permission.
     * 
     * @return text; 
     */
    // public function add()
    // {

    //     try {
    //         helper(['form']);

    //         $rules = [
    //             'permission_id'  => 'required|min_length[2]',

    //         ];

    //         if (!$this->validate($rules)) {
    //             return $this->fail($this->validator->getErrors(), 400, true);
    //         }

    //         $this->_permissionsModel->where('is_active', '1');
    //         $this->_permissionsModel->where('deleted_at IS NULL');
    //         $this->_permissionsModel->where(
    //             'permission_id', 
    //             $this->request->getVar('permission_id')
    //         );
    //         $res = $this->_permissionsModel->find();


    //         if (!empty($res)) {
    //             return $this->fail(lang('Permission.DuplicatePermission'));
    //         }
    //         $isactive = 0;
    //         if ($this->request->getVar('is_active') == 'on') {

    //             $isactive = 1;
    //         }

    //         $data['permission_id']  = $this->request->getVar('permission_id');
    //         $data['description']  = $this->request->getVar('description');

    //         $data['is_active']  = $isactive;

    //         $result['id'] = $this->_permissionsModel->insert($data, true);
    //         $result['msg'] = lang('Permission.PermissionSuccessMsg');
    //         return $this->respond($result, 200);
    //     } catch (\Exception $e) {
    //         $result['msg'] =  $e->getMessage();
    //         return $this->fail($result, 400, true);
    //     }
    // }
    /**
     * Method for handling add update in the permission.
     * 
     * @param $id id according update permission perform
     * 
     * @return text; 
     */
    // public function update($id)
    // {
    //     try {
    //         helper(['form']);

    //         if (!$id) {
    //             return $this->fail('Please provide valid id', 400, true);
    //         }

    //         $rules = [
    //             'permission_id'  => 'required|min_length[2]',

    //         ];

    //         if (!$this->validate($rules)) {
    //             return $this->fail($this->validator->getErrors(), 400, true);
    //         }
    //         if ($id != '') {
    //             $this->_permissionsModel->where('id !=', $id);
    //         }
    //         $this->_permissionsModel->where('is_active', '1');
    //         $this->_permissionsModel->where('deleted_at IS NULL');
    //         $this->_permissionsModel->where(
    //             'permission_id', 
    //             $this->request->getVar('permission_id')
    //         );
    //         $res = $this->_permissionsModel->find();


    //         if (!empty($res)) {
    //             return $this->fail(lang('Permission.DuplicatePermission'));
    //         }
    //         $isactive = 0;
    //         if ($this->request->getVar('is_active') == 'on') {

    //             $isactive = 1;
    //         }

    //         $data['permission_id'] = $this->request->getVar('permission_id');
    //         $data['description']  = $this->request->getVar('description');

    //         $data['is_active'] = $isactive;
    //         $result['is_updated'] = $this->_permissionsModel->update($id, $data);
    //         $result['msg'] = lang('Permission.PermissionUpdateMsg');
    //         return $this->respond($result, 200);
    //     } catch (\Exception $e) {
    //         $result['msg'] =  $e->getMessage();
    //         return $this->fail($result, 400, true);
    //     }
    // }
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
}
