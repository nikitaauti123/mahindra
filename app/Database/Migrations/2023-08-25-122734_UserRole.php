<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'role_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ]
        ]);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_users_tbl');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE', 'fk_roles_tbl');
        $this->forge->createTable('users_roles');
    }

    public function down()
    {
        $this->forge->dropDatabase('users_roles');
    }
}
