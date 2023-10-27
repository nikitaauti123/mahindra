<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RolePermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'permission_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ]
        ]);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE', 'fk_roles_tbl');
        $this->forge->addForeignKey('permission_id', 'permission', 'id', 'CASCADE', 'CASCADE', 'fk_permission_tbl');
        $this->forge->createTable('roles_permission');
    }

    public function down()
    {
        $this->forge->dropDatabase('roles_permission');
    }
}
