<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanTransaksi extends BaseController
{

    public function LaporanReservasi()
    {
        $data['title'] = 'Laporan Reservasi';
        return view('laporan/reservasi/reservasi', $data);
    }


    public function viewallLaporanReservasiTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari ReservasiController->detail() method dengan join yang tepat
        $reservasi = $db->table('reservasi')
            ->select('
                reservasi.idbooking,
                reservasi.created_at as tanggal_booking, 
                reservasi.tglcheckin, 
                reservasi.tglcheckout, 
                reservasi.status,
                reservasi.tipe,
                reservasi.totalbayar,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.nama as nama_kamar, 
                kamar.harga
            ')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.tglcheckin >=', $tglmulai)
            ->where('reservasi.tglcheckin <=', $tglakhir)
            ->orderBy('reservasi.idbooking', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'reservasi' => $reservasi,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/reservasi/viewreservasi', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanReservasiBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari ReservasiController->detail() method dengan join yang tepat
        $reservasi = $db->table('reservasi')
            ->select('
                reservasi.idbooking,
                reservasi.created_at as tanggal_booking, 
                reservasi.tglcheckin, 
                reservasi.tglcheckout, 
                reservasi.status,
                reservasi.tipe,
                reservasi.totalbayar,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.nama as nama_kamar, 
                kamar.harga
            ')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.tglcheckin >=', $bulanawal . '-01')
            ->where('reservasi.tglcheckin <=', $bulanakhir . '-31')
            ->orderBy('reservasi.idbooking', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'reservasi' => $reservasi,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/reservasi/viewreservasi', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanCheckin()
    {
        $data['title'] = 'Laporan Checkin';
        return view('laporan/checkin/checkin', $data);
    }

    public function viewallLaporanCheckinTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari CheckinController->detail() method dengan join yang tepat
        $checkin = $db->table('checkin')
            ->select('
                checkin.idcheckin,
                checkin.idbooking,
                checkin.sisabayar,
                checkin.deposit,
                checkin.created_at as tanggal_checkin,
                reservasi.totalbayar,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.harga
            ')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkin.created_at >=', $tglmulai)
            ->where('checkin.created_at <=', $tglakhir)
            ->orderBy('checkin.idcheckin', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkin' => $checkin,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/checkin/viewcheckin', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanCheckinBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari CheckinController->detail() method dengan join yang tepat
        $checkin = $db->table('checkin')
            ->select('
                checkin.idcheckin,
                checkin.idbooking,
                checkin.sisabayar,
                checkin.deposit,
                checkin.created_at as tanggal_checkin,
                reservasi.totalbayar,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.harga
            ')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkin.created_at >=', $bulanawal . '-01')
            ->where('checkin.created_at <=', $bulanakhir . '-31')
            ->orderBy('checkin.idcheckin', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkin' => $checkin,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/checkin/viewcheckin', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanCheckout()
    {
        $data['title'] = 'Laporan Checkout';
        return view('laporan/checkout/checkout', $data);
    }

    public function viewallLaporanCheckoutTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari CheckoutController->detail() method dengan join yang tepat
        $checkout = $db->table('checkout')
            ->select('
                checkout.idcheckout,
                checkout.idcheckin,
                checkout.tglcheckout,
                checkout.potongan,
                checkout.keterangan,
                checkin.deposit,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar
            ')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkout.tglcheckout >=', $tglmulai)
            ->where('checkout.tglcheckout <=', $tglakhir . ' 23:59:59')
            ->orderBy('checkout.idcheckout', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkout' => $checkout,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/checkout/viewcheckout', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanCheckoutBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari CheckoutController->detail() method dengan join yang tepat
        $checkout = $db->table('checkout')
            ->select('
                checkout.idcheckout,
                checkout.idcheckin,
                checkout.tglcheckout,
                checkout.potongan,
                checkout.keterangan,
                checkin.deposit,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar
            ')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkout.tglcheckout >=', $bulanawal . '-01')
            ->where('checkout.tglcheckout <=', $bulanakhir . '-31 23:59:59')
            ->orderBy('checkout.idcheckout', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkout' => $checkout,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/checkout/viewcheckout', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanPendapatan()
    {
        $data['title'] = 'Laporan Pendapatan Bersih';
        return view('laporan/pendapatan/pendapatan', $data);
    }

    public function viewallLaporanPendapatanTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Query yang diperbaiki: checkout dihitung berdasarkan tanggal checkin yang terkait
        $pendapatan = $db->query("
            SELECT 
                dates.tanggal,
                (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) as total_checkin,
                COALESCE(checkout_data.total_checkout, 0) as total_checkout,
                ((COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) - COALESCE(checkout_data.total_checkout, 0)) as total_bersih
            FROM (
                SELECT DISTINCT DATE(created_at) as tanggal FROM checkin WHERE DATE(created_at) BETWEEN ? AND ?
            ) dates
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkin.sisabayar + checkin.deposit) as total_checkin
                FROM checkin 
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) checkin_data ON dates.tanggal = checkin_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(reservasi.totalbayar) as total_dp
                FROM checkin 
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) reservasi_data ON dates.tanggal = reservasi_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkout.potongan) as total_checkout
                FROM checkout
                JOIN checkin ON checkin.idcheckin = checkout.idcheckin
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) checkout_data ON dates.tanggal = checkout_data.tanggal
            WHERE (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) > 0
            ORDER BY dates.tanggal ASC
        ", [$tglmulai, $tglakhir, $tglmulai, $tglakhir, $tglmulai, $tglakhir, $tglmulai, $tglakhir])->getResultArray();
            
        $data = [
            'pendapatan' => $pendapatan,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/pendapatan/viewpendapatan', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanPendapatanBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Query yang diperbaiki: checkout dihitung berdasarkan tanggal checkin yang terkait
        $pendapatan = $db->query("
            SELECT 
                dates.tanggal,
                (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) as total_checkin,
                COALESCE(checkout_data.total_checkout, 0) as total_checkout,
                ((COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) - COALESCE(checkout_data.total_checkout, 0)) as total_bersih
            FROM (
                SELECT DISTINCT DATE(created_at) as tanggal FROM checkin WHERE DATE(created_at) BETWEEN ? AND ?
            ) dates
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkin.sisabayar + checkin.deposit) as total_checkin
                FROM checkin 
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) checkin_data ON dates.tanggal = checkin_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(reservasi.totalbayar) as total_dp
                FROM checkin 
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) reservasi_data ON dates.tanggal = reservasi_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkout.potongan) as total_checkout
                FROM checkout
                JOIN checkin ON checkin.idcheckin = checkout.idcheckin
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) checkout_data ON dates.tanggal = checkout_data.tanggal
            WHERE (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_checkin, 0)) > 0
            ORDER BY dates.tanggal ASC
        ", [
            $bulanawal . '-01', $bulanakhir . '-31',
            $bulanawal . '-01', $bulanakhir . '-31', 
            $bulanawal . '-01', $bulanakhir . '-31',
            $bulanawal . '-01', $bulanakhir . '-31'
        ])->getResultArray();
            
        $data = [
            'pendapatan' => $pendapatan,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/pendapatan/viewpendapatan', $data),
        ];

        echo json_encode($response);
    }
}
