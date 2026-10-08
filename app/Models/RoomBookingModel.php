<?php
namespace App\Models;
use CodeIgniter\Model;

class RoomBookingModel extends Model {
    protected $table = 'room_bookings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_code', 'user_id', 'room_id', 'event_name', 'start_time', 'end_time', 'total_attendees', 'notes', 'status', 'approved_by'];
    protected $useTimestamps = true;
}
