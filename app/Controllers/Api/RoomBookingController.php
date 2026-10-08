<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RoomModel;
use App\Models\RoomBookingModel;
use App\Traits\RoleScopeTrait;

class RoomBookingController extends ResourceController
{
    use RoleScopeTrait, \App\Traits\OverlapValidationTrait;

    protected $format = 'json';

    public function index()
    {
        $model = new RoomBookingModel();
        $model = $this->applyScope($model);
        
        $month = $this->request->getVar('month') ?: date('m');
        $year = $this->request->getVar('year') ?: date('Y');
        
        $model->where('MONTH(start_time)', $month)
              ->where('YEAR(start_time)', $year);
              
        return $this->respond($model->findAll());
    }

    public function create()
    {
        $model = new RoomBookingModel();
        
        $roomId = $this->request->getVar('room_id');
        $startTime = $this->request->getVar('start_time');
        $endTime = $this->request->getVar('end_time');

        if ($this->isSlotBooked($roomId, $startTime, $endTime, 'room')) {
            return $this->fail('Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya.', 409);
        }
        
        $data = [
            'booking_code'    => 'RB-' . time(),
            'user_id'         => session()->get('user_id'),
            'room_id'         => $roomId,
            'event_name'      => $this->request->getVar('event_name'),
            'start_time'      => $startTime,
            'end_time'        => $endTime,
            'total_attendees' => $this->request->getVar('total_attendees'),
            'notes'           => $this->request->getVar('notes'),
            'status'          => 'pending'
        ];
        
        $model->insert($data);
        return $this->respondCreated(['message' => 'Room booking requested successfully', 'booking_code' => $data['booking_code']]);
    }

    public function approve($id)
    {
        if (!$this->isAdmin()) {
            return $this->failForbidden('Only admin can approve bookings');
        }

        $model = new RoomBookingModel();
        $booking = $model->find($id);
        if (!$booking) return $this->failNotFound('Booking not found');
        
        $model->update($id, [
            'status'      => 'approved',
            'approved_by' => session()->get('user_id')
        ]);
        
        return $this->respond(['message' => 'Booking approved successfully']);
    }

    public function reject($id)
    {
        if (!$this->isAdmin()) {
            return $this->failForbidden('Only admin can reject bookings');
        }

        $model = new RoomBookingModel();
        $booking = $model->find($id);
        if (!$booking) return $this->failNotFound('Booking not found');
        
        $model->update($id, [
            'status'      => 'rejected',
            'approved_by' => session()->get('user_id')
        ]);
        
        return $this->respond(['message' => 'Booking rejected successfully']);
    }
}

