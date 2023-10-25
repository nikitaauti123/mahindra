<?php

namespace App\Controllers\Permission;

use App\Controllers\BaseController;
use App\Models\RolesModel;

class PermissionController  extends BaseController
{
    public function List()
    {
      
        $data['request'] = $this->request;
        return view('permission/list', $data);
    }

    public function Create()
    {
        $RolesModel = new RolesModel();
        $data['roles'] =$RolesModel->where('is_active', '1')->findAll(); 
        $data['request'] = $this->request;
        return view('permission/add', $data);
    }
  
    public function Edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('permission/edit', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('permission/remove', $data);
    }
}
