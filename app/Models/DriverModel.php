<?php
namespace App\Models;
use CodeIgniter\Model;

class DriverModel extends Model {
    protected $table = 'drivers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['driver_name', 'phone', 'status'];
    protected $useTimestamps = true;
}
