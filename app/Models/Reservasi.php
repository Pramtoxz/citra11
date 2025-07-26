<?php

namespace App\Models;

use CodeIgniter\Model;

class Reservasi extends Model
{
    protected $table            = 'reservasi';
    protected $primaryKey       = 'idbooking';
    protected $protectFields    = true;
    protected $allowedFields    = ['idbooking', 'nik', 'idkamar', 'tglcheckin', 'tglcheckout', 'lama', 'totalbayar', 'tipe','buktibayar','status','online','batas_waktu'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Soft Deletes - disabled untuk primary key string
    protected $useSoftDeletes = false;
    
    // Validation rules sesuai database constraint
    protected $validationRules = [
        'idbooking' => 'required|max_length[30]',
        'nik' => 'required|max_length[30]',
        'idkamar' => 'required|max_length[30]',
        'tglcheckin' => 'required|valid_date',
        'tglcheckout' => 'required|valid_date',
        'totalbayar' => 'required|numeric|greater_than[0]',
        'tipe' => 'required|max_length[255]',
        'status' => 'permit_empty|in_list[diproses,diterima,ditolak,checkin,selesai,cancel,limit]',
        'online' => 'permit_empty|in_list[0,1]'
    ];
    
    protected $validationMessages = [
        'idbooking' => [
            'required' => 'ID Booking harus diisi',
            'max_length' => 'ID Booking maksimal 30 karakter'
        ],
        'nik' => [
            'required' => 'NIK harus diisi',
            'max_length' => 'NIK maksimal 30 karakter'
        ],
        'idkamar' => [
            'required' => 'ID Kamar harus diisi',
            'max_length' => 'ID Kamar maksimal 30 karakter'
        ],
        'tglcheckin' => [
            'required' => 'Tanggal check-in harus diisi',
            'valid_date' => 'Format tanggal check-in tidak valid'
        ],
        'tglcheckout' => [
            'required' => 'Tanggal check-out harus diisi',
            'valid_date' => 'Format tanggal check-out tidak valid'
        ],
        'totalbayar' => [
            'required' => 'Total bayar harus diisi',
            'numeric' => 'Total bayar harus berupa angka',
            'greater_than' => 'Total bayar harus lebih dari 0'
        ],
        'tipe' => [
            'required' => 'Tipe pembayaran harus diisi',
            'max_length' => 'Tipe pembayaran maksimal 255 karakter'
        ],
        'status' => [
            'in_list' => 'Status tidak valid'
        ],
        'online' => [
            'in_list' => 'Flag online harus 0 atau 1'
        ]
    ];
}
