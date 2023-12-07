<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDetailPins extends Migration
{
    public function up()
    {
        $fields = [
            'detail_pins' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after' => 'correct_pins'
            ],
        ];

        $this->forge->addColumn('job_actions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('job_actions', 'detail_pins');
    }
}
