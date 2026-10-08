<?php
namespace App\Models;
use CodeIgniter\Model;

class VehicleBookingModel extends Model {
    protected $table = 'vehicle_bookings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_code', 'user_id', 'vehicle_id', 'driver_id', 'destination', 'departure_time', 'return_time', 'start_km', 'end_km', 'status', 'approved_by'];
    protected $useTimestamps = true;
}
