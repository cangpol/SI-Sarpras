<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomModel;

class RoomsController extends BaseController
{
    public function index()
    {
        $model = new RoomModel();
        $data['rooms'] = $model->findAll();
        return view('admin/rooms/index', $data);
    }

    public function create()
    {
        return view('admin/rooms/create');
    }

    public function store()
    {
        $model = new RoomModel();
        $data = [
            'room_code' => $this->request->getPost('room_code'),
            'room_name' => $this->request->getPost('room_name'),
            'capacity'  => $this->request->getPost('capacity'),
            'status'    => $this->request->getPost('status') ?? 'available'
        ];
        
        $model->insert($data);
        return redirect()->to('/admin/rooms')->with('message', 'Ruangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new RoomModel();
        $data['room'] = $model->find($id);
        if (!$data['room']) {
            return redirect()->to('/admin/rooms')->with('error', 'Ruangan tidak ditemukan');
        }
        return view('admin/rooms/edit', $data);
    }

    public function update($id)
    {
        $model = new RoomModel();
        $data = [
            'room_code' => $this->request->getPost('room_code'),
            'room_name' => $this->request->getPost('room_name'),
            'capacity'  => $this->request->getPost('capacity'),
            'status'    => $this->request->getPost('status')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/rooms')->with('message', 'Ruangan berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new RoomModel();
        $model->delete($id);
        return redirect()->to('/admin/rooms')->with('message', 'Ruangan berhasil dihapus');
    }
}

