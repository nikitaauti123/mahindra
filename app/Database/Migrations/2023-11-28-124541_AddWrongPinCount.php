<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWrongPinCount extends Migration
{
    public function up()
    {
        $fields = [
            'wrong_pins' => [
                'type' => 'INT',
                'constraint' => 11, 
                'null' => true,
                'after' => 'image_url'
            ],
            'correct_pins' => [
                'type' => 'INT',
                'constraint' => 11, 
                'null' => true,
                'after' => 'wrong_pins'
            ],
        ];
        
        $this->forge->addColumn('job_actions', $fields);
    }

    public function down()
    {
        //
    }
}
