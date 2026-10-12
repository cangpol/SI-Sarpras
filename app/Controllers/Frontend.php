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
        return view('pelaporan/lost_found');
    }

    public function submitLostFound()
    {
        try {
            $db = \Config\Database::connect();
            
            $status = $this->request->getPost('reporter_status');
            if ($status === 'Others') {
                $status = $this->request->getPost('reporter_status_other');
            }

            $db->table('lost_found')->insert([
                'reporter_name'   => $this->request->getPost('reporter_name'),
                'reporter_status' => $status,
                'lost_item'       => $this->request->getPost('lost_item'),
                'contact'         => $this->request->getPost('contact'),
                'incident_date'   => $this->request->getPost('incident_date'),
                'incident_time'   => $this->request->getPost('incident_time'),
                'status'          => 'reported',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Laporan Barang Hilang berhasil dikirim!');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim laporan: ' . $e->getMessage());
        }
    }

    public function visitor()
    {
        return view('pelaporan/visitor');
    }

    public function submitVisitor()
    {
        try {
            $db = \Config\Database::connect();
            
            $purpose = $this->request->getPost('purpose');
            if ($purpose === 'Others') {
                $purpose = $this->request->getPost('purpose_other');
            }

            $db->table('visitors')->insert([
                'visitor_name' => $this->request->getPost('visitor_name'),
                'institution'  => $this->request->getPost('institution'),
                'contact'      => $this->request->getPost('contact'),
                'purpose'      => $purpose,
                'host_name'    => $this->request->getPost('host_name'),
                'check_in'     => date('Y-m-d H:i:s'),
                'status'       => 'checked_in',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Registrasi Visitor ID Pass berhasil disubmit!');
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
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('rooms')) {
                $rooms = $db->table('rooms')->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($rooms)) {
            $rooms = [
                ['id' => 1, 'room_name' => 'Excellent Meeting Room', 'capacity' => 50],
                ['id' => 2, 'room_name' => 'Compassion Meeting Room', 'capacity' => 40],
                ['id' => 3, 'room_name' => 'Integrity Meeting Room', 'capacity' => 40],
                ['id' => 4, 'room_name' => 'Auditorium', 'capacity' => 200],
                ['id' => 5, 'room_name' => 'Multi Function Hall', 'capacity' => 150],
            ];
        }

        return view('peminjaman/ruangan', ['rooms' => $rooms]);
    }

    public function submitRuangan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $db->table('room_bookings')->insert([
                'room_id'         => $this->request->getPost('room_id'),
                'booking_date'    => $this->request->getPost('booking_date'),
                'start_time'      => $this->request->getPost('start_time'),
                'end_time'        => $this->request->getPost('end_time'),
                'booker_name'     => $this->request->getPost('booker_name'),
                'department'      => $this->request->getPost('department'),
                'event_name'      => $this->request->getPost('event_name'),
                'setup'           => $this->request->getPost('setup'),
                'material_needed' => $this->request->getPost('material_needed'),
                'special_request' => $this->request->getPost('special_request'),
                'status'          => 'pending',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Form Peminjaman Ruangan berhasil dikirim dan menunggu persetujuan!');
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
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('vehicles')) {
                $vehicles = $db->table('vehicles')->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($vehicles)) {
            $vehicles = [
                ['id' => 1, 'vehicle_name' => 'Toyota Avanza', 'plate_number' => 'B 1234 ABC'],
                ['id' => 2, 'vehicle_name' => 'Toyota Innova', 'plate_number' => 'B 5678 DEF'],
                ['id' => 3, 'vehicle_name' => 'Isuzu Elf', 'plate_number' => 'B 9101 GHI'],
            ];
        }

        return view('peminjaman/kendaraan', ['vehicles' => $vehicles]);
    }

    public function submitKendaraan()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $db->table('vehicle_bookings')->insert([
                'vehicle_id'   => $this->request->getPost('vehicle_id'),
                'booking_date' => $this->request->getPost('booking_date'),
                'booking_day'  => $this->request->getPost('booking_day'),
                'start_time'   => $this->request->getPost('start_time'),
                'end_time'     => $this->request->getPost('end_time'),
                'booker_name'  => $this->request->getPost('booker_name'),
                'department'   => $this->request->getPost('department'),
                'destination'  => $this->request->getPost('destination'),
                'description'  => $this->request->getPost('description'),
                'driver_name'  => $this->request->getPost('driver_name'),
                'km_in'        => $this->request->getPost('km_in') ?: null,
                'km_out'       => $this->request->getPost('km_out') ?: null,
                'status'       => 'pending',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Form Peminjaman Kendaraan berhasil dikirim dan menunggu persetujuan!');
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

        return view('request/maintenance');
    }

    public function submitMaintenance()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            
            $facility = $this->request->getPost('facility');
            if ($facility === 'Others') {
                $facility = $this->request->getPost('facility_other');
            }
            
            $db->table('maintenance_requests')->insert([
                'requester_name' => $this->request->getPost('requester_name'),
                'department'     => $this->request->getPost('department'),
                'location'       => $this->request->getPost('location'),
                'facility'       => $facility,
                'description'    => $this->request->getPost('description'),
                'status'         => 'pending',
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('message', 'Request Maintenance berhasil dikirim!');
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
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('supplies')) {
                $supplies = $db->table('supplies')->get()->getResultArray();
            }
        } catch (\Throwable $e) {}

        if (empty($supplies)) {
            $supplies = [
                ['id' => 1, 'item_name' => 'Kertas A4', 'quantity' => 50, 'unit' => 'Rim', 'stock' => 50, 'min_stock' => 10],
                ['id' => 2, 'item_name' => 'Tinta Printer Hitam', 'quantity' => 20, 'unit' => 'Botol', 'stock' => 20, 'min_stock' => 5],
                ['id' => 3, 'item_name' => 'Spidol Papan Tulis', 'quantity' => 100, 'unit' => 'Pcs', 'stock' => 100, 'min_stock' => 20],
            ];
        }

        return view('request/supplies', ['supplies' => $supplies]);
    }

    public function submitSupplies()
    {
        if ($redir = $this->checkAcademicAuth()) {
            return $redir;
        }

        try {
            $db = \Config\Database::connect();
            $email         = (string) $this->request->getPost('email');
            $requesterName = (string) $this->request->getPost('requester_name');
            $department    = (string) $this->request->getPost('department');
            $dateRequested = (string) ($this->request->getPost('date_requested') ?: date('Y-m-d'));
            $dateNeeded    = (string) $this->request->getPost('date_needed');

            $items = $this->request->getPost('items'); // Array of ['supply_id' => ..., 'quantity' => ...]
            $insertedCount = 0;

            if (is_array($items) && !empty($items)) {
                foreach ($items as $item) {
                    $supplyId = (int) ($item['supply_id'] ?? 0);
                    $quantity = (int) ($item['quantity'] ?? 1);

                    if ($supplyId > 0 && $quantity > 0) {
                        $db->table('supply_requests')->insert([
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
                        ]);
                        $insertedCount++;
                    }
                }
            } else {
                // Fallback untuk single supply_id jika ada
                $supplyId = (int) $this->request->getPost('supply_id');
                $quantity = (int) ($this->request->getPost('quantity') ?: 1);

                if ($supplyId > 0 && $quantity > 0) {
                    $db->table('supply_requests')->insert([
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
                    ]);
                    $insertedCount++;
                }
            }

            if ($insertedCount > 0) {
                return redirect()->back()->with('message', 'Berhasil mengajukan ' . $insertedCount . ' item barang Supplies (ATK)! Permohonan sedang menunggu persetujuan.');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan permohonan. Silakan pilih minimal 1 barang dengan jumlah yang valid.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses permohonan: ' . $e->getMessage());
        }
    }
}
