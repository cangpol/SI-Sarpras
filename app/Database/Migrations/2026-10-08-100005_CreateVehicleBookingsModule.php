<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVehicleBookingsModule extends Migration
{
    public function up()
    {
        // Table `vehicles`
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'vehicle_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'plate_number' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'capacity'     => ['type' => 'INT', 'constraint' => 11],
            'status'       => ['type' => 'ENUM', 'constraint' => ['available', 'in_use', 'maintenance'], 'default' => 'available'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('vehicles');

        // Table `drivers`
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'driver_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['available', 'on_trip', 'leave'], 'default' => 'available'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('drivers');

        // Table `vehicle_bookings`
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'booking_code'   => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'vehicle_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'driver_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'destination'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'departure_time' => ['type' => 'DATETIME'],
            'return_time'    => ['type' => 'DATETIME', 'null' => true],
            'start_km'       => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'end_km'         => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected', 'completed', 'cancelled'], 'default' => 'pending'],
            'approved_by'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('vehicle_id', 'vehicles', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('driver_id', 'drivers', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('vehicle_bookings');
    }

    public function down()
    {
        $this->forge->dropTable('vehicle_bookings');
        $this->forge->dropTable('drivers');
        $this->forge->dropTable('vehicles');
    }
}

