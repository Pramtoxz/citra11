<?php

namespace App\Models;

use CodeIgniter\Model;

class Kamar extends Model
{
    protected $table            = 'kamar';
    protected $primaryKey       = 'id_kamar';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kamar', 'nama', 'harga', 'status_kamar'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
