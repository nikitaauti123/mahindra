<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Models\RolesModel;
Class UsersController extends BaseController
{
    private $rolesModel;
    function __construct()
    {
        $this->rolesModel = new RolesModel();
        
    }
    /**
     *  route - /
     * 
     *  Display login page for all users
     * 
     */
    public function Login() {
        return view('users/login');
    }

    /**
     *  route - logout
     * 
     *  Logout users
     * 
     */
    public function Logout() {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     *  route - admin/dashboard 
     *  
     *  Display dashboard page for admin users.
     * 
     *  
     */
    public function Dashboard() {
        return view('users/dashboard');
    }

    /**
     *  route - admin/users/list
     *  
     *  Display list of users in the system
     * 
     */
    public function List() {
        $data['request'] = $this->request;
        return view('users/list', $data);
    }
    public function Edit($id)
    {
        $data['role'] = $this->rolesModel->findAll(); // Access roles data
      
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('users/edit', $data);
    }
    public function Create()
    {
        $data['role'] = $this->rolesModel->findAll(); // Access roles data
      
        $data['request'] = $this->request;
        return view('users/add', $data);
    }
}