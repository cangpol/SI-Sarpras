<?php
namespace App\Controllers;

class Frontend extends BaseController
{
    /**
     * Memastikan hanya civitas akademika (Mahasiswa dan Dosen) yang memiliki akun yang dapat mengisi form Peminjaman & Request
     */
    private function checkAcademicAuth()
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_after_login', current_url());
            return redirect()->to('/login')->with('error', 'Akses Terbatas: Formulir Peminjaman dan Request hanya dapat diakses dan diisi oleh civitas akademika (Mahasiswa & Dosen) yang telah login.');
        }

        $role = session()->get('role');
        if (!in_array($role, ['user', 'admin', 'super_admin'])) {
            return redirect()->to('/login')->with('error', 'Akun Anda tidak memiliki hak akses untuk mengisi formulir ini.');
        }

        // Pengecekan Akun Suspend
        $userId = session()->get('user_id');
        try {
            $db = \Config\Database::connect();
            if ($userId && $db->tableExists('users')) {
                $userRec = $db->table('users')->where('id', $userId)->get()->getRowArray();
                if ($userRec && !empty($userRec['is_suspended'])) {
                    $reason = !empty($userRec['suspend_reason']) ? ' (' . $userRec['suspend_reason'] . ')' : '';
                    return redirect()->to('/dashboard')->with('error', 'Akses Ditolak: Akun Anda sedang DITANGGUHKAN (SUSPEND) karena terindikasi spam/pelanggaran' . $reason . '. Anda tidak diizinkan membuat permohonan baru. Silakan hubungi Super Admin (Biro IT).');
                }
            }
        } catch (\Throwable $e) {}

        return null;
    }

    public function index()
    {
        return view('home');
    }

    // =========================================================================
    // PELAPORAN: TERBUKA UNTUK SEMUA ORANG (PUBLIK / TAMU / MAHASISWA / DOSEN)
    // =========================================================================
    public function lostFound()
    {
        $recentLostFound = [];
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('lost_found')) {
                $recentLostFound = $db->table('lost_found')->orderBy('id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        return view('pelaporan/lost_found', ['recentLostFound' => $recentLostFound]);
    }

    public function submitLostFound()
    {
        try {
            $db = \Config\Database::connect();
            
            $status = $this->request->getPost('reporter_status');
            if ($status === 'Others') {
                $status = $this->request->getPost('reporter_status_other');
            }

            $reporterName = trim((string) $this->request->getPost('reporter_name')) ?: (session()->get('user_name') ?? 'Pelapor');

            $db->table('lost_found')->insert([
                'reporter_name'   => $reporterName,
                'reporter_status' => $status,
                'lost_item'       => $this->request->getPost('lost_item'),
                'contact'         => $this->request->getPost('contact'),
                'incident_date'   => $this->request->getPost('incident_date'),
                'incident_time'   => $this->request->getPost('incident_time'),
                'status'          => 'reported',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Laporan Barang Hilang berhasil dikirim atas nama ' . $reporterName . '!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim laporan: ' . $e->getMessage());
        }
    }

    public function visitor()
    {
        $recentVisitors = [];
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('visitors')) {
                $recentVisitors = $db->table('visitors')->orderBy('id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        return view('pelaporan/visitor', ['recentVisitors' => $recentVisitors]);
    }

    public function submitVisitor()
    {
        try {
            $db = \Config\Database::connect();
            
            $purpose = $this->request->getPost('purpose');
            if ($purpose === 'Others') {
                $purpose = $this->request->getPost('purpose_other');
            }

            $visitorName = trim((string) $this->request->getPost('visitor_name')) ?: (session()->get('user_name') ?? 'Tamu');

            $db->table('visitors')->insert([
                'visitor_name' => $visitorName,
                'institution'  => $this->request->getPost('institution'),
                'contact'      => $this->request->getPost('contact'),
                'purpose'      => $purpose,
                'host_name'    => $this->request->getPost('host_name'),
                'check_in'     => date('Y-m-d H:i:s'),
                'status'       => 'checked_in',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Registrasi Visitor ID Pass berhasil disubmit atas nama ' . $visitorName . '!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal registrasi pengunjung: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // PEMINJAMAN: HANYA UNTUK AKUN MAHASISWA & DOSEN
    // =========================================================================
    public function ruangan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        $rooms = [];
        $mySubmissions = [];
        $userId = session()->get('user_id');
        $userName = session()->get('user_name');

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            if ($db->tableExists('rooms')) {
                $rooms = $db->table('rooms')->orderBy('id', 'ASC')->get()->getResultArray();
            }
            if ($db->tableExists('room_bookings')) {
                $q = $db->table('room_bookings')
                    ->select('room_bookings.*, rooms.room_name')
                    ->join('rooms', 'rooms.id = room_bookings.room_id', 'left');
                if ($userId && $db->fieldExists('user_id', 'room_bookings')) {
                    $q->groupStart()->where('room_bookings.user_id', $userId)->orWhere('room_bookings.booker_name', $userName)->groupEnd();
                } else {
                    $q->where('room_bookings.booker_name', $userName);
                }
                $mySubmissions = $q->orderBy('room_bookings.id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($rooms)) {
            $rooms = [
                ['id' => 1, 'room_name' => 'Excellent Meeting Room', 'capacity' => 50, 'location' => 'Gedung A Lantai 2', 'status' => 'active'],
                ['id' => 2, 'room_name' => 'Compassion Meeting Room', 'capacity' => 40, 'location' => 'Gedung A Lantai 2', 'status' => 'active'],
                ['id' => 3, 'room_name' => 'Integrity Meeting Room', 'capacity' => 40, 'location' => 'Gedung B Lantai 1', 'status' => 'active'],
                ['id' => 4, 'room_name' => 'Auditorium', 'capacity' => 200, 'location' => 'Gedung Utama Lantai 3', 'status' => 'active'],
                ['id' => 5, 'room_name' => 'Multi Function Hall', 'capacity' => 150, 'location' => 'Gedung C Lantai Dasar', 'status' => 'active'],
            ];
        }

        return view('peminjaman/ruangan', [
            'rooms'         => $rooms,
            'mySubmissions' => $mySubmissions,
        ]);
    }

    public function submitRuangan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            $userId = session()->get('user_id');
            $bookerName = trim((string) $this->request->getPost('booker_name')) ?: session()->get('user_name');
            $department = trim((string) $this->request->getPost('department')) ?: session()->get('department');
            $roomId      = (int) $this->request->getPost('room_id');
            $bookingDate = trim((string) $this->request->getPost('booking_date'));
            $startTime   = trim((string) $this->request->getPost('start_time'));
            $endTime     = trim((string) $this->request->getPost('end_time'));

            if (empty($roomId) || empty($bookingDate) || empty($startTime) || empty($endTime)) {
                return redirect()->back()->withInput()->with('error', 'Ruangan, tanggal peminjaman, jam mulai, dan jam selesai wajib diisi.');
            }

            if (strtotime($startTime) >= strtotime($endTime)) {
                return redirect()->back()->withInput()->with('error', 'Validasi Waktu Gagal: Jam selesai (' . $endTime . ') harus lebih besar / setelah jam mulai (' . $startTime . ').');
            }

            // Cek bentrok jadwal (Anti Double Booking)
            $conflict = $this->checkRoomConflict($db, $roomId, $bookingDate, $startTime, $endTime);
            if ($conflict) {
                $roomName   = esc($conflict['room_name'] ?: 'Ruangan #' . $roomId);
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confEvent  = esc($conflict['event_name']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->back()->withInput()->with('error', "Jadwal Bentrok! Ruangan '{$roomName}' sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk kegiatan '{$confEvent}' oleh {$confBooker}. Silakan pilih jam atau ruangan lain.");
            }

            $dataInsert = [
                'room_id'         => $roomId,
                'booking_date'    => $bookingDate,
                'start_time'      => $startTime,
                'end_time'        => $endTime,
                'booker_name'     => $bookerName,
                'department'      => $department,
                'event_name'      => $this->request->getPost('event_name'),
                'setup'           => $this->request->getPost('setup'),
                'material_needed' => $this->request->getPost('material_needed'),
                'special_request' => $this->request->getPost('special_request'),
                'status'          => 'pending',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ];
            if ($userId && $db->fieldExists('user_id', 'room_bookings')) {
                $dataInsert['user_id'] = $userId;
            }

            $db->table('room_bookings')->insert($dataInsert);
            return redirect()->back()->with('message', 'Form Peminjaman Ruangan berhasil dikirim atas nama ' . $bookerName . ' dan menunggu persetujuan!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan peminjaman ruangan: ' . $e->getMessage());
        }
    }

    public function kendaraan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        $vehicles = [];
        $mySubmissions = [];
        $userId = session()->get('user_id');
        $userName = session()->get('user_name');

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            if ($db->tableExists('vehicles')) {
                $vehicles = $db->table('vehicles')->orderBy('id', 'ASC')->get()->getResultArray();
            }
            if ($db->tableExists('vehicle_bookings')) {
                $q = $db->table('vehicle_bookings')
                    ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                    ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left');
                if ($userId && $db->fieldExists('user_id', 'vehicle_bookings')) {
                    $q->groupStart()->where('vehicle_bookings.user_id', $userId)->orWhere('vehicle_bookings.booker_name', $userName)->groupEnd();
                } else {
                    $q->where('vehicle_bookings.booker_name', $userName);
                }
                $mySubmissions = $q->orderBy('vehicle_bookings.id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($vehicles)) {
            $vehicles = [
                ['id' => 1, 'vehicle_name' => 'Toyota Avanza', 'plate_number' => 'B 1234 ABC', 'capacity' => 7, 'status' => 'available'],
                ['id' => 2, 'vehicle_name' => 'Toyota Innova Reborn', 'plate_number' => 'B 5678 DEF', 'capacity' => 8, 'status' => 'available'],
                ['id' => 3, 'vehicle_name' => 'Isuzu Elf Microbus', 'plate_number' => 'B 9101 GHI', 'capacity' => 16, 'status' => 'available'],
                ['id' => 4, 'vehicle_name' => 'Toyota Hiace Commuter', 'plate_number' => 'AD 8899 UP', 'capacity' => 14, 'status' => 'available'],
            ];
        }

        return view('peminjaman/kendaraan', [
            'vehicles'      => $vehicles,
            'mySubmissions' => $mySubmissions,
        ]);
    }

    public function submitKendaraan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            $userId = session()->get('user_id');
            $bookerName  = trim((string) $this->request->getPost('booker_name')) ?: session()->get('user_name');
            $department  = trim((string) $this->request->getPost('department')) ?: session()->get('department');
            $vehicleId   = (int) $this->request->getPost('vehicle_id');
            $bookingDate = trim((string) $this->request->getPost('booking_date'));
            $startTime   = trim((string) $this->request->getPost('start_time'));
            $endTime     = trim((string) $this->request->getPost('end_time'));

            if (empty($vehicleId) || empty($bookingDate) || empty($startTime) || empty($endTime)) {
                return redirect()->back()->withInput()->with('error', 'Kendaraan, tanggal, jam berangkat, dan jam kembali wajib diisi.');
            }

            if (strtotime($startTime) >= strtotime($endTime)) {
                return redirect()->back()->withInput()->with('error', 'Validasi Waktu Gagal: Jam kembali (' . $endTime . ') harus lebih besar / setelah jam berangkat (' . $startTime . ').');
            }

            // Cek bentrok jadwal (Anti Double Booking)
            $conflict = $this->checkVehicleConflict($db, $vehicleId, $bookingDate, $startTime, $endTime);
            if ($conflict) {
                $vehName    = esc(($conflict['vehicle_name'] ?: 'Kendaraan #' . $vehicleId) . ' (' . ($conflict['plate_number'] ?: '') . ')');
                $confStart  = esc(substr($conflict['start_time'], 0, 5));
                $confEnd    = esc(substr($conflict['end_time'], 0, 5));
                $confDest   = esc($conflict['destination']);
                $confBooker = esc($conflict['booker_name']);
                return redirect()->back()->withInput()->with('error', "Jadwal Bentrok! Kendaraan {$vehName} sudah dibooking pada tanggal {$bookingDate} pukul {$confStart} - {$confEnd} untuk tujuan '{$confDest}' oleh {$confBooker}. Silakan pilih jam atau armada lain.");
            }

            $dataInsert = [
                'vehicle_id'   => $vehicleId,
                'booking_date' => $bookingDate,
                'booking_day'  => $this->request->getPost('booking_day') ?: date('l', strtotime($bookingDate)),
                'start_time'   => $startTime,
                'end_time'     => $endTime,
                'booker_name'  => $bookerName,
                'department'   => $department,
                'destination'  => $this->request->getPost('destination'),
                'description'  => $this->request->getPost('description'),
                'driver_name'  => $this->request->getPost('driver_name'),
                'km_in'        => $this->request->getPost('km_in') ?: null,
                'km_out'       => $this->request->getPost('km_out') ?: null,
                'status'       => 'pending',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ];
            if ($userId && $db->fieldExists('user_id', 'vehicle_bookings')) {
                $dataInsert['user_id'] = $userId;
            }

            $db->table('vehicle_bookings')->insert($dataInsert);
            return redirect()->back()->with('message', 'Form Peminjaman Kendaraan berhasil dikirim atas nama ' . $bookerName . ' dan menunggu persetujuan!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan peminjaman kendaraan: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // REQUEST: HANYA UNTUK AKUN MAHASISWA & DOSEN
    // =========================================================================
    public function maintenance()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        $mySubmissions = [];
        $userId = session()->get('user_id');
        $userName = session()->get('user_name');

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            if ($db->tableExists('maintenance_requests')) {
                $q = $db->table('maintenance_requests');
                if ($userId && $db->fieldExists('user_id', 'maintenance_requests')) {
                    $q->groupStart()->where('user_id', $userId)->orWhere('requester_name', $userName)->groupEnd();
                } else {
                    $q->where('requester_name', $userName);
                }
                $mySubmissions = $q->orderBy('id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        return view('request/maintenance', [
            'mySubmissions' => $mySubmissions
        ]);
    }

    public function submitMaintenance()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            $userId = session()->get('user_id');
            $requesterName = trim((string) $this->request->getPost('requester_name')) ?: session()->get('user_name');
            $department = trim((string) $this->request->getPost('department')) ?: session()->get('department');
            
            $facility = $this->request->getPost('facility');
            if ($facility === 'Others') {
                $facility = $this->request->getPost('facility_other');
            }
            
            $dataInsert = [
                'requester_name' => $requesterName,
                'department'     => $department,
                'location'       => $this->request->getPost('location'),
                'facility'       => $facility,
                'description'    => $this->request->getPost('description'),
                'status'         => 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ];
            if ($userId && $db->fieldExists('user_id', 'maintenance_requests')) {
                $dataInsert['user_id'] = $userId;
            }

            $db->table('maintenance_requests')->insert($dataInsert);
            return redirect()->back()->with('message', 'Request Maintenance berhasil dikirim atas nama ' . $requesterName . '!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim request maintenance: ' . $e->getMessage());
        }
    }

    public function supplies()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        $supplies = [];
        $mySubmissions = [];
        $userId    = session()->get('user_id');
        $userName  = session()->get('user_name');
        $userEmail = session()->get('email');

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            if ($db->tableExists('supplies')) {
                $supplies = $db->table('supplies')->get()->getResultArray();
            }
            if ($db->tableExists('supply_requests')) {
                $q = $db->table('supply_requests')
                    ->select('supply_requests.*, supplies.item_name, supplies.unit')
                    ->join('supplies', 'supplies.id = supply_requests.supply_id', 'left');
                if ($userId && $db->fieldExists('user_id', 'supply_requests')) {
                    $q->groupStart()
                        ->where('supply_requests.user_id', $userId)
                        ->orWhere('supply_requests.requester_name', $userName)
                        ->orWhere('supply_requests.email', $userEmail)
                        ->groupEnd();
                } else {
                    $q->groupStart()
                        ->where('supply_requests.requester_name', $userName)
                        ->orWhere('supply_requests.email', $userEmail)
                        ->groupEnd();
                }
                $mySubmissions = $q->orderBy('supply_requests.id', 'DESC')->limit(10)->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($supplies)) {
            $supplies = [
                ['id' => 1, 'item_name' => 'Kertas A4', 'quantity' => 50, 'unit' => 'Rim', 'stock' => 50, 'min_stock' => 10],
                ['id' => 2, 'item_name' => 'Tinta Printer Hitam', 'quantity' => 20, 'unit' => 'Botol', 'stock' => 20, 'min_stock' => 5],
                ['id' => 3, 'item_name' => 'Spidol Papan Tulis', 'quantity' => 100, 'unit' => 'Pcs', 'stock' => 100, 'min_stock' => 20],
            ];
        }

        return view('request/supplies', [
            'supplies'      => $supplies,
            'mySubmissions' => $mySubmissions,
        ]);
    }

    public function submitSupplies()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);
            $userId        = session()->get('user_id');
            $email         = (string) ($this->request->getPost('email') ?: session()->get('email'));
            $requesterName = trim((string) ($this->request->getPost('requester_name') ?: session()->get('user_name')));
            $department    = trim((string) ($this->request->getPost('department') ?: session()->get('department')));
            $dateRequested = (string) ($this->request->getPost('date_requested') ?: date('Y-m-d'));
            $dateNeeded    = (string) $this->request->getPost('date_needed');

            $items = $this->request->getPost('items'); // Array of ['supply_id' => ..., 'quantity' => ...]
            $insertedCount = 0;

            if (is_array($items) && !empty($items)) {
                foreach ($items as $item) {
                    $supplyId = (int) ($item['supply_id'] ?? 0);
                    $quantity = (int) ($item['quantity'] ?? 1);

                    if ($supplyId > 0 && $quantity > 0) {
                        $row = [
                            'email'          => $email,
                            'requester_name' => $requesterName,
                            'department'     => $department,
                            'date_requested' => $dateRequested,
                            'date_needed'    => $dateNeeded,
                            'supply_id'      => $supplyId,
                            'quantity'       => $quantity,
                            'status'         => 'pending',
                            'created_at'     => date('Y-m-d H:i:s'),
                            'updated_at'     => date('Y-m-d H:i:s'),
                        ];
                        if ($userId && $db->fieldExists('user_id', 'supply_requests')) {
                            $row['user_id'] = $userId;
                        }

                        $db->table('supply_requests')->insert($row);
                        $insertedCount++;
                    }
                }
            } else {
                // Fallback untuk single supply_id jika ada
                $supplyId = (int) $this->request->getPost('supply_id');
                $quantity = (int) ($this->request->getPost('quantity') ?: 1);

                if ($supplyId > 0 && $quantity > 0) {
                    $row = [
                        'email'          => $email,
                        'requester_name' => $requesterName,
                        'department'     => $department,
                        'date_requested' => $dateRequested,
                        'date_needed'    => $dateNeeded,
                        'supply_id'      => $supplyId,
                        'quantity'       => $quantity,
                        'status'         => 'pending',
                        'created_at'     => date('Y-m-d H:i:s'),
                        'updated_at'     => date('Y-m-d H:i:s'),
                    ];
                    if ($userId && $db->fieldExists('user_id', 'supply_requests')) {
                        $row['user_id'] = $userId;
                    }

                    $db->table('supply_requests')->insert($row);
                    $insertedCount++;
                }
            }

            if ($insertedCount > 0) {
                return redirect()->back()->with('message', 'Berhasil mengajukan ' . $insertedCount . ' item barang Supplies (ATK) atas nama ' . $requesterName . '! Permohonan sedang menunggu persetujuan.');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan permohonan. Silakan pilih minimal 1 barang dengan jumlah yang valid.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint API JSON untuk Kalender Interaktif Peminjaman Ruangan & Kendaraan
     */
    public function calendarEvents()
    {
        $events = [];
        try {
            $db = \Config\Database::connect();
            $this->ensureUserIdColumns($db);

            // 1. Peminjaman Ruangan
            if ($db->tableExists('room_bookings')) {
                $rooms = $db->table('room_bookings')
                    ->select('room_bookings.*, rooms.room_name, rooms.capacity')
                    ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
                    ->whereIn('room_bookings.status', ['approved', 'pending'])
                    ->orderBy('room_bookings.booking_date', 'ASC')
                    ->orderBy('room_bookings.start_time', 'ASC')
                    ->get()
                    ->getResultArray();

                foreach ($rooms as $rb) {
                    $date = $rb['booking_date'];
                    $startTime = substr($rb['start_time'], 0, 5);
                    $endTime   = substr($rb['end_time'], 0, 5);
                    $startIso = $date . 'T' . (strlen($startTime) == 5 ? $startTime . ':00' : $startTime);
                    $endIso   = $date . 'T' . (strlen($endTime) == 5 ? $endTime . ':00' : $endTime);
                    $isApproved = ($rb['status'] === 'approved');
                    $roomName = $rb['room_name'] ?: 'Ruang #' . $rb['room_id'];

                    $events[] = [
                        'id'              => 'room_' . $rb['id'],
                        'title'           => '🏢 ' . $roomName . ' - ' . ($rb['event_name'] ?: 'Peminjaman'),
                        'start'           => $startIso,
                        'end'             => $endIso,
                        'backgroundColor' => $isApproved ? '#059669' : '#d97706',
                        'borderColor'     => $isApproved ? '#047857' : '#b45309',
                        'textColor'       => '#ffffff',
                        'extendedProps'   => [
                            'category'     => 'room',
                            'categoryName' => 'Peminjaman Ruangan',
                            'resourceName' => $roomName,
                            'eventTitle'   => $rb['event_name'],
                            'bookerName'   => $rb['booker_name'],
                            'department'   => $rb['department'],
                            'date'         => $date,
                            'time'         => $startTime . ' - ' . $endTime . ' WIB',
                            'setup'        => $rb['setup'] ?: 'Standar',
                            'material'     => $rb['material_needed'] ?: '-',
                            'special'      => $rb['special_request'] ?: '-',
                            'status'       => $rb['status'],
                            'statusLabel'  => $isApproved ? 'Disetujui (Approved)' : 'Menunggu Konfirmasi (Pending)',
                            'adminNote'    => $rb['admin_note'] ?? '',
                        ]
                    ];
                }
            }

            // 2. Peminjaman Kendaraan
            if ($db->tableExists('vehicle_bookings')) {
                $vehicles = $db->table('vehicle_bookings')
                    ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
                    ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
                    ->whereIn('vehicle_bookings.status', ['approved', 'pending'])
                    ->orderBy('vehicle_bookings.booking_date', 'ASC')
                    ->orderBy('vehicle_bookings.start_time', 'ASC')
                    ->get()
                    ->getResultArray();

                foreach ($vehicles as $vb) {
                    $date = $vb['booking_date'];
                    $startTime = substr($vb['start_time'], 0, 5);
                    $endTime   = substr($vb['end_time'], 0, 5);
                    $startIso = $date . 'T' . (strlen($startTime) == 5 ? $startTime . ':00' : $startTime);
                    $endIso   = $date . 'T' . (strlen($endTime) == 5 ? $endTime . ':00' : $endTime);
                    $isApproved = ($vb['status'] === 'approved');
                    $vehicleName = $vb['vehicle_name'] ?: 'Kendaraan #' . $vb['vehicle_id'];

                    $events[] = [
                        'id'              => 'vehicle_' . $vb['id'],
                        'title'           => '🚗 ' . $vehicleName . ' - ' . ($vb['destination'] ?: 'Dinas'),
                        'start'           => $startIso,
                        'end'             => $endIso,
                        'backgroundColor' => $isApproved ? '#0284c7' : '#ea580c',
                        'borderColor'     => $isApproved ? '#0369a1' : '#c2410c',
                        'textColor'       => '#ffffff',
                        'extendedProps'   => [
                            'category'     => 'vehicle',
                            'categoryName' => 'Peminjaman Kendaraan Dinas',
                            'resourceName' => $vehicleName . ($vb['plate_number'] ? ' (' . $vb['plate_number'] . ')' : ''),
                            'eventTitle'   => $vb['destination'],
                            'bookerName'   => $vb['booker_name'],
                            'department'   => $vb['department'],
                            'date'         => $date,
                            'time'         => $startTime . ' - ' . $endTime . ' WIB',
                            'driver'       => $vb['driver_name'] ?: 'Tidak ada supir',
                            'description'  => $vb['description'] ?: '-',
                            'status'       => $vb['status'],
                            'statusLabel'  => $isApproved ? 'Disetujui (Approved)' : 'Menunggu Konfirmasi (Pending)',
                            'adminNote'    => $vb['admin_note'] ?? '',
                        ]
                    ];
                }
            }
        } catch (\Throwable $e) {}

        return $this->response->setJSON($events);
    }

    /**
     * Memeriksa bentrok jadwal peminjaman ruangan pada tanggal dan rentang jam yang sama
     */
    private function checkRoomConflict($db, $roomId, $bookingDate, $startTime, $endTime, $excludeId = null)
    {
        $startTime = substr($startTime, 0, 5);
        $endTime   = substr($endTime, 0, 5);

        $builder = $db->table('room_bookings')
            ->select('room_bookings.*, rooms.room_name')
            ->join('rooms', 'rooms.id = room_bookings.room_id', 'left')
            ->where('room_bookings.room_id', $roomId)
            ->where('room_bookings.booking_date', $bookingDate)
            ->where('room_bookings.status !=', 'rejected')
            ->where('room_bookings.start_time <', $endTime)
            ->where('room_bookings.end_time >', $startTime);

        if ($excludeId) {
            $builder->where('room_bookings.id !=', $excludeId);
        }

        return $builder->get()->getRowArray();
    }

    /**
     * Memeriksa bentrok jadwal peminjaman kendaraan pada tanggal dan rentang jam yang sama
     */
    private function checkVehicleConflict($db, $vehicleId, $bookingDate, $startTime, $endTime, $excludeId = null)
    {
        $startTime = substr($startTime, 0, 5);
        $endTime   = substr($endTime, 0, 5);

        $builder = $db->table('vehicle_bookings')
            ->select('vehicle_bookings.*, vehicles.vehicle_name, vehicles.plate_number')
            ->join('vehicles', 'vehicles.id = vehicle_bookings.vehicle_id', 'left')
            ->where('vehicle_bookings.vehicle_id', $vehicleId)
            ->where('vehicle_bookings.booking_date', $bookingDate)
            ->where('vehicle_bookings.status !=', 'rejected')
            ->where('vehicle_bookings.start_time <', $endTime)
            ->where('vehicle_bookings.end_time >', $startTime);

        if ($excludeId) {
            $builder->where('vehicle_bookings.id !=', $excludeId);
        }

        return $builder->get()->getRowArray();
    }

    /**
     * Memastikan kolom user_id, admin_note, dan status tersedia di tabel-tabel permohonan
     */
    private function ensureUserIdColumns($db)
    {
        $requestTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests'];
        foreach ($requestTables as $tbl) {
            if ($db->tableExists($tbl)) {
                if (!$db->fieldExists('user_id', $tbl)) {
                    try {
                        $db->query("ALTER TABLE `{$tbl}` ADD COLUMN `user_id` INT(11) UNSIGNED NULL AFTER `id`");
                    } catch (\Throwable $e) {}
                }
            }
        }

        // Pastikan kolom admin_note tersedia di semua tabel permohonan & pelaporan
        $allStatusTables = ['room_bookings', 'vehicle_bookings', 'maintenance_requests', 'supply_requests', 'lost_found', 'visitors'];
        foreach ($allStatusTables as $tbl) {
            if ($db->tableExists($tbl)) {
                if (!$db->fieldExists('admin_note', $tbl)) {
                    try {
                        $db->query("ALTER TABLE `{$tbl}` ADD COLUMN `admin_note` TEXT NULL AFTER `status`");
                    } catch (\Throwable $e) {}
                }
            }
        }

        // Pastikan status di maintenance_requests mendukung approved dan rejected
        if ($db->tableExists('maintenance_requests')) {
            try {
                $db->query("ALTER TABLE `maintenance_requests` MODIFY COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
            } catch (\Throwable $e) {}
        }

        // Pastikan kolom phone, identity_number, is_suspended, suspend_reason tersedia di tabel users
        if ($db->tableExists('users')) {
            if (!$db->fieldExists('phone', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `phone` VARCHAR(50) NULL AFTER `department`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('identity_number', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `identity_number` VARCHAR(50) NULL AFTER `phone`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('is_suspended', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `is_suspended` TINYINT(1) NOT NULL DEFAULT 0 AFTER `identity_number`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('suspend_reason', 'users')) {
                try { $db->query("ALTER TABLE `users` ADD COLUMN `suspend_reason` TEXT NULL AFTER `is_suspended`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom location dan status tersedia di tabel rooms
        if ($db->tableExists('rooms')) {
            if (!$db->fieldExists('location', 'rooms')) {
                try { $db->query("ALTER TABLE `rooms` ADD COLUMN `location` VARCHAR(150) DEFAULT 'Gedung Utama' AFTER `capacity`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('status', 'rooms')) {
                try { $db->query("ALTER TABLE `rooms` ADD COLUMN `status` ENUM('active','maintenance') NOT NULL DEFAULT 'active' AFTER `location`"); } catch (\Throwable $e) {}
            }
        }

        // Pastikan kolom capacity dan status tersedia di tabel vehicles
        if ($db->tableExists('vehicles')) {
            if (!$db->fieldExists('capacity', 'vehicles')) {
                try { $db->query("ALTER TABLE `vehicles` ADD COLUMN `capacity` INT(11) NOT NULL DEFAULT 7 AFTER `plate_number`"); } catch (\Throwable $e) {}
            }
            if (!$db->fieldExists('status', 'vehicles')) {
                try { $db->query("ALTER TABLE `vehicles` ADD COLUMN `status` ENUM('available','maintenance') NOT NULL DEFAULT 'available' AFTER `capacity`"); } catch (\Throwable $e) {}
            }
        }
    }
}
