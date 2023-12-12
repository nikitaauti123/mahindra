<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFlagJobAction extends Migration
{
    public function up()
    {
        $fields = [
            'mail_send' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 0,  // Set default value to 0
                'after' => 'correct_pins'
            ],
        ];

        $this->forge->addColumn('job_actions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('job_actions', 'mail_send');
    }
}
