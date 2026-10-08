<?php
namespace App\Models;
use CodeIgniter\Model;

class MaintenanceRequestModel extends Model {
    protected $table = 'maintenance_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ticket_code', 'user_id', 'location', 'asset_name', 'description', 'photo', 'priority', 'technician_id', 'status', 'cost'];
    protected $useTimestamps = true;
}
