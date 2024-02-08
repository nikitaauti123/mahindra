<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NextJobs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'die_no' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'side' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'is_started' => [
                'type' => 'CHAR',
                'constraint' => 1,
            ],
            'start_time' => [
                'type'    => 'TIMESTAMP',
                'default' => null,
            ],
            'end_time' => [
                'type'    => 'TIMESTAMP',
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('next_jobs', true);
    }

    public function down()
    {
        //
    }
}
