<?php

namespace App\Models;

use CodeIgniter\Model;

class Checkout extends Model
{
    protected $table            = 'checkout';
    protected $primaryKey       = 'idcheckout';
    protected $protectFields    = true;
    protected $allowedFields    = ['idcheckout', 'idcheckin', 'tglcheckout', 'potongan', 'grandtotal', 'keterangan'];

    // Dates
    protected $useTimestamps = false;
    
    // Soft Deletes
    protected $useSoftDeletes = false;
}
