<?php

namespace App\Controllers\Parts;

use Exception;
use App\Controllers\BaseController;
use App\Models\PartsModel;

class PartsController extends BaseController
{
   protected $PartModel;

    public function __construct()
    {
    $this->PartModel = new PartsModel();
    }
    public function List()
    {
        $data['request'] = $this->request;
        return view('parts/list', $data);
    }

    public function Create()
    {
        $data['request'] = $this->request;
        return view('parts/add', $data);
    }
    public function Import()
    {
        $data['request'] = $this->request;
        return view('parts/import', $data);
    }

    public function Edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
       
        return view('parts/edit', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('parts/remove', $data);
    }
    public function bulk_import_parts()
    {
        $data['request'] = $this->request;
        return view('parts/bulk_import_parts', $data);
    }
    public function export_part(){
        $data['request'] = $this->request;
        return view('parts/export_part', $data);
       
    }
    public function View($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        $this->PartModel->where('id',$id);
        $data['single'] = $this->PartModel->first();
        return view('parts/view', $data);
    }
}
