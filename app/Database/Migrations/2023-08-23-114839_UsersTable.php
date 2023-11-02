<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UsersTable extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 14,
                'null'       => true,
            ],
            'profile_photo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'emp_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropDatabase('users');
    }
}
