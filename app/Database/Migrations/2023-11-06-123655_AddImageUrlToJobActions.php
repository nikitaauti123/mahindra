<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageUrlToJobActions extends Migration
{
    public function up()
    {
        $fields = [
            'image_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255, // Adjust the constraint as needed
                'null' => true,
                'after' => 'end_time', // Specify 'after' to add the column after the 'side' column
            ],
        ];

        $this->forge->addColumn('job_actions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('job_actions', 'image_url');
    }
}
