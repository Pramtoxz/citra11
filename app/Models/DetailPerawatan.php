<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPerawatan extends Model
{
    protected $table            = 'detail_perawatan';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['id','idperawatan','idobat', 'qty', 'total'];

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}