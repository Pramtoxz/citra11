<?php

namespace App\Models;

use CodeIgniter\Model;

class Jenis extends Model
{
    protected $table            = 'jenis_perawatan';
    protected $primaryKey       = 'idjenis';
    protected $protectFields    = true;
    protected $allowedFields    = ['idjenis', 'namajenis', 'estimasi', 'harga', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}