<?php
namespace App\Controllers;

class Frontend extends BaseController
{
    public function index()
    {
        return view('home');
    }

    // --- PELAPORAN ---
    public function lostFound()
    {
        return view('pelaporan/lost_found');
    }
    public function submitLostFound()
    {
        $db = \Config\Database::connect();
        $db->table('lost_found')->insert([
            'item_name' => $this->request->getPost('item_name'),
            'location_found' => $this->request->getPost('location_found'),
            'finder_name' => $this->request->getPost('finder_name'),
            'contact' => $this->request->getPost('contact'),
            'description' => $this->request->getPost('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Laporan Lost & Found berhasil disubmit!');
    }

    public function visitor()
    {
        return view('pelaporan/visitor');
    }
    public function submitVisitor()
    {
        $db = \Config\Database::connect();
        $db->table('visitors')->insert([
            'visitor_name' => $this->request->getPost('visitor_name'),
            'id_type' => $this->request->getPost('id_type'),
            'id_number' => $this->request->getPost('id_number'),
            'purpose' => $this->request->getPost('purpose'),
            'host_name' => $this->request->getPost('host_name'),
            'check_in' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Registrasi Visitor ID Pass berhasil!');
    }

    // --- PEMINJAMAN ---
    public function ruangan()
    {
        $db = \Config\Database::connect();
        $data['rooms'] = $db->table('rooms')->get()->getResultArray();
        return view('peminjaman/ruangan', $data);
    }
    public function submitRuangan()
    {
        $db = \Config\Database::connect();
        $db->table('room_bookings')->insert([
            'room_id' => $this->request->getPost('room_id'),
            'booker_name' => $this->request->getPost('booker_name'),
            'event_name' => $this->request->getPost('event_name'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Form Peminjaman Ruangan berhasil dikirim dan menunggu persetujuan!');
    }

    public function kendaraan()
    {
        $db = \Config\Database::connect();
        $data['vehicles'] = $db->table('vehicles')->get()->getResultArray();
        return view('peminjaman/kendaraan', $data);
    }
    public function submitKendaraan()
    {
        $db = \Config\Database::connect();
        $db->table('vehicle_bookings')->insert([
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'booker_name' => $this->request->getPost('booker_name'),
            'destination' => $this->request->getPost('destination'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Form Peminjaman Kendaraan berhasil dikirim dan menunggu persetujuan!');
    }

    // --- REQUEST ---
    public function maintenance()
    {
        return view('request/maintenance');
    }
    public function submitMaintenance()
    {
        $db = \Config\Database::connect();
        $db->table('maintenance_requests')->insert([
            'requester_name' => $this->request->getPost('requester_name'),
            'asset_name' => $this->request->getPost('asset_name'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Request Maintenance berhasil dikirim!');
    }

    public function supplies()
    {
        $db = \Config\Database::connect();
        $data['supplies'] = $db->table('supplies')->get()->getResultArray();
        return view('request/supplies', $data);
    }
    public function submitSupplies()
    {
        $db = \Config\Database::connect();
        $db->table('supply_requests')->insert([
            'supply_id' => $this->request->getPost('supply_id'),
            'requester_name' => $this->request->getPost('requester_name'),
            'quantity' => $this->request->getPost('quantity'),
            'reason' => $this->request->getPost('reason'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return redirect()->back()->with('message', 'Request Supplies/ATK berhasil dikirim!');
    }
}

