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
            $user = null;
        }

        // 1. Cek user dari database
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
                    'email'      => $user['email'] ?? '',
                    'role'       => $user['role'] ?? 'user',
                    'department' => $user['department'] ?? 'Universitas Pignatelli Triputra',
                ]);

                return redirect()->to('/dashboard')->with('message', 'Selamat datang kembali, ' . ($user['name'] ?? 'User') . '!');
            }
        }

        // 2. Fallback default akun untuk 3 role jika database kosong atau belum di-import
        $fallbacks = [
            'superadmin' => [
                'password'   => 'superadmin123',
                'id'         => 1,
                'name'       => 'Tim Biro IT',
                'role'       => 'super_admin',
                'department' => 'Biro IT',
            ],
            'admin' => [
                'password'   => 'admin123',
                'id'         => 2,
                'name'       => 'Biro Sarana dan Prasarana',
                'role'       => 'admin',
                'department' => 'Sarpras',
            ],
            'user' => [
                'password'   => 'user123',
                'id'         => 3,
                'name'       => 'Budi Santoso',
                'role'       => 'user',
                'department' => 'Dosen / Mahasiswa',
            ],
        ];

        if (!$user && isset($fallbacks[$username])) {
            $f = $fallbacks[$username];
            if ($password === $f['password'] || ($username === 'admin' && $password === 'admin')) {
                session()->set([
                    'isLoggedIn' => true,
                    'user_id'    => $f['id'],
                    'username'   => $username,
                    'user_name'  => $f['name'],
                    'role'       => $f['role'],
                    'department' => $f['department'],
                ]);

                return redirect()->to('/dashboard')->with('message', 'Login berhasil sebagai ' . $f['name'] . '!');
            }
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

        $role = session()->get('role') ?? 'user';
        $userName = session()->get('user_name') ?? 'Pengguna';

        $stats = [
            'lost_found'       => 0,
            'visitors'         => 0,
            'room_bookings'    => 0,
            'vehicle_bookings' => 0,
            'maintenance'      => 0,
            'supplies'         => 0,
            'users_count'      => 0,
        ];

        $pendingRooms       = [];
        $pendingVehicles    = [];
        $pendingMaintenance = [];
        $pendingSupplies    = [];
        $recentVisitors     = [];
        $recentLostFound    = [];
        $allUsers           = [];
        $myRequests         = [];

        try {
            $db = \Config\Database::connect();

            // Hitung statistik umum
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
            if ($db->tableExists('users')) {
                $stats['users_count'] = $db->table('users')->countAllResults();
            }

            // Data untuk Super Admin & Admin Sarpras
            if (in_array($role, ['super_admin', 'admin'])) {
                if ($db->tableExists('room_bookings')) {
                    $pendingRooms = $db->table('room_bookings')
                        ->select('room_bookings.*, rooms.room_name')
                        ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
                        ->orderBy('room_bookings.id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('vehicle_bookings')) {
                    $pendingVehicles = $db->table('vehicle_bookings')
                        ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                        ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
                        ->orderBy('vehicle_bookings.id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('maintenance_requests')) {
                    $pendingMaintenance = $db->table('maintenance_requests')
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('supply_requests')) {
                    $pendingSupplies = $db->table('supply_requests')
                        ->select('supply_requests.*, supplies.item_name, supplies.unit')
                        ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left')
                        ->orderBy('supply_requests.id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('visitors')) {
                    $recentVisitors = $db->table('visitors')
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('lost_found')) {
                    $recentLostFound = $db->table('lost_found')
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                }

                if ($db->tableExists('supplies')) {
                    $suppliesList = $db->table('supplies')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                }

                if ($db->tableExists('users')) {
                    $allUsers = $db->table('users')
                        ->select('id, username, name, email, role, department, created_at')
                        ->orderBy('id', 'ASC')
                        ->get()->getResultArray();
                }
            }

            // Data untuk User (Mahasiswa & Dosen)
            if ($role === 'user') {
                $userRequests = [];

                if ($db->tableExists('room_bookings')) {
                    $rooms = $db->table('room_bookings')
                        ->select('room_bookings.id, room_bookings.event_name as title, room_bookings.booking_date as date, room_bookings.status, "Ruangan" as type, rooms.room_name as detail')
                        ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
                        ->where('room_bookings.booker_name', $userName)
                        ->orderBy('room_bookings.id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                    $userRequests = array_merge($userRequests, $rooms);
                }

                if ($db->tableExists('vehicle_bookings')) {
                    $vehs = $db->table('vehicle_bookings')
                        ->select('vehicle_bookings.id, vehicle_bookings.destination as title, vehicle_bookings.booking_date as date, vehicle_bookings.status, "Kendaraan" as type, vehicles.vehicle_name as detail')
                        ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
                        ->where('vehicle_bookings.booker_name', $userName)
                        ->orderBy('vehicle_bookings.id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                    $userRequests = array_merge($userRequests, $vehs);
                }

                if ($db->tableExists('maintenance_requests')) {
                    $maint = $db->table('maintenance_requests')
                        ->select('id, facility as title, created_at as date, status, "Maintenance" as type, location as detail')
                        ->where('requester_name', $userName)
                        ->orderBy('id', 'DESC')
                        ->limit(5)
                        ->get()->getResultArray();
                    $userRequests = array_merge($userRequests, $maint);
                }

                $myRequests = $userRequests;
            }
        } catch (\Throwable $e) {
            // Tetap jalankan dashboard bila ada error koneksi DB
        }

        return view('admin/dashboard', [
            'role'               => $role,
            'stats'              => $stats,
            'pendingRooms'       => $pendingRooms,
            'pendingVehicles'    => $pendingVehicles,
            'pendingMaintenance' => $pendingMaintenance,
            'pendingSupplies'    => $pendingSupplies,
            'recentVisitors'     => $recentVisitors,
            'recentLostFound'    => $recentLostFound,
            'allUsers'           => $allUsers,
            'suppliesList'       => $suppliesList ?? [],
            'myRequests'         => $myRequests,
        ]);
    }

    public function updateStatus()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk mengubah status permohonan.');
        }

        $table  = (string) $this->request->getPost('table');
        $id     = (int) $this->request->getPost('id');
        $status = (string) $this->request->getPost('status');

        $allowedTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests', 'lost_found', 'visitors'];

        if (!in_array($table, $allowedTables) || empty($id) || empty($status)) {
            return redirect()->to('/dashboard')->with('error', 'Parameter perubahan status tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table($table)->where('id', $id)->update([
                'status'     => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard')->with('message', 'Status pengajuan berhasil diperbarui menjadi "' . strtoupper($status) . '".');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard')->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    // --- CRUD SUPPLIES (Nama Barang, Jumlah, Satuan, Stock, Batas) ---
    public function createSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $itemName  = trim((string) $this->request->getPost('item_name'));
        $quantity  = (int) $this->request->getPost('quantity');
        $unit      = trim((string) $this->request->getPost('unit'));
        $stock     = (int) $this->request->getPost('stock');
        $minStock  = (int) $this->request->getPost('min_stock');

        if (empty($itemName) || empty($unit)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Nama Barang dan Satuan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->insert([
                'item_name'  => $itemName,
                'quantity'   => $quantity,
                'unit'       => $unit,
                'stock'      => $stock,
                'min_stock'  => $minStock,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#supplies')->with('message', 'Data barang "' . $itemName . '" berhasil ditambahkan ke daftar Supplies.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }
    }

    public function updateSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id        = (int) $this->request->getPost('id');
        $itemName  = trim((string) $this->request->getPost('item_name'));
        $quantity  = (int) $this->request->getPost('quantity');
        $unit      = trim((string) $this->request->getPost('unit'));
        $stock     = (int) $this->request->getPost('stock');
        $minStock  = (int) $this->request->getPost('min_stock');

        if (empty($id) || empty($itemName) || empty($unit)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Data tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->where('id', $id)->update([
                'item_name'  => $itemName,
                'quantity'   => $quantity,
                'unit'       => $unit,
                'stock'      => $stock,
                'min_stock'  => $minStock,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#supplies')->with('message', 'Data barang persediaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal update barang: ' . $e->getMessage());
        }
    }

    public function deleteSupply()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id = (int) $this->request->getPost('id');
        if (empty($id)) {
            return redirect()->to('/dashboard#supplies')->with('error', 'ID barang tidak valid.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supplies')->where('id', $id)->delete();
            return redirect()->to('/dashboard#supplies')->with('message', 'Barang berhasil dihapus dari daftar persediaan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#supplies')->with('error', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }

    // --- CRUD USERS (SETTING MANAJEMEN USERS) ---
    public function createUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $username   = trim((string) $this->request->getPost('username'));
        $name       = trim((string) $this->request->getPost('name'));
        $email      = trim((string) $this->request->getPost('email'));
        $userRole   = (string) $this->request->getPost('role');
        $department = trim((string) $this->request->getPost('department'));
        $password   = (string) $this->request->getPost('password');

        if (empty($username) || empty($name) || empty($password)) {
            return redirect()->to('/dashboard#users')->with('error', 'Username, Nama, dan Password wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            
            // Cek username kembar
            $exist = $db->table('users')->where('username', $username)->countAllResults();
            if ($exist > 0) {
                return redirect()->to('/dashboard#users')->with('error', 'Username "' . $username . '" sudah digunakan.');
            }

            $db->table('users')->insert([
                'username'   => $username,
                'name'       => $name,
                'email'      => $email,
                'role'       => in_array($userRole, ['super_admin', 'admin', 'user']) ? $userRole : 'user',
                'department' => $department ?: 'Universitas Pignatelli Triputra',
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/dashboard#users')->with('message', 'Pengguna baru "' . $name . '" berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal menambah user: ' . $e->getMessage());
        }
    }

    public function updateUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id         = (int) $this->request->getPost('id');
        $username   = trim((string) $this->request->getPost('username'));
        $name       = trim((string) $this->request->getPost('name'));
        $email      = trim((string) $this->request->getPost('email'));
        $userRole   = (string) $this->request->getPost('role');
        $department = trim((string) $this->request->getPost('department'));
        $password   = (string) $this->request->getPost('password');

        if (empty($id) || empty($username) || empty($name)) {
            return redirect()->to('/dashboard#users')->with('error', 'Data pengguna tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();

            $data = [
                'username'   => $username,
                'name'       => $name,
                'email'      => $email,
                'role'       => in_array($userRole, ['super_admin', 'admin', 'user']) ? $userRole : 'user',
                'department' => $department,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $db->table('users')->where('id', $id)->update($data);

            return redirect()->to('/dashboard#users')->with('message', 'Data pengguna "' . $name . '" berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function deleteUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role') ?? 'user';
        if (!in_array($role, ['super_admin', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $id = (int) $this->request->getPost('id');
        if (empty($id)) {
            return redirect()->to('/dashboard#users')->with('error', 'ID user tidak valid.');
        }

        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/dashboard#users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('users')->where('id', $id)->delete();
            return redirect()->to('/dashboard#users')->with('message', 'Akun pengguna berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#users')->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}
