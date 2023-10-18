<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
class Apisides extends Migration
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
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'sides' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
      
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('apisides');
   
    }

    public function down()
    {
        $this->forge->dropDatabase('apisides');
    }
}
