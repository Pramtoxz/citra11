<?php

namespace App\Models;

use CodeIgniter\Model;

class Dokter extends Model
{
    protected $table            = 'dokter';
    protected $primaryKey       = 'id_dokter';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_dokter', 'nama', 'alamat', 'nohp', 'jenkel','tgllahir','iduser','foto'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}