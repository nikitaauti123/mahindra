<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Permission extends Migration
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
            'permission_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'       => 0,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'       => true,
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
        $this->forge->createTable('permission', true);
    }

    public function down()
    {
        $this->forge->dropDatabase('permission');
    }
}
