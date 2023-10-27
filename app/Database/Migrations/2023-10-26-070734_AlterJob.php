<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJob extends Migration
{
    public function up()
    {
        $fields = [
            'side' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'after'      => 'pins', // Add it after 'pins'
            ],
        ];

        $this->forge->addColumn('jobs', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('jobs', 'side');
    }
}
