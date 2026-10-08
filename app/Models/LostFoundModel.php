<?php
namespace App\Models;
use CodeIgniter\Model;

class LostFoundModel extends Model {
    protected $table = 'lost_found';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item_name', 'category', 'location_found', 'photo', 'status', 'finder_name', 'claimed_by', 'claimed_at'];
    protected $useTimestamps = true;
}
