<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatMasuk extends Model
{
    protected $table            = 'obatmasuk';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'faktur','tglmasuk','idobat','tglexpired','qty'];

    // Dates
    protected $useTimestamps = false;

}