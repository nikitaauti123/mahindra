<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPartsTblColumn extends Migration
{
    public function up()
    {
        $fields = [
            'die_no' => ['type' => 'VARCHAR', 'constraint' => 100, 'after' => 'part_no', 'null' => true],
            'part_id' => ['type' => 'VARCHAR', 'constraint' => 100, 'after' => 'part_no', 'null' => true],
        ];

        $this->forge->addColumn('parts', $fields);
    }

    public function down()
    {
        //
    }
}
