<?php
namespace App\Models;
use CodeIgniter\Model;

class SupplyModel extends Model {
    protected $table = 'supplies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item_code', 'item_name', 'category', 'stock', 'unit', 'min_stock'];
    protected $useTimestamps = true;
}
