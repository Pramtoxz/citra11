<?php

namespace App\Models;

use CodeIgniter\Model;

class Pengeluaran extends Model
{
    protected $table            = 'pengeluaran';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'tgl', 'keterangan', 'total'];

    // Dates
    protected $useTimestamps = false;
}
