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

                $targetUrl = session()->get('redirect_after_login') ?: '/dashboard';
                session()->remove('redirect_after_login');

                return redirect()->to($targetUrl)->with('message', 'Selamat datang kembali, ' . ($user['name'] ?? 'User') . '!');
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

                $targetUrl = session()->get('redirect_after_login') ?: '/dashboard';
                session()->remove('redirect_after_login');

                return redirect()->to($targetUrl)->with('message', 'Login berhasil sebagai ' . $f['name'] . '!');
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

        // Data Lengkap untuk CRUD Admin
        $allLostFound       = [];
        $allVisitors        = [];
        $allRoomBookings    = [];
        $allVehicleBookings = [];
        $allMaintenance     = [];
        $allSupplyRequests  = [];
        $suppliesList       = [];
        $roomsList          = [];
        $vehiclesList       = [];

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

            // Master Ruangan & Kendaraan
            if ($db->tableExists('rooms')) {
                $roomsList = $db->table('rooms')->get()->getResultArray();
            }
            if (empty($roomsList)) {
                $roomsList = [
                    ['id' => 1, 'room_name' => 'Excellent Meeting Room', 'capacity' => 50],
                    ['id' => 2, 'room_name' => 'Compassion Meeting Room', 'capacity' => 40],
                    ['id' => 3, 'room_name' => 'Integrity Meeting Room', 'capacity' => 40],
                    ['id' => 4, 'room_name' => 'Auditorium', 'capacity' => 200],
                    ['id' => 5, 'room_name' => 'Multi Function Hall', 'capacity' => 150],
                ];
            }

            if ($db->tableExists('vehicles')) {
                $vehiclesList = $db->table('vehicles')->get()->getResultArray();
            }
            if (empty($vehiclesList)) {
                $vehiclesList = [
                    ['id' => 1, 'vehicle_name' => 'Toyota Avanza', 'plate_number' => 'B 1234 ABC'],
                    ['id' => 2, 'vehicle_name' => 'Toyota Innova', 'plate_number' => 'B 5678 DEF'],
                    ['id' => 3, 'vehicle_name' => 'Isuzu Elf', 'plate_number' => 'B 9101 GHI'],
                ];
            }

            // Data untuk Super Admin & Admin Sarpras
            if (in_array($role, ['super_admin', 'admin'])) {
                if ($db->tableExists('room_bookings')) {
                    $allRoomBookings = $db->table('room_bookings')
                        ->select('room_bookings.*, rooms.room_name, rooms.capacity')
                        ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
                        ->orderBy('room_bookings.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingRooms = array_slice($allRoomBookings, 0, 5);
                }

                if ($db->tableExists('vehicle_bookings')) {
                    $allVehicleBookings = $db->table('vehicle_bookings')
                        ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                        ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
                        ->orderBy('vehicle_bookings.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingVehicles = array_slice($allVehicleBookings, 0, 5);
                }

                if ($db->tableExists('maintenance_requests')) {
                    $allMaintenance = $db->table('maintenance_requests')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                    $pendingMaintenance = array_slice($allMaintenance, 0, 5);
                }

                if ($db->tableExists('supply_requests')) {
                    $allSupplyRequests = $db->table('supply_requests')
                        ->select('supply_requests.*, supplies.item_name, supplies.unit, supplies.stock')
                        ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left')
                        ->orderBy('supply_requests.id', 'DESC')
                        ->get()->getResultArray();
                    $pendingSupplies = array_slice($allSupplyRequests, 0, 5);
                }

                if ($db->tableExists('visitors')) {
                    $allVisitors = $db->table('visitors')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                    $recentVisitors = array_slice($allVisitors, 0, 5);
                }

                if ($db->tableExists('lost_found')) {
                    $allLostFound = $db->table('lost_found')
                        ->orderBy('id', 'DESC')
                        ->get()->getResultArray();
                    $recentLostFound = array_slice($allLostFound, 0, 5);
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
            'allLostFound'       => $allLostFound,
            'allVisitors'        => $allVisitors,
            'allRoomBookings'    => $allRoomBookings,
            'allVehicleBookings' => $allVehicleBookings,
            'allMaintenance'     => $allMaintenance,
            'allSupplyRequests'  => $allSupplyRequests,
            'roomsList'          => $roomsList,
            'vehiclesList'       => $vehiclesList,
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

    // =========================================================================
    // CRUD PELAPORAN: LOST & FOUND
    // =========================================================================
    public function createLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $reporterName   = trim((string) $this->request->getPost('reporter_name'));
        $reporterStatus = trim((string) $this->request->getPost('reporter_status'));
        $lostItem       = trim((string) $this->request->getPost('lost_item'));
        $contact        = trim((string) $this->request->getPost('contact'));
        $incidentDate   = (string) $this->request->getPost('incident_date');
        $incidentTime   = (string) $this->request->getPost('incident_time');
        $status         = (string) ($this->request->getPost('status') ?: 'reported');

        if (empty($reporterName) || empty($lostItem)) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Nama Pelapor dan Barang yang Hilang wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->insert([
                'reporter_name'   => $reporterName,
                'reporter_status' => $reporterStatus ?: 'Mahasiswa / Karyawan',
                'lost_item'       => $lostItem,
                'contact'         => $contact,
                'incident_date'   => $incidentDate ?: date('Y-m-d'),
                'incident_time'   => $incidentTime ?: date('H:i:s'),
                'status'          => in_array($status, ['reported', 'found', 'claimed']) ? $status : 'reported',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Laporan Lost & Found berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal menambahkan laporan: ' . $e->getMessage());
        }
    }

    public function updateLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id             = (int) $this->request->getPost('id');
        $reporterName   = trim((string) $this->request->getPost('reporter_name'));
        $reporterStatus = trim((string) $this->request->getPost('reporter_status'));
        $lostItem       = trim((string) $this->request->getPost('lost_item'));
        $contact        = trim((string) $this->request->getPost('contact'));
        $incidentDate   = (string) $this->request->getPost('incident_date');
        $incidentTime   = (string) $this->request->getPost('incident_time');
        $status         = (string) $this->request->getPost('status');

        if (empty($id) || empty($reporterName) || empty($lostItem)) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Data laporan tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->where('id', $id)->update([
                'reporter_name'   => $reporterName,
                'reporter_status' => $reporterStatus,
                'lost_item'       => $lostItem,
                'contact'         => $contact,
                'incident_date'   => $incidentDate,
                'incident_time'   => $incidentTime,
                'status'          => in_array($status, ['reported', 'found', 'claimed']) ? $status : 'reported',
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Laporan Lost & Found berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function deleteLostFound()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('lost_found')->where('id', $id)->delete();
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Data Lost & Found berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PELAPORAN: VISITOR (BUKU TAMU)
    // =========================================================================
    public function createVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $visitorName = trim((string) $this->request->getPost('visitor_name'));
        $institution = trim((string) $this->request->getPost('institution'));
        $contact     = trim((string) $this->request->getPost('contact'));
        $purpose     = trim((string) $this->request->getPost('purpose'));
        $hostName    = trim((string) $this->request->getPost('host_name'));
        $checkIn     = (string) ($this->request->getPost('check_in') ?: date('Y-m-d H:i:s'));
        $checkOut    = $this->request->getPost('check_out') ?: null;
        $status      = (string) ($this->request->getPost('status') ?: 'checked_in');

        if (empty($visitorName) || empty($institution)) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Nama Pengunjung dan Institusi/Instansi wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->insert([
                'visitor_name' => $visitorName,
                'institution'  => $institution,
                'contact'      => $contact,
                'purpose'      => $purpose,
                'host_name'    => $hostName,
                'check_in'     => $checkIn,
                'check_out'    => $checkOut,
                'status'       => in_array($status, ['checked_in', 'checked_out']) ? $status : 'checked_in',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Data kunjungan tamu berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal menambahkan tamu: ' . $e->getMessage());
        }
    }

    public function updateVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id          = (int) $this->request->getPost('id');
        $visitorName = trim((string) $this->request->getPost('visitor_name'));
        $institution = trim((string) $this->request->getPost('institution'));
        $contact     = trim((string) $this->request->getPost('contact'));
        $purpose     = trim((string) $this->request->getPost('purpose'));
        $hostName    = trim((string) $this->request->getPost('host_name'));
        $checkIn     = (string) $this->request->getPost('check_in');
        $checkOut    = $this->request->getPost('check_out') ?: null;
        $status      = (string) $this->request->getPost('status');

        if (empty($id) || empty($visitorName)) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Data tamu tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->where('id', $id)->update([
                'visitor_name' => $visitorName,
                'institution'  => $institution,
                'contact'      => $contact,
                'purpose'      => $purpose,
                'host_name'    => $hostName,
                'check_in'     => $checkIn,
                'check_out'    => $checkOut,
                'status'       => in_array($status, ['checked_in', 'checked_out']) ? $status : 'checked_in',
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Data tamu berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal memperbarui tamu: ' . $e->getMessage());
        }
    }

    public function deleteVisitor()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('visitors')->where('id', $id)->delete();
            return redirect()->to('/dashboard#pelaporan')->with('message', 'Data tamu berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#pelaporan')->with('error', 'Gagal menghapus tamu: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PEMINJAMAN: RUANGAN
    // =========================================================================
    public function createRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $roomId         = (int) $this->request->getPost('room_id');
        $bookingDate    = (string) $this->request->getPost('booking_date');
        $startTime      = (string) $this->request->getPost('start_time');
        $endTime        = (string) $this->request->getPost('end_time');
        $bookerName     = trim((string) $this->request->getPost('booker_name'));
        $department     = trim((string) $this->request->getPost('department'));
        $eventName      = trim((string) $this->request->getPost('event_name'));
        $setup          = trim((string) $this->request->getPost('setup'));
        $materialNeeded = trim((string) $this->request->getPost('material_needed'));
        $specialRequest = trim((string) $this->request->getPost('special_request'));
        $status         = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($roomId) || empty($bookingDate) || empty($bookerName) || empty($eventName)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Ruangan, Tanggal, Nama Peminjam, dan Nama Event wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('room_bookings')->insert([
                'room_id'         => $roomId,
                'booking_date'    => $bookingDate,
                'start_time'      => $startTime,
                'end_time'        => $endTime,
                'booker_name'     => $bookerName,
                'department'      => $department,
                'event_name'      => $eventName,
                'setup'           => $setup,
                'material_needed' => $materialNeeded,
                'special_request' => $specialRequest,
                'status'          => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Data Peminjaman Ruangan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menambahkan booking ruangan: ' . $e->getMessage());
        }
    }

    public function updateRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id             = (int) $this->request->getPost('id');
        $roomId         = (int) $this->request->getPost('room_id');
        $bookingDate    = (string) $this->request->getPost('booking_date');
        $startTime      = (string) $this->request->getPost('start_time');
        $endTime        = (string) $this->request->getPost('end_time');
        $bookerName     = trim((string) $this->request->getPost('booker_name'));
        $department     = trim((string) $this->request->getPost('department'));
        $eventName      = trim((string) $this->request->getPost('event_name'));
        $setup          = trim((string) $this->request->getPost('setup'));
        $materialNeeded = trim((string) $this->request->getPost('material_needed'));
        $specialRequest = trim((string) $this->request->getPost('special_request'));
        $status         = (string) $this->request->getPost('status');

        if (empty($id) || empty($roomId) || empty($bookerName)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Data booking ruangan tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('room_bookings')->where('id', $id)->update([
                'room_id'         => $roomId,
                'booking_date'    => $bookingDate,
                'start_time'      => $startTime,
                'end_time'        => $endTime,
                'booker_name'     => $bookerName,
                'department'      => $department,
                'event_name'      => $eventName,
                'setup'           => $setup,
                'material_needed' => $materialNeeded,
                'special_request' => $specialRequest,
                'status'          => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'updated_at'      => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Peminjaman ruangan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal memperbarui booking ruangan: ' . $e->getMessage());
        }
    }

    public function deleteRoomBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('room_bookings')->where('id', $id)->delete();
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Booking ruangan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD PEMINJAMAN: KENDARAAN
    // =========================================================================
    public function createVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $vehicleId   = (int) $this->request->getPost('vehicle_id');
        $bookingDate = (string) $this->request->getPost('booking_date');
        $bookingDay  = (string) ($this->request->getPost('booking_day') ?: date('l', strtotime($bookingDate)));
        $startTime   = (string) $this->request->getPost('start_time');
        $endTime     = (string) $this->request->getPost('end_time');
        $bookerName  = trim((string) $this->request->getPost('booker_name'));
        $department  = trim((string) $this->request->getPost('department'));
        $destination = trim((string) $this->request->getPost('destination'));
        $description = trim((string) $this->request->getPost('description'));
        $driverName  = trim((string) $this->request->getPost('driver_name'));
        $kmIn        = $this->request->getPost('km_in') !== '' ? (int) $this->request->getPost('km_in') : null;
        $kmOut       = $this->request->getPost('km_out') !== '' ? (int) $this->request->getPost('km_out') : null;
        $status      = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($vehicleId) || empty($bookingDate) || empty($bookerName) || empty($destination)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Kendaraan, Tanggal, Peminjam, dan Tujuan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('vehicle_bookings')->insert([
                'vehicle_id'   => $vehicleId,
                'booking_date' => $bookingDate,
                'booking_day'  => $bookingDay,
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'booker_name'  => $bookerName,
                'department'   => $department,
                'destination'  => $destination,
                'description'  => $description,
                'driver_name'  => $driverName,
                'km_in'        => $kmIn,
                'km_out'       => $kmOut,
                'status'       => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Data Peminjaman Kendaraan berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menambahkan booking kendaraan: ' . $e->getMessage());
        }
    }

    public function updateVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id          = (int) $this->request->getPost('id');
        $vehicleId   = (int) $this->request->getPost('vehicle_id');
        $bookingDate = (string) $this->request->getPost('booking_date');
        $bookingDay  = (string) ($this->request->getPost('booking_day') ?: date('l', strtotime($bookingDate)));
        $startTime   = (string) $this->request->getPost('start_time');
        $endTime     = (string) $this->request->getPost('end_time');
        $bookerName  = trim((string) $this->request->getPost('booker_name'));
        $department  = trim((string) $this->request->getPost('department'));
        $destination = trim((string) $this->request->getPost('destination'));
        $description = trim((string) $this->request->getPost('description'));
        $driverName  = trim((string) $this->request->getPost('driver_name'));
        $kmIn        = $this->request->getPost('km_in') !== '' ? (int) $this->request->getPost('km_in') : null;
        $kmOut       = $this->request->getPost('km_out') !== '' ? (int) $this->request->getPost('km_out') : null;
        $status      = (string) $this->request->getPost('status');

        if (empty($id) || empty($vehicleId) || empty($bookerName)) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Data booking kendaraan tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('vehicle_bookings')->where('id', $id)->update([
                'vehicle_id'   => $vehicleId,
                'booking_date' => $bookingDate,
                'booking_day'  => $bookingDay,
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'booker_name'  => $bookerName,
                'department'   => $department,
                'destination'  => $destination,
                'description'  => $description,
                'driver_name'  => $driverName,
                'km_in'        => $kmIn,
                'km_out'       => $kmOut,
                'status'       => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Peminjaman kendaraan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal memperbarui booking kendaraan: ' . $e->getMessage());
        }
    }

    public function deleteVehicleBooking()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('vehicle_bookings')->where('id', $id)->delete();
            return redirect()->to('/dashboard#peminjaman')->with('message', 'Booking kendaraan berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#peminjaman')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD REQUEST: MAINTENANCE
    // =========================================================================
    public function createMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $location      = trim((string) $this->request->getPost('location'));
        $facility      = trim((string) $this->request->getPost('facility'));
        $description   = trim((string) $this->request->getPost('description'));
        $status        = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($requesterName) || empty($location) || empty($description)) {
            return redirect()->to('/dashboard#request')->with('error', 'Nama Pemohon, Lokasi, dan Keterangan Kerusakan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('maintenance_requests')->insert([
                'requester_name' => $requesterName,
                'department'     => $department,
                'location'       => $location,
                'facility'       => $facility ?: 'Fasilitas Umum',
                'description'    => $description,
                'status'         => in_array($status, ['pending', 'in_progress', 'resolved']) ? $status : 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#request')->with('message', 'Data Request Maintenance berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal menambahkan request maintenance: ' . $e->getMessage());
        }
    }

    public function updateMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id            = (int) $this->request->getPost('id');
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $location      = trim((string) $this->request->getPost('location'));
        $facility      = trim((string) $this->request->getPost('facility'));
        $description   = trim((string) $this->request->getPost('description'));
        $status        = (string) $this->request->getPost('status');

        if (empty($id) || empty($requesterName) || empty($location)) {
            return redirect()->to('/dashboard#request')->with('error', 'Data maintenance tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('maintenance_requests')->where('id', $id)->update([
                'requester_name' => $requesterName,
                'department'     => $department,
                'location'       => $location,
                'facility'       => $facility,
                'description'    => $description,
                'status'         => in_array($status, ['pending', 'in_progress', 'resolved']) ? $status : 'pending',
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#request')->with('message', 'Request maintenance berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal memperbarui maintenance: ' . $e->getMessage());
        }
    }

    public function deleteMaintenance()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('maintenance_requests')->where('id', $id)->delete();
            return redirect()->to('/dashboard#request')->with('message', 'Request maintenance berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // CRUD REQUEST: SUPPLIES REQUEST
    // =========================================================================
    public function createSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $email         = trim((string) $this->request->getPost('email'));
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $dateRequested = (string) ($this->request->getPost('date_requested') ?: date('Y-m-d'));
        $dateNeeded    = (string) $this->request->getPost('date_needed');
        $supplyId      = (int) $this->request->getPost('supply_id');
        $quantity      = (int) ($this->request->getPost('quantity') ?: 1);
        $status        = (string) ($this->request->getPost('status') ?: 'pending');

        if (empty($requesterName) || empty($supplyId) || empty($dateNeeded)) {
            return redirect()->to('/dashboard#request')->with('error', 'Nama Pemohon, Barang, dan Tanggal Dibutuhkan wajib diisi.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supply_requests')->insert([
                'email'          => $email,
                'requester_name' => $requesterName,
                'department'     => $department,
                'date_requested' => $dateRequested,
                'date_needed'    => $dateNeeded,
                'supply_id'      => $supplyId,
                'quantity'       => $quantity,
                'status'         => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#request')->with('message', 'Permohonan Supplies berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal menambahkan permohonan supplies: ' . $e->getMessage());
        }
    }

    public function updateSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id            = (int) $this->request->getPost('id');
        $email         = trim((string) $this->request->getPost('email'));
        $requesterName = trim((string) $this->request->getPost('requester_name'));
        $department    = trim((string) $this->request->getPost('department'));
        $dateRequested = (string) $this->request->getPost('date_requested');
        $dateNeeded    = (string) $this->request->getPost('date_needed');
        $supplyId      = (int) $this->request->getPost('supply_id');
        $quantity      = (int) ($this->request->getPost('quantity') ?: 1);
        $status        = (string) $this->request->getPost('status');

        if (empty($id) || empty($requesterName) || empty($supplyId)) {
            return redirect()->to('/dashboard#request')->with('error', 'Data permohonan supplies tidak lengkap.');
        }

        try {
            $db = \Config\Database::connect();
            $db->table('supply_requests')->where('id', $id)->update([
                'email'          => $email,
                'requester_name' => $requesterName,
                'department'     => $department,
                'date_requested' => $dateRequested,
                'date_needed'    => $dateNeeded,
                'supply_id'      => $supplyId,
                'quantity'       => $quantity,
                'status'         => in_array($status, ['pending', 'approved', 'rejected']) ? $status : 'pending',
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);
            return redirect()->to('/dashboard#request')->with('message', 'Permohonan supplies berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal memperbarui permohonan supplies: ' . $e->getMessage());
        }
    }

    public function deleteSupplyRequest()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (!in_array(session()->get('role'), ['super_admin', 'admin'])) return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');

        $id = (int) $this->request->getPost('id');
        try {
            $db = \Config\Database::connect();
            $db->table('supply_requests')->where('id', $id)->delete();
            return redirect()->to('/dashboard#request')->with('message', 'Permohonan supplies berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->to('/dashboard#request')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
