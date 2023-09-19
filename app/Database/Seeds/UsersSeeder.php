<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UsersModel;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'riyaz',
            'password'    => 'quicsolv@123*',
            'is_active' => 1
        ];

        $userModel = new UsersModel();
        $userModel->insert($data);
    }
}
