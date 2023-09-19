<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;

Class UsersController extends BaseController
{
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
}