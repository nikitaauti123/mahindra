<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JobsDropBedno extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('jobs', 'status');
        $this->forge->dropColumn('jobs', 'bed_no');
    }

    public function down()
    {
        $fields = [
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'after' => 'end_time'],
            'bed_no' => ['type' => 'VARCHAR', 'constraint' => 20, 'after' => 'status'],
        ];

        $this->forge->addColumn('jobs', $fields);
    }
}
