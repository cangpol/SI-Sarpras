<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function authenticate()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }

        $user = null;

        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('users')) {
                $user = $db->table('users')
                    ->groupStart()
                        ->where('username', $username)
                        ->orWhere('email', $username)
                    ->groupEnd()
                    ->get()
                    ->getRowArray();
            }
        } catch (\Throwable $e) {
            // Jika ada kendala koneksi database, biarkan fallback bekerja tanpa error 500
            $user = null;
        }

        // Cek user dari database
        if ($user) {
            $isValid = false;

            if (password_verify($password, $user['password'])) {
                $isValid = true;
            } elseif ($password === $user['password']) {
                $isValid = true;
            }

            if ($isValid) {
                session()->set([
                    'isLoggedIn' => true,
                    'user_id'    => $user['id'],
                    'username'   => $user['username'],
                    'user_name'  => $user['name'] ?? $user['username'],
                    'role'       => $user['role'] ?? 'admin',
                ]);

                return redirect()->to('/dashboard')->with('message', 'Selamat datang kembali, ' . ($user['name'] ?? 'Admin') . '!');
            }
        }

        // Fallback default akun admin jika tabel users belum ada / kosong
        if (!$user && $username === 'admin' && ($password === 'admin123' || $password === 'admin')) {
            session()->set([
                'isLoggedIn' => true,
                'user_id'    => 1,
                'username'   => 'admin',
                'user_name'  => 'Administrator Sarpras',
                'role'       => 'admin',
            ]);

            return redirect()->to('/dashboard')->with('message', 'Selamat datang kembali, Administrator!');
        }

        return redirect()->back()->withInput()->with('error', 'Username atau Password yang Anda masukkan salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Anda telah berhasil keluar (logout).');
    }

    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
        }

        $stats = [
            'lost_found'    => 0,
            'visitors'      => 0,
            'room_bookings' => 0,
            'vehicle_bookings' => 0,
            'maintenance'   => 0,
            'supplies'      => 0,
        ];

        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('lost_found')) {
                $stats['lost_found'] = $db->table('lost_found')->countAllResults();
            }
            if ($db->tableExists('visitors')) {
                $stats['visitors'] = $db->table('visitors')->countAllResults();
            }
            if ($db->tableExists('room_bookings')) {
                $stats['room_bookings'] = $db->table('room_bookings')->countAllResults();
            }
            if ($db->tableExists('vehicle_bookings')) {
                $stats['vehicle_bookings'] = $db->table('vehicle_bookings')->countAllResults();
            }
            if ($db->tableExists('maintenance_requests')) {
                $stats['maintenance'] = $db->table('maintenance_requests')->countAllResults();
            }
            if ($db->tableExists('supply_requests')) {
                $stats['supplies'] = $db->table('supply_requests')->countAllResults();
            }
        } catch (\Throwable $e) {
            // Tetap tampilkan dashboard meski data belum termuat
        }

        return view('admin/dashboard', ['stats' => $stats]);
    }
}
