<?php
namespace App\Models;
use CodeIgniter\Model;

class VehicleModel extends Model {
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vehicle_name', 'plate_number', 'capacity', 'status'];
    protected $useTimestamps = true;
}
