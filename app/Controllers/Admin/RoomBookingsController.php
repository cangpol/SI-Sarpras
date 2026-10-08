<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomBookingModel;
use App\Controllers\Api\RoomBookingController as ApiRoomBooking;

class RoomBookingsController extends BaseController
{
    public function index()
    {
        $model = new RoomBookingModel();
        // S3.1 Default Query Current Month Filtering
        $month = $this->request->getGet('month') ?? date('m');
        $year = $this->request->getGet('year') ?? date('Y');
        
        $model->where('MONTH(start_time)', $month)
              ->where('YEAR(start_time)', $year);
              
        $data['bookings'] = $model->findAll();
        $data['month'] = $month;
        $data['year'] = $year;
        return view('admin/room_bookings/index', $data);
    }

    public function edit($id)
    {
        $model = new RoomBookingModel();
        $data['booking'] = $model->find($id);
        return view('admin/room_bookings/edit', $data);
    }

    public function update($id)
    {
        $model = new RoomBookingModel();
        
        $roomId = $this->request->getPost('room_id');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');
        
        // E3.1 Conflict Detection Query (Include/Exclude Current Record ID)
        $db = \Config\Database::connect();
        $builder = $db->table('room_bookings');
        $builder->where('room_id', $roomId)
                ->where('id !=', $id)
                ->where('status !=', 'Rejected')
                ->where('start_time <', $endTime)
                ->where('end_time >', $startTime);
                
        if ($builder->countAllResults() > 0) {
            // E3.2 Unified Notification Handling
            return redirect()->back()->with('error', 'Jadwal untuk tanggal dan jam tersebut sudah penuh, silahkan cari tanggal atau jam lainnya.');
        }

        $data = [
            'room_id'    => $roomId,
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'event_name' => $this->request->getPost('event_name')
        ];
        
        $model->update($id, $data);
        return redirect()->to('/admin/room-bookings')->with('message', 'Booking updated successfully');
    }

    public function approve($id)
    {
        $model = new RoomBookingModel();
        $model->update($id, [
            'status' => 'Approved',
            'admin_notes' => $this->request->getPost('notes')
        ]);
        return redirect()->to('/admin/room-bookings')->with('message', 'Booking approved');
    }

    public function reject($id)
    {
        $model = new RoomBookingModel();
        $model->update($id, [
            'status' => 'Rejected',
            'admin_notes' => $this->request->getPost('notes')
        ]);
        return redirect()->to('/admin/room-bookings')->with('message', 'Booking rejected');
    }
    
    public function delete($id)
    {
        $model = new RoomBookingModel();
        $model->delete($id);
        return redirect()->to('/admin/room-bookings')->with('message', 'Booking deleted');
    }
}

