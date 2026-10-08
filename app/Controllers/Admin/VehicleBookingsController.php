<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VehicleBookingModel;

class VehicleBookingsController extends BaseController
{
    public function index()
    {
        $model = new VehicleBookingModel();
        // S3.1 Default Query Current Month Filtering
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        
        $model->where('MONTH(departure_time)', $month)
              ->where('YEAR(departure_time)', $year);
              
        $data['bookings'] = $model->findAll();
        $data['month'] = $month;
        $data['year'] = $year;
        return view('admin/vehicle_bookings/index', $data);
    }

    public function edit($id)
    {
        $model = new VehicleBookingModel();
        $data['booking'] = $model->find($id);
        return view('admin/vehicle_bookings/edit', $data);
    }

    public function update($id)
    {
        $model = new VehicleBookingModel();
        
        $vehicleId = $this->request->getPost('vehicle_id');
        $startTime = $this->request->getPost('departure_time');
        $endTime = $this->request->getPost('return_time');
        
        // E3.1 Conflict Detection Query
        $db = \Config\Database::connect();
        $builder = $db->table('vehicle_bookings');
        $builder->where('vehicle_id', $vehicleId)
                ->where('id !=', $id)
                ->where('status !=', 'Rejected')
                ->where('departure_time <', $endTime)
                ->where('return_time >', $startTime);
                
        if ($builder->countAllResults() > 0) {
            // E3.2 Unified Notification Handling
            return redirect()->back()->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya.');
        }

        $data = [
            'vehicle_id'     => $vehicleId,
            'driver_id'      => $this->request->getPost('driver_id'),
            'departure_time' => $startTime,
            'return_time'    => $endTime,
            'destination'    => $this->request->getPost('destination')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/vehicle-bookings')->with('message', 'Booking updated successfully');
    }

    public function approve($id)
    {
        $model = new VehicleBookingModel();
        $model->update($id, [
            'status' => 'Approved',
            'driver_id' => $this->request->getPost('driver_id'),
            'admin_notes' => $this->request->getPost('notes')
        ]);
        return redirect()->to('/admin/vehicle-bookings')->with('message', 'Booking approved with driver');
    }

    public function reject($id)
    {
        $model = new VehicleBookingModel();
        $model->update($id, [
            'status' => 'Rejected',
            'admin_notes' => $this->request->getPost('notes')
        ]);
        return redirect()->to('/admin/vehicle-bookings')->with('message', 'Booking rejected');
    }

    public function complete($id)
    {
        $model = new VehicleBookingModel();
        $model->update($id, [
            'status' => 'Completed',
            'start_km' => $this->request->getPost('start_km'),
            'end_km'   => $this->request->getPost('end_km')
        ]);
        return redirect()->to('/admin/vehicle-bookings')->with('message', 'Trip completed');
    }
    
    public function delete($id)
    {
        $model = new VehicleBookingModel();
        $model->delete($id);
        return redirect()->to('/admin/vehicle-bookings')->with('message', 'Booking deleted');
    }
}

