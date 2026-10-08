<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DriverModel;

class DriversController extends BaseController
{
    public function index()
    {
        $model = new DriverModel();
        $data['drivers'] = $model->findAll();
        return view('admin/drivers/index', $data);
    }

    public function create()
    {
        return view('admin/drivers/create');
    }

    public function store()
    {
        $model = new DriverModel();
        $data = [
            'name'         => $this->request->getPost('name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'status'       => $this->request->getPost('status') ?? 'available'
        ];
        
        $model->insert($data);
        return redirect()->to('/admin/drivers')->with('message', 'Driver berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new DriverModel();
        $data['driver'] = $model->find($id);
        if (!$data['driver']) {
            return redirect()->to('/admin/drivers')->with('error', 'Driver tidak ditemukan');
        }
        return view('admin/drivers/edit', $data);
    }

    public function update($id)
    {
        $model = new DriverModel();
        $data = [
            'name'         => $this->request->getPost('name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'status'       => $this->request->getPost('status')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/drivers')->with('message', 'Driver berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new DriverModel();
        $model->delete($id);
        return redirect()->to('/admin/drivers')->with('message', 'Driver berhasil dihapus');
    }
}

