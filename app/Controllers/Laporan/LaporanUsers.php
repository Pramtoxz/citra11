<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanUsers extends BaseController
{

    public function LaporanPasien()
    {
        $data['title'] = 'Laporan Pasien';
        return view('laporan/users/pasien', $data);
    }

    public function viewallLaporanPasien()
    {
        $db = db_connect();
        $pasien = $db
            ->table('pasien')
            ->select('id_pasien, nama, alamat, nohp, jenkel, tgllahir,users.email') 
            ->join('users', 'users.id = pasien.iduser', 'left')
            ->groupBy('pasien.id_pasien, pasien.nama, pasien.alamat, pasien.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'pasien' => $pasien,
        ];
        $response = [
            'data' => view('laporan/users/viewallpasien', $data),
        ];

        echo json_encode($response);
    }


    public function LaporanDokter()
    {
        $data['title'] = 'Laporan Dokter';
        return view('laporan/users/dokter', $data);
    }

    public function viewallLaporanDokter()
    {
        $db = db_connect();
        $dokter = $db
            ->table('dokter')
            ->select('id_dokter, nama, alamat, nohp, jenkel, tgllahir, users.email')
            ->join('users', 'users.id = dokter.iduser', 'left')
            ->groupBy('dokter.id_dokter, dokter.nama, dokter.alamat, dokter.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'dokter' => $dokter,
        ];
        $response = [
            'data' => view('laporan/users/viewalldokter', $data),
        ];

        echo json_encode($response);
    }




}
