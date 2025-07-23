<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jadwal as JadwalDokter;
use App\Models\Dokter;
use App\Models\Jenis as Jenisperawatan;

class Home extends BaseController
{
    public function index()
    {
        $jadwal = new JadwalDokter();
        $dokter = new Dokter();
        $jenis = new Jenisperawatan();

        $jadwal = $jadwal->findAll();
        $dokter = $dokter->findAll();
        $jenis = $jenis->findAll();

        $data = [
            'jadwal' => $jadwal,    
            'dokter' => $dokter,
            'jenis' => $jenis,
        ];
        return view('online/index', $data);
    }
    

}