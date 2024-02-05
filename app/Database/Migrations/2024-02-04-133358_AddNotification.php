<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddNotification extends Migration
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
            'msg' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_date' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('notification', true);
    }

    public function down()
    {
        $this->forge->dropTable('notification', true);
    }
}
