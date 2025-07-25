<?php

namespace App\Models;

use CodeIgniter\Model;

class Reservasi extends Model
{
    protected $table            = 'reservasi';
    protected $primaryKey       = 'idbooking';
    protected $protectFields    = true;
    protected $allowedFields    = ['idbooking', 'nik', 'idkamar', 'tglcheckin', 'tglcheckout', 'totalbayar', 'tipebayar','buktibayar','status','online'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
