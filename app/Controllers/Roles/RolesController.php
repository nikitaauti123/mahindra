<?php

namespace App\Controllers\Roles;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermissionModel;


class RolesController extends BaseController
{
    protected $permissionModel;
    function __construct()
    {
        $this->permissionModel= new PermissionModel();
        
    }

    public function List()
    {
      
        $data['request'] = $this->request;
        return view('roles/list', $data);
    }

    public function Create()
    {
        $RolesModel = new RolesModel();
        $data['roles'] =$RolesModel->where('is_active', '1')->findAll(); 
        $data['permission'] = $this->permissionModel->findAll(); // Access permission data
      
        $data['request'] = $this->request;
        return view('roles/add', $data);
    }
  
    public function Edit($id)
    {
        $data['permission'] = $this->permissionModel->findAll(); // Access permission data
      
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('roles/edit', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('roles/remove', $data);
    }
}
