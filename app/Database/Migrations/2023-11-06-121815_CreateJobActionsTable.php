<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;


class CreateJobActionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'part_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'side' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'start_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);

        // Add primary key
        $this->forge->addPrimaryKey('id');

        // Create the table
        $this->forge->createTable('job_actions', true);
    }

    public function down()
    {
        $this->forge->dropTable('job_actions', true);
    }
}
