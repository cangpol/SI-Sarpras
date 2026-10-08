<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\VisitorModel;
use App\Models\LostFoundModel;
use App\Traits\RoleScopeTrait;

class SecurityController extends ResourceController
{
    use RoleScopeTrait;

    protected $format = 'json';

    // --- Visitor Pass API ---

    public function getActiveVisitors()
    {
        $model = new VisitorModel();
        $visitors = $model->where('status', 'checked_in')->findAll();
        return $this->respond($visitors);
    }

    public function visitorCheckIn()
    {
        $model = new VisitorModel();
        
        $data = [
            'visitor_code' => 'V-' . time(),
            'name'         => $this->request->getVar('name'),
            'company'      => $this->request->getVar('company'),
            'phone'        => $this->request->getVar('phone'),
            'purpose'      => $this->request->getVar('purpose'),
            'host_person'  => $this->request->getVar('host_person'),
            'check_in'     => date('Y-m-d H:i:s'),
            'status'       => 'checked_in'
        ];
        
        $model->insert($data);
        return $this->respondCreated(['message' => 'Visitor checked in successfully', 'visitor_code' => $data['visitor_code']]);
    }

    public function visitorCheckOut($id)
    {
        $model = new VisitorModel();
        $visitor = $model->find($id);
        if (!$visitor) return $this->failNotFound('Visitor not found');
        
        $model->update($id, [
            'check_out' => date('Y-m-d H:i:s'),
            'status'    => 'checked_out'
        ]);
        
        return $this->respond(['message' => 'Visitor checked out successfully']);
    }

    // --- Lost & Found API ---

    public function reportLostFound()
    {
        $model = new LostFoundModel();
        
        $data = [
            'item_name'      => $this->request->getPost('item_name'),
            'category'       => $this->request->getPost('category'),
            'location_found' => $this->request->getPost('location_found'),
            'finder_name'    => $this->request->getPost('finder_name'),
            'status'         => 'found'
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(ROOTPATH . 'public/uploads/lost_found', $newName);
            $data['photo'] = $newName;
        }

        $model->insert($data);
        return $this->respondCreated(['message' => 'Item reported successfully']);
    }

    public function claimLostFound($id)
    {
        $model = new LostFoundModel();
        $item = $model->find($id);
        if (!$item) return $this->failNotFound('Item not found');
        
        $claimed_by = $this->request->getVar('claimed_by');
        
        $model->update($id, [
            'claimed_by' => $claimed_by,
            'claimed_at' => date('Y-m-d H:i:s'),
            'status'     => 'claimed'
        ]);
        
        return $this->respond(['message' => 'Item claimed successfully']);
    }
}

