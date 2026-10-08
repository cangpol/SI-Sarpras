<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\VehicleModel;
use App\Models\DriverModel;
use App\Models\VehicleBookingModel;
use App\Traits\RoleScopeTrait;

class VehicleBookingController extends ResourceController
{
    use RoleScopeTrait, \App\Traits\OverlapValidationTrait;
    protected $format = 'json';

    public function index()
    {
        $model = new VehicleBookingModel();
        $model = $this->applyScope($model);

        $month = $this->request->getVar('month') ?: date('m');
        $year = $this->request->getVar('year') ?: date('Y');
        
        $model->where('MONTH(departure_time)', $month)
              ->where('YEAR(departure_time)', $year);

        return $this->respond($model->findAll());
    }

    public function create()
    {
        $model = new VehicleBookingModel();
        
        $vehicleId = $this->request->getVar('vehicle_id');
        $startTime = $this->request->getVar('departure_time');
        $endTime = $this->request->getVar('return_time');

        if ($vehicleId && $this->isSlotBooked($vehicleId, $startTime, $endTime, 'vehicle')) {
            return $this->fail('Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya.', 409);
        }
        
        $data = [
            'booking_code'   => 'VB-' . time(),
            'user_id'        => session()->get('user_id'),
            'vehicle_id'     => $vehicleId,
            'destination'    => $this->request->getVar('destination'),
            'departure_time' => $startTime,
            'return_time'    => $endTime,
            'status'         => 'pending'
        ];
        
        $model->insert($data);
        return $this->respondCreated(['message' => 'Vehicle booking requested successfully', 'booking_code' => $data['booking_code']]);
    }

    public function approve($id)
    {
        if (!$this->isAdmin()) {
            return $this->failForbidden('Only admin can approve bookings');
        }

        $model = new VehicleBookingModel();
        $booking = $model->find($id);
        if (!$booking) return $this->failNotFound('Booking not found');
        
        $vehicleId = $this->request->getVar('vehicle_id');
        $driverId = $this->request->getVar('driver_id');

        // Check availability
        $vModel = new VehicleModel();
        $vehicle = $vModel->find($vehicleId);
        if ($vehicle['status'] !== 'available') return $this->fail('Vehicle not available', 409);

        $dModel = new DriverModel();
        $driver = $dModel->find($driverId);
        if ($driver['status'] !== 'available') return $this->fail('Driver not available', 409);
        
        // Update statuses
        $vModel->update($vehicleId, ['status' => 'in_use']);
        $dModel->update($driverId, ['status' => 'on_trip']);
        
        $model->update($id, [
            'vehicle_id'  => $vehicleId,
            'driver_id'   => $driverId,
            'status'      => 'approved',
            'approved_by' => session()->get('user_id')
        ]);
        
        return $this->respond(['message' => 'Booking approved successfully']);
    }

    public function completeTrip($id)
    {
        $model = new VehicleBookingModel();
        $booking = $model->find($id);
        if (!$booking) return $this->failNotFound('Booking not found');

        $startKm = $this->request->getVar('start_km');
        $endKm = $this->request->getVar('end_km');

        $model->update($id, [
            'start_km' => $startKm,
            'end_km'   => $endKm,
            'status'   => 'completed'
        ]);

        // Free vehicle and driver
        if ($booking['vehicle_id']) {
            (new VehicleModel())->update($booking['vehicle_id'], ['status' => 'available']);
        }
        if ($booking['driver_id']) {
            (new DriverModel())->update($booking['driver_id'], ['status' => 'available']);
        }

        return $this->respond(['message' => 'Trip completed successfully']);
    }
}

