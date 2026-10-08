<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SupplyModel;

class SuppliesController extends BaseController
{
    public function index()
    {
        $model = new SupplyModel();
        $data['supplies'] = $model->findAll();
        // Cek alert batas stok minimum
        foreach ($data['supplies'] as &$item) {
            $item['low_stock'] = ($item['stock'] <= $item['min_stock']);
        }
        return view('admin/supplies/index', $data);
    }

    public function create()
    {
        return view('admin/supplies/create');
    }

    public function store()
    {
        $model = new SupplyModel();
        $data = [
            'item_name' => $this->request->getPost('item_name'),
            'stock'     => $this->request->getPost('stock'),
            'min_stock' => $this->request->getPost('min_stock'),
            'unit'      => $this->request->getPost('unit')
        ];
        
        $model->insert($data);
        return redirect()->to('/admin/supplies')->with('message', 'ATK/Supply berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new SupplyModel();
        $data['supply'] = $model->find($id);
        if (!$data['supply']) {
            return redirect()->to('/admin/supplies')->with('error', 'Item tidak ditemukan');
        }
        return view('admin/supplies/edit', $data);
    }

    public function update($id)
    {
        $model = new SupplyModel();
        $data = [
            'item_name' => $this->request->getPost('item_name'),
            'stock'     => $this->request->getPost('stock'),
            'min_stock' => $this->request->getPost('min_stock'),
            'unit'      => $this->request->getPost('unit')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/supplies')->with('message', 'ATK/Supply berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new SupplyModel();
        $model->delete($id);
        return redirect()->to('/admin/supplies')->with('message', 'ATK/Supply berhasil dihapus');
    }
}

