<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Roles
        $roles = [
            ['role_name' => 'Super Admin'],
            ['role_name' => 'Admin Sarpras'],
            ['role_name' => 'Petugas Security'],
            ['role_name' => 'Dosen'],
            ['role_name' => 'Mahasiswa'],
            ['role_name' => 'Teknisi'],
        ];
        $this->db->table('roles')->insertBatch($roles);

        // 2. Seed Users
        $users = [
            [
                'role_id'       => 1, // Super Admin
                'name'          => 'Super Admin',
                'email'         => 'admin@example.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'role_id'       => 4, // Dosen
                'name'          => 'Dosen User',
                'email'         => 'dosen@example.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'role_id'       => 5, // Mahasiswa
                'name'          => 'Mahasiswa User',
                'email'         => 'mahasiswa@example.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'role_id'       => 3, // Petugas Security
                'name'          => 'Security User',
                'email'         => 'security@example.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // 3. Seed Rooms
        $rooms = [
            ['room_code' => 'R-EXC', 'room_name' => 'Excellence', 'capacity' => 50, 'status' => 'available'],
            ['room_code' => 'R-COM', 'room_name' => 'Compassion', 'capacity' => 40, 'status' => 'available'],
            ['room_code' => 'R-INT', 'room_name' => 'Integrity', 'capacity' => 40, 'status' => 'available'],
            ['room_code' => 'R-AUD', 'room_name' => 'Auditorium', 'capacity' => 200, 'status' => 'available'],
            ['room_code' => 'R-MFH', 'room_name' => 'Multi Function Hall', 'capacity' => 150, 'status' => 'available'],
        ];
        foreach ($rooms as &$room) {
            $room['created_at'] = date('Y-m-d H:i:s');
            $room['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('rooms')->insertBatch($rooms);
    }
}

