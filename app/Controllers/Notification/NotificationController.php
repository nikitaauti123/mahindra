<?php
/**  
 * NotificationController file Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationController_Class
 * @package  NotificationController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Notification;
use App\Models\NotificationModel;

use App\Controllers\BaseController;
/**  
 * NotificationController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category NotificationController_Class
 * @package  NotificationController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class NotificationController  extends BaseController
{
    private $_notificationModel;
    /**
     * Method for list page permission.
     * 
     * @return text; 
     */
    public function list()
    {
      
        $data['request'] = $this->request;
        return view('notification/list', $data);
    }
    public function notification(){
        $data['notification'] = $this->_notificationModel
        ->get()->getResult();
        return view('notification/notification',$data);
    }
    /**
     * Method for add page in the permission.
     * 
     * @return text; 
     */
   
   
}
