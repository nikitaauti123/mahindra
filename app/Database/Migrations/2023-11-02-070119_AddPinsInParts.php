<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPinsInParts extends Migration
{
    public function up()
    {
        $fields = [
            'pins' => [
                'type'       => 'text',
                'after'      => 'model',
            ],
        ];

        $this->forge->modifyColumn('parts', $fields);
    }

    public function down()
    {
        //
    }
}
