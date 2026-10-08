<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VehicleModel;

class VehiclesController extends BaseController
{
    public function index()
    {
        $model = new VehicleModel();
        $data['vehicles'] = $model->findAll();
        return view('admin/vehicles/index', $data);
    }

    public function create()
    {
        return view('admin/vehicles/create');
    }

    public function store()
    {
        $model = new VehicleModel();
        $data = [
            'license_plate' => $this->request->getPost('license_plate'),
            'type'          => $this->request->getPost('type'),
            'capacity'      => $this->request->getPost('capacity'),
            'status'        => $this->request->getPost('status') ?? 'available'
        ];
        
        $model->insert($data);
        return redirect()->to('/admin/vehicles')->with('message', 'Kendaraan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new VehicleModel();
        $data['vehicle'] = $model->find($id);
        if (!$data['vehicle']) {
            return redirect()->to('/admin/vehicles')->with('error', 'Kendaraan tidak ditemukan');
        }
        return view('admin/vehicles/edit', $data);
    }

    public function update($id)
    {
        $model = new VehicleModel();
        $data = [
            'license_plate' => $this->request->getPost('license_plate'),
            'type'          => $this->request->getPost('type'),
            'capacity'      => $this->request->getPost('capacity'),
            'status'        => $this->request->getPost('status')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/vehicles')->with('message', 'Kendaraan berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new VehicleModel();
        $model->delete($id);
        return redirect()->to('/admin/vehicles')->with('message', 'Kendaraan berhasil dihapus');
    }
}

