<?php

namespace App\Controllers\Parts;

use App\Controllers\BaseController;

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

    public function Remove()
    {
        $data['request'] = $this->request;
        return view('parts/remove', $data);
    }
}
