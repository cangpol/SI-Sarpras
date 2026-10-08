<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSecurityModule extends Migration
{
    public function up()
    {
        // Table `visitors`
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'visitor_code' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'company'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'purpose'      => ['type' => 'TEXT', 'null' => true],
            'host_person'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'check_in'     => ['type' => 'DATETIME', 'null' => true],
            'check_out'    => ['type' => 'DATETIME', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['checked_in', 'checked_out'], 'default' => 'checked_in'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('visitors');

        // Table `lost_found`
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_name'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'category'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'location_found' => ['type' => 'VARCHAR', 'constraint' => 150],
            'photo'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['found', 'claimed'], 'default' => 'found'],
            'finder_name'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'claimed_by'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'claimed_at'     => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lost_found');
    }

    public function down()
    {
        $this->forge->dropTable('lost_found');
        $this->forge->dropTable('visitors');
    }
}

