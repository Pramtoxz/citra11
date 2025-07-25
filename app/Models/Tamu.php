<?php

namespace App\Models;

use CodeIgniter\Model;

class Tamu extends Model
{
    protected $table            = 'tamu';
    protected $primaryKey       = 'nik';
    protected $protectFields    = true;
    protected $allowedFields    = ['nik', 'nama', 'alamat', 'nohp', 'jk', 'iduser'];

    // Dates
    protected $useTimestamps = false;
}
