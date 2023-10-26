<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJobhistory extends Migration
{
    public function up()
    {
        $fields = [
            'job_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'after'      => 'part_id', // Add it after 'part_id'
            ],
        ];

        $this->forge->addColumn('jobs_history', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('jobs_history', 'job_id');
    }
}
