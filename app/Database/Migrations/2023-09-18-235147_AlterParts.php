<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterParts extends Migration
{
    public function up()
    {
        $fields = [
            'pins' => ['type' => 'TEXT', 'after' => 'model'],
        ];

        $this->forge->addColumn('parts', $fields);

    }

    public function down()
    {
        //
    }
}
