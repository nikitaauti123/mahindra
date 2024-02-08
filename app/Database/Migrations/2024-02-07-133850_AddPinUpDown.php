<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPinUpDown extends Migration
{
    public function up()
    {
        $fields = [
            'pin_up_time' => [
                'type'    => 'TIMESTAMP',
                'default' => null,
                'after' => 'mail_send'
            ],
            'pin_down_time' => [
                'type'    => 'TIMESTAMP',
                'default' => null,
                'after' => 'pin_up_time'
            ],
        ];
        
        $this->forge->addColumn('job_actions', $fields);
    }

    public function down()
    {
        //
    }
}
