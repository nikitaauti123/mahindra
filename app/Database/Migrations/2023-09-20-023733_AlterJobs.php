<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJobs extends Migration
{
    public function up()
    {
        $fields = [
            'start_time' => ['type' => 'TIMESTAMP', 'after' => 'pins'],
            'end_time' => ['type' => 'TIMESTAMP', 'after' => 'start_time'],
            'bed_no' => ['type' => 'VARCHAR', 'constraint' => 20, 'after' => 'end_time'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'after' => 'bed_no'],
        ];

        $this->forge->addColumn('jobs', $fields);
    }

    public function down()
    {
        /* $fields = [
            'start_time',
            'end_time',
            'bed_no',
            'status'
        ];
        $this->forge->dropColumn('jobs', $fields); */
    }
}
