<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\MaintenanceRequestModel;
use App\Traits\RoleScopeTrait;

class MaintenanceController extends ResourceController
{
    use RoleScopeTrait;
    protected $format = 'json';

    public function index()
    {
        $model = new MaintenanceRequestModel();
        
        // Teknisi sees their assigned tickets, users see their own, admins see all.
        $roleName = session()->get('role_name');
        if ($roleName === 'Teknisi') {
            $model->where('technician_id', session()->get('user_id'));
        } else {
            $model = $this->applyScope($model);
        }
        
        return $this->respond($model->findAll());
    }

    public function create()
    {
        $model = new MaintenanceRequestModel();
        
        $data = [
            'ticket_code' => 'MT-' . time(),
            'user_id'     => session()->get('user_id'),
            'location'    => $this->request->getPost('location'),
            'asset_name'  => $this->request->getPost('asset_name'),
            'description' => $this->request->getPost('description'),
            'priority'    => $this->request->getPost('priority') ?? 'medium',
            'status'      => 'pending'
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(ROOTPATH . 'public/uploads/maintenance', $newName);
            $data['photo'] = $newName;
        }

        $model->insert($data);
        return $this->respondCreated(['message' => 'Maintenance ticket created successfully', 'ticket_code' => $data['ticket_code']]);
    }

    public function assignTechnician($id)
    {
        if (!$this->isAdmin()) {
            return $this->failForbidden('Only admin can assign technician');
        }

        $model = new MaintenanceRequestModel();
        $ticket = $model->find($id);
        if (!$ticket) return $this->failNotFound('Ticket not found');
        
        $model->update($id, [
            'technician_id' => $this->request->getVar('technician_id'),
            'status'        => 'in_progress'
        ]);
        
        return $this->respond(['message' => 'Technician assigned successfully']);
    }

    public function updateStatus($id)
    {
        $model = new MaintenanceRequestModel();
        $ticket = $model->find($id);
        if (!$ticket) return $this->failNotFound('Ticket not found');
        
        $roleName = session()->get('role_name');
        if (!$this->isAdmin() && !($roleName === 'Teknisi' && $ticket['technician_id'] == session()->get('user_id'))) {
            return $this->failForbidden('Not authorized to update this ticket');
        }

        $data = [
            'status' => $this->request->getVar('status')
        ];
        
        if ($this->request->getVar('cost')) {
            $data['cost'] = $this->request->getVar('cost');
        }
        
        $model->update($id, $data);
        return $this->respond(['message' => 'Ticket status updated successfully']);
    }
}

