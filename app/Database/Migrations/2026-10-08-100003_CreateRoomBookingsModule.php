<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoomBookingsModule extends Migration
{
    public function up()
    {
        // Table `rooms`
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'room_code'  => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'room_name'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'capacity'   => ['type' => 'INT', 'constraint' => 11],
            'location'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'facilities' => ['type' => 'TEXT', 'null' => true],
            'status'     => ['type' => 'ENUM', 'constraint' => ['available', 'maintenance'], 'default' => 'available'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rooms');

        // Table `room_bookings`
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'booking_code'    => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'user_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'room_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'event_name'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'start_time'      => ['type' => 'DATETIME'],
            'end_time'        => ['type' => 'DATETIME'],
            'total_attendees' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'notes'           => ['type' => 'TEXT', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected', 'cancelled'], 'default' => 'pending'],
            'approved_by'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('room_id', 'rooms', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('room_bookings');
    }

    public function down()
    {
        $this->forge->dropTable('room_bookings');
        $this->forge->dropTable('rooms');
    }
}

