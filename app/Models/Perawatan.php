<?php

namespace App\Models;

use CodeIgniter\Model;

class Perawatan extends Model
{
    protected $table            = 'perawatan';
    protected $primaryKey       = 'idperawatan';
    protected $protectFields    = true;
    protected $allowedFields    = ['idperawatan','tanggal', 'idbooking', 'resep','total'];

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

}