<?php

namespace App\Models;

use CodeIgniter\Model;

class Obat extends Model
{
    protected $table            = 'obat';
    protected $primaryKey       = 'idobat';
    protected $protectFields    = true;
    protected $allowedFields    = ['idobat', 'nama', 'stok', 'jenis','keterangan','harga'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}