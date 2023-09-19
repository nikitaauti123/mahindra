<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Parts extends Migration
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
            'part_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'part_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'model' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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
            'updated_by' => [
                'type'    => 'INT',
                'constraint'     => 11,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('parts');
    }

    public function down()
    {
        //
    }
}
