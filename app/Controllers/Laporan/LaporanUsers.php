<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanUsers extends BaseController
{

    public function LaporanTamu()
    {
        $data['title'] = 'Laporan Tamu';
        return view('laporan/users/tamu', $data);
    }

    public function viewallLaporanTamu()
    {
        $db = db_connect();
        $tamu = $db
            ->table('tamu')
            ->select('nik, nama, alamat, nohp, jk,users.email') 
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->groupBy('tamu.nik, tamu.nama, tamu.alamat, tamu.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'tamu' => $tamu,
        ];
        $response = [
            'data' => view('laporan/users/viewtamu', $data),
        ];

        echo json_encode($response);
    }


    public function LaporanKamar()
    {
        $data['title'] = 'Laporan Kamar';
        return view('laporan/users/kamar', $data);
    }

    public function viewallLaporanKamar()
    {
        $db = db_connect();
        $kamar = $db
            ->table('kamar')
            ->select('id_kamar, nama, harga, dp')
            ->groupBy('kamar.id_kamar, kamar.nama, kamar.harga, kamar.dp')
            ->get()
            ->getResultArray();
        $data = [
            'kamar' => $kamar,
        ];
        $response = [
            'data' => view('laporan/users/viewkamar', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanPengeluaran()
    {
        $data['title'] = 'Laporan Pengeluaran';
        return view('laporan/users/pengeluaran', $data);
    }


    public function viewallLaporanPengeluaranTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
            ->table('pengeluaran')
            ->select('id, tgl, keterangan, total')
            ->orderBy('pengeluaran.id', 'DESC')
            ->where('pengeluaran.tgl >=', $tglmulai)
            ->where('pengeluaran.tgl <=', $tglakhir)
            ->getCompiledSelect();
        $pengeluaran = $db->query($query)->getResultArray();
        $data = [
            'pengeluaran' => $pengeluaran,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/users/viewpengeluaran', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanPengeluaranTahun()
    {
        $tahun = $this->request->getPost('tahun');
        
        $db = db_connect();
        
        // Query untuk mendapatkan data pengeluaran per bulan dalam tahun tertentu
        $query = $db
            ->table('pengeluaran')
            ->select('MONTH(tgl) as bulan, SUM(total) as total_bulan')
            ->where('YEAR(tgl)', $tahun)
            ->groupBy('MONTH(tgl)')
            ->orderBy('MONTH(tgl)', 'ASC')
            ->getCompiledSelect();
        $pengeluaranPerBulan = $db->query($query)->getResultArray();
        
        $data = [
            'pengeluaranPerBulan' => $pengeluaranPerBulan,
            'tahun' => $tahun,
            'isLaporanTahun' => true
        ];
        $response = [
            'data' => view('laporan/users/viewpengeluaran', $data),
        ];

        echo json_encode($response);
    }
}
