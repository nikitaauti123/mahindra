<?php

namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }
}
