<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuppliesModule extends Migration
{
    public function up()
    {
        // Table `supplies`
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'item_code'  => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'item_name'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'category'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'stock'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'unit'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'min_stock'  => ['type' => 'INT', 'constraint' => 11, 'default' => 5],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('supplies');

        // Table `supply_requests`
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'request_code' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'user_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'approved_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('supply_requests');

        // Table `supply_request_items`
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'request_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'supply_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity'   => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('request_id', 'supply_requests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supply_id', 'supplies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('supply_request_items');
    }

    public function down()
    {
        $this->forge->dropTable('supply_request_items');
        $this->forge->dropTable('supply_requests');
        $this->forge->dropTable('supplies');
    }
}

