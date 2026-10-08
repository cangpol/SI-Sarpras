<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SupplyModel;
use App\Models\SupplyRequestModel;
use App\Models\SupplyRequestItemModel;
use App\Traits\RoleScopeTrait;

class SupplyController extends ResourceController
{
    use RoleScopeTrait;
    protected $format = 'json';

    public function index()
    {
        $model = new SupplyModel();
        return $this->respond($model->findAll());
    }

    public function requestSupplies()
    {
        $items = $this->request->getVar('items'); // array of ['supply_id' => x, 'quantity' => y]
        if (empty($items)) return $this->fail('No items requested');

        $sModel = new SupplyModel();
        foreach ($items as $item) {
            $supply = $sModel->find($item['supply_id']);
            if (!$supply || $supply['stock'] < $item['quantity']) {
                return $this->fail('Insufficient stock for item: ' . ($supply['item_name'] ?? 'Unknown'));
            }
        }

        $rModel = new SupplyRequestModel();
        $iModel = new SupplyRequestItemModel();

        $requestId = $rModel->insert([
            'request_code' => 'SR-' . time(),
            'user_id'      => session()->get('user_id'),
            'status'       => 'pending'
        ]);

        foreach ($items as $item) {
            $iModel->insert([
                'request_id' => $requestId,
                'supply_id'  => $item['supply_id'],
                'quantity'   => $item['quantity']
            ]);
        }

        return $this->respondCreated(['message' => 'Supplies requested successfully']);
    }

    public function approve($id)
    {
        if (!$this->isAdmin()) {
            return $this->failForbidden('Only admin can approve requests');
        }

        $rModel = new SupplyRequestModel();
        $request = $rModel->find($id);
        if (!$request) return $this->failNotFound('Request not found');
        if ($request['status'] !== 'pending') return $this->fail('Request is already processed');

        $iModel = new SupplyRequestItemModel();
        $sModel = new SupplyModel();

        $items = $iModel->where('request_id', $id)->findAll();
        
        // Re-check stock just in case
        foreach ($items as $item) {
            $supply = $sModel->find($item['supply_id']);
            if ($supply['stock'] < $item['quantity']) {
                return $this->fail('Insufficient stock for item: ' . $supply['item_name']);
            }
        }

        // Deduct stock
        foreach ($items as $item) {
            $sModel->set('stock', 'stock - ' . $item['quantity'], false)
                   ->where('id', $item['supply_id'])
                   ->update();
        }

        $rModel->update($id, [
            'status'      => 'approved',
            'approved_by' => session()->get('user_id')
        ]);
        
        return $this->respond(['message' => 'Request approved and stock updated']);
    }
}

