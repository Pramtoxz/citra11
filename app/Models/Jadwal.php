<?php

namespace App\Models;

use CodeIgniter\Model;

class Jadwal extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'idjadwal';
    protected $protectFields    = true;
    protected $allowedFields    = ['idjadwal', 'iddokter', 'hari', 'waktu_mulai', 'waktu_selesai', 'is_active'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}