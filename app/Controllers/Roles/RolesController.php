<?php
/**  
 * RolesController file Doc Comment
 * 
 * PHP version 7
 *
 * @category RolesController_Class
 * @package  RolesController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
namespace App\Controllers\Roles;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermissionModel;

/**  
 * RolesController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category RolesController_Class
 * @package  RolesController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
class RolesController extends BaseController
{
    protected $permissionModel;
    /**
     * Constructor for the RolesController class.
     */
    function __construct()
    {
        $this->permissionModel= new PermissionModel();
        
    }
    /**
     * Method for handling list page in the roles.
     * 
     * @return view; 
     */
    public function list()
    {
      
        $data['request'] = $this->request;
        return view('roles/list', $data);
    }
    /**
     * Method for handling create page in the roles.
     * 
     * @return view; 
     */
    public function create()
    {
        $RolesModel = new RolesModel();
        $data['roles'] =$RolesModel->where('is_active', '1')->findAll(); 
        $data['permission'] = $this->permissionModel->findAll(); 
      
        $data['request'] = $this->request;
        return view('roles/add', $data);
    }
    /**
     * Method for handling edit page.
     * 
     * @param $id is url paramter to edit page 
     * 
     * @return text; 
     */  
    public function edit($id)
    {
        $data['permission'] = $this->permissionModel->findAll();
      
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('roles/edit', $data);
    }
    /**
     * Method for handling remove in the role.
     * 
     * @return text; 
     */
    public function remove()
    {
        $data['request'] = $this->request;
        return view('roles/remove', $data);
    }
}
