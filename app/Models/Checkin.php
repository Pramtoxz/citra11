<?php

namespace App\Models;

use CodeIgniter\Model;

class Checkin extends Model
{
    protected $table            = 'checkin';
    protected $primaryKey       = 'idcheckin';
    protected $protectFields    = true;
    protected $allowedFields    = ['idcheckin', 'idbooking', 'sisabayar', 'deposit'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Soft Deletes
    protected $useSoftDeletes = true;
}
