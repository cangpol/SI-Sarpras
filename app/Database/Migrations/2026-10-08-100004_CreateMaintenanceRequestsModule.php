<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaintenanceRequestsModule extends Migration
{
    public function up()
    {
        // Table `maintenance_requests`
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ticket_code'   => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'user_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'location'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'asset_name'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'description'   => ['type' => 'TEXT'],
            'photo'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'priority'      => ['type' => 'ENUM', 'constraint' => ['low', 'medium', 'high'], 'default' => 'medium'],
            'technician_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'in_progress', 'completed', 'cancelled'], 'default' => 'pending'],
            'cost'          => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('technician_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('maintenance_requests');
    }

    public function down()
    {
        $this->forge->dropTable('maintenance_requests');
    }
}

