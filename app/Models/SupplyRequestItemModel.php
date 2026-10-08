<?php
namespace App\Models;
use CodeIgniter\Model;

class SupplyRequestItemModel extends Model {
    protected $table = 'supply_request_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['request_id', 'supply_id', 'quantity'];
    public $useTimestamps = false;
}
