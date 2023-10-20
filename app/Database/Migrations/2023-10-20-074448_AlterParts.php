<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParts extends Migration
{
    public function up()
    {
        $fields = [
            'die_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'after'      => 'part_no', // Add it after 'part_no'
            ],
            'part_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'after'          =>'die_no', 
                'unsigned'       => true
            ],
          
        ];

        $this->forge->addColumn('parts', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('parts', 'die_no');
    }
}
