<?php

namespace App\Models;

use CodeIgniter\Model;

class Kamar extends Model
{
    protected $table            = 'kamar';
    protected $primaryKey       = 'id_kamar';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kamar', 'nama', 'harga', 'status_kamar', 'cover','deskripsi','dp'];

    // Dates
    protected $useTimestamps = false;
}
