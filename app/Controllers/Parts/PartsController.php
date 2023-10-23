<?php

namespace App\Controllers\Parts;

use App\Controllers\BaseController;
use App\Models\PartsModel;

class PartsController extends BaseController
{
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

    public function Edit($id)
    {
        $data['request'] = $this->request;
        $data['id'] = $id;
        return view('parts/edit', $data);
    }

    public function View($id)
    {
        $partsModel = new PartsModel();

        $data['request'] = $this->request;
        $data['id'] = $id;
        $result = $partsModel->find($id);
        $data['part_details'] = $result;
        return view('parts/view', $data);
    }

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('parts/remove', $data);
    }
}
