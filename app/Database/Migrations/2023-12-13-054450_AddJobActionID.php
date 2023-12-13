<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJobActionID extends Migration
{
    public function up()
    {
        $fields = [
            'job_action_id' => [
                'type' => 'int',
                'constraint' => 11,
                'null' => true,
                'after' => 'part_id'
            ],
        ];

        $this->forge->addColumn('jobs', $fields);
    }

    public function down()
    {
        //
    }
}
