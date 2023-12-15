<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexes extends Migration
{
    public function up()
    {
 
        $this->db->query('CREATE INDEX idx_parts_id ON parts (id)');
        $this->db->query('CREATE INDEX idx_parts_created_at ON parts (created_at)');       
        $this->db->query('CREATE INDEX idx_jobs_part_id ON jobs (part_id)');
        $this->db->query('CREATE INDEX idx_jobs_history_part_id ON jobs_history (part_id)');
        $this->db->query('CREATE INDEX idx_jobs_history_created_at ON jobs_history (created_at)');
         $this->db->query('CREATE INDEX idx_job_actions_end_time ON job_actions (end_time)');
        $this->db->query('CREATE INDEX idx_job_actions_side ON job_actions (side)');
        $this->db->query('CREATE INDEX idx_job_actions_start_time ON job_actions (start_time)');
        $this->db->query('CREATE INDEX idx_parts_part_name ON parts (part_name)');
        $this->db->query('CREATE INDEX idx_parts_part_no ON parts (part_no)');
        $this->db->query('CREATE INDEX idx_parts_model ON parts (model)');
        $this->db->query('CREATE INDEX idx_parts_die_no ON parts (die_no)');
        $this->db->query('CREATE INDEX idx_parts_is_active ON parts (is_active)');
        $this->db->query('CREATE INDEX idx_job_actions_id ON job_actions (id)');
        $this->db->query('CREATE INDEX idx_permission_is_active ON permission (is_active)');
        $this->db->query('CREATE INDEX idx_permission_deleted_at ON permission (deleted_at)');
        $this->db->query('CREATE INDEX idx_permission_permission_id ON permission (permission_id)');
        $this->db->query('CREATE INDEX idx_roles_is_active ON roles (is_active)');
        $this->db->query('CREATE INDEX idx_roles_deleted_at ON roles (deleted_at)');
        $this->db->query('CREATE INDEX idx_roles_name ON roles (name)');
       $this->db->query('CREATE INDEX idx_roles_permission_id ON roles_permission (id)');
        $this->db->query('CREATE INDEX idx_users_id ON users (id)');
        $this->db->query('CREATE INDEX idx_users_is_active ON users (is_active)');
        $this->db->query('CREATE INDEX idx_users_deleted_at ON users (deleted_at)');
        $this->db->query('CREATE INDEX idx_users_username ON users (username)');
        $this->db->query('CREATE INDEX idx_users_email ON users (email)');
        $this->db->query('CREATE INDEX idx_users_phone ON users (phone)');  
        $this->db->query('CREATE INDEX idx_users_roles_user_id ON users_roles (user_id)');
        $this->db->query('CREATE INDEX idx_roles_id ON roles (id)');       
       

        // ... Repeat similar steps for other tables

    }

    public function down()
    {
        $this->forge->dropKey('parts', 'idx_parts_id');
        $this->forge->dropKey('parts', 'idx_parts_created_at');
        $this->forge->dropKey('jobs', 'idx_jobs_part_id');
        $this->forge->dropKey('jobs_history', 'idx_jobs_history_part_id');
        $this->forge->dropKey('jobs_history', 'idx_jobs_history_created_at');
        $this->forge->dropKey('job_actions','idx_job_actions_end_time');
        $this->forge->dropKey('job_actions','idx_job_actions_side');
        $this->forge->dropKey('job_actions','idx_job_actions_start_time');
        $this->forge->dropKey('parts','idx_parts_part_name');
        $this->forge->dropKey('parts','idx_parts_part_no');
        $this->forge->dropKey('parts','idx_parts_model');
        $this->forge->dropKey('parts','idx_parts_die_no');   
        $this->forge->dropKey('parts','idx_parts_is_active');             
        $this->forge->dropKey('job_actions','idx_job_actions_id');
        $this->forge->dropKey('permission','idx_permission_is_active'); 
        $this->forge->dropKey('permission','idx_permission_deleted_at'); 
        $this->forge->dropKey('permission','idx_permission_permission_id');       
        $this->forge->dropKey('roles','idx_roles_is_active'); 
        $this->forge->dropKey('roles','idx_roles_deleted_at');         
        $this->forge->dropKey('roles','idx_roles_name'); 
        $this->forge->dropKey('roles_permission','idx_roles_permission_id');     
        $this->forge->dropKey('users','idx_users_id'); 
        $this->forge->dropKey('users','idx_users_is_active'); 
        $this->forge->dropKey('users','idx_users_deleted_at'); 
        $this->forge->dropKey('users','idx_users_username'); 
        $this->forge->dropKey('users','idx_users_email'); 
        $this->forge->dropKey('users','idx_users_phone'); 
        $this->forge->dropKey('users_roles','idx_users_roles_user_id');
        $this->forge->dropKey('roles','idx_roles_id'); 
        // ... Repeat similar steps for other tables
    }
}
