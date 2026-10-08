<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MaintenanceRequestModel;

class MaintenanceController extends BaseController
{
    public function index()
    {
        $model = new MaintenanceRequestModel();
        // S3.1 Default Query Current Month Filtering
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        
        $model->where('MONTH(created_at)', $month)
              ->where('YEAR(created_at)', $year);
              
        $data['requests'] = $model->findAll();
        $data['month'] = $month;
        $data['year'] = $year;
        return view('admin/maintenance/index', $data);
    }

    public function assign($id)
    {
        $model = new MaintenanceRequestModel();
        $model->update($id, [
            'technician_id' => $this->request->getPost('technician_id'),
            'status'        => 'In Progress'
        ]);
        return redirect()->to('/admin/maintenance')->with('message', 'Technician assigned');
    }

    public function resolve($id)
    {
        $model = new MaintenanceRequestModel();
        $model->update($id, [
            'status'          => 'Resolved',
            'cost'            => $this->request->getPost('cost'),
            'resolution_note' => $this->request->getPost('resolution_note'),
            'resolved_at'     => date('Y-m-d H:i:s')
        ]);
        return redirect()->to('/admin/maintenance')->with('message', 'Ticket resolved');
    }
}

