<?php
namespace App\Models;
use CodeIgniter\Model;

class SupplyRequestModel extends Model {
    protected $table = 'supply_requests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['request_code', 'user_id', 'status', 'approved_by'];
    protected $useTimestamps = true;
}
