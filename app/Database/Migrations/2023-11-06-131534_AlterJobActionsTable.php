<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJobActionsTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('job_actions', [
            'end_time' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => NULL,
            ],
            'updated_by' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'default' => NULL,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('job_actions', [
            'end_time' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'updated_by' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }
}
