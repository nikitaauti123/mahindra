<?php
/**  
 * PermissionController file Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionController_Class
 * @package  PermissionController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Permission;

use App\Controllers\BaseController;
use App\Models\RolesModel;
/**  
 * PermissionController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category PermissionController_Class
 * @package  PermissionController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class PermissionController  extends BaseController
{
    /**
     * Method for list page permission.
     * 
     * @return text; 
     */
    public function list()
    {
      
        $data['request'] = $this->request;
        return view('permission/list', $data);
    }
    /**
     * Method for add page in the permission.
     * 
     * @return text; 
     */
    public function create()
    {
        $RolesModel = new RolesModel();
        $data['roles'] =$RolesModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('permission/add', $data);
    }
    /**
     * Method for add page in the permission.
     * 
     * @param $id used to edit page
     * 
     * @return text; 
     */
    public function edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('permission/edit', $data);
    }
    /**
     * Method for add page in the permission.
     * 
     * @return text; 
     */
    public function remove()
    {
        $data['request'] = $this->request;
        return view('permission/remove', $data);
    }
}
