<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class JobsHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'part_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'pins' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'       => 0,
            ],
            'created_by' => [
                'type'    => 'INT',
                'constraint'     => 11,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jobs_history', true);
    }

    public function down()
    {
        //
    }
}
