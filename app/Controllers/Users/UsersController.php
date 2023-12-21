<?php
/**  
 * UsersController file Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersController_Class
 * @package  UsersController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\RolesModel;
/**  
 * UsersController Class Doc Comment
 * 
 * PHP version 7
 *
 * @category UsersController_Class
 * @package  UsersController_Class
 * @author   Author <author@domain.com>
 * @license  GPL License
 * @link     https://www.quicsolv.com/
 */
Class UsersController extends BaseController
{
    private $_rolesModel;
    /**
     * Constructor for the UsersController class.
     */
    function __construct()
    {
        $this->_rolesModel = new RolesModel();
        
    }
    /**
     *  Route - /
     * 
     *  Display login page for all users
     * 
     * @return view;
     */
    public function login() 
    {
        return view('users/login');
    }

    /**
     *  Route - logout
     * 
     *  Logout users
     * 
     * @return view 
     */
    public function logout() 
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     *  Route - admin/dashboard 
     *  
     *  Display dashboard page for admin users.
     * 
     * @return view;
     */
    public function dashboard()
    {
        return view('users/dashboard');
    }

    /**
     *  Route - admin/users/list
     *  
     *  Display list of users in the system
     * 
     * @return view
     */
    public function list() 
    {
        $data['request'] = $this->request;
        return view('users/list', $data);
    }
    /**
     * Method for handling edit page.
     * 
     * @param $id third url for edit page 
     * 
     * @return view; 
     */  
    public function edit($id)
    {
        $data['role'] = $this->_rolesModel->findAll(); // Access roles data
      
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('users/edit', $data);
    }
    /**
     * Method for handling edit page.
     * 
     * @return view; 
     */  
    public function create()
    {
        $data['role'] = $this->_rolesModel->findAll(); // Access roles data
      
        $data['request'] = $this->request;
        return view('users/add', $data);
    }
}