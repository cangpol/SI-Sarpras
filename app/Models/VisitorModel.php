<?php
namespace App\Models;
use CodeIgniter\Model;

class VisitorModel extends Model {
    protected $table = 'visitors';
    protected $primaryKey = 'id';
    protected $allowedFields = ['visitor_code', 'name', 'company', 'phone', 'purpose', 'host_person', 'check_in', 'check_out', 'status'];
    protected $useTimestamps = true;
}
