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
        
        // Query dengan logika pendapatan yang benar:
        // Pendapatan Checkin = DP + Sisa Bayar
        // Pendapatan Checkout = Potongan (hanya jika ada transaksi checkout)
        // Total = Pendapatan Checkin + Pendapatan Checkout
        $pendapatan = $db->query("
            SELECT 
                dates.tanggal,
                (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) as total_checkin,
                COALESCE(checkout_data.total_potongan, 0) as total_checkout,
                ((COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) + COALESCE(checkout_data.total_potongan, 0)) as total_bersih
            FROM (
                SELECT DISTINCT DATE(created_at) as tanggal FROM checkin WHERE DATE(created_at) BETWEEN ? AND ?
            ) dates
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkin.sisabayar) as total_sisabayar
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
                SELECT DATE(checkin.created_at) as tanggal, SUM(COALESCE(checkout.potongan, 0)) as total_potongan
                FROM checkin
                INNER JOIN checkout ON checkout.idcheckin = checkin.idcheckin
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                AND reservasi.status != 'checkin'
                GROUP BY DATE(checkin.created_at)
            ) checkout_data ON dates.tanggal = checkout_data.tanggal
            WHERE (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) > 0
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

  
    public function viewallLaporanPendapatanTahun()
    {
        $tahun = $this->request->getPost('tahun');
        
        $db = db_connect();
        
        // Query dengan logika pendapatan yang benar:
        // Pendapatan Checkin = DP + Sisa Bayar
        // Pendapatan Checkout = Potongan (hanya jika ada transaksi checkout)
        // Total = Pendapatan Checkin + Pendapatan Checkout
        $pendapatanPerBulan = $db->query("
            SELECT 
                bulan_data.bulan,
                (COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) as total_checkin_bulan,
                COALESCE(checkout_data.total_potongan_bulan, 0) as total_checkout_bulan,
                ((COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) + COALESCE(checkout_data.total_potongan_bulan, 0)) as total_bersih_bulan
            FROM (
                SELECT DISTINCT MONTH(created_at) as bulan FROM checkin WHERE YEAR(created_at) = ?
            ) bulan_data
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(checkin.sisabayar) as total_sisabayar_bulan
                FROM checkin 
                WHERE YEAR(checkin.created_at) = ?
                GROUP BY MONTH(checkin.created_at)
            ) checkin_data ON bulan_data.bulan = checkin_data.bulan
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(reservasi.totalbayar) as total_dp_bulan
                FROM checkin 
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE YEAR(checkin.created_at) = ?
                GROUP BY MONTH(checkin.created_at)
            ) reservasi_data ON bulan_data.bulan = reservasi_data.bulan
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(COALESCE(checkout.potongan, 0)) as total_potongan_bulan
                FROM checkin
                INNER JOIN checkout ON checkout.idcheckin = checkin.idcheckin
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE YEAR(checkin.created_at) = ?
                AND reservasi.status != 'checkin'
                GROUP BY MONTH(checkin.created_at)
            ) checkout_data ON bulan_data.bulan = checkout_data.bulan
            WHERE (COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) > 0
            ORDER BY bulan_data.bulan ASC
        ", [$tahun, $tahun, $tahun, $tahun])->getResultArray();
        
        $data = [
            'pendapatanPerBulan' => $pendapatanPerBulan,
            'tahun' => $tahun,
            'isLaporanTahun' => true
        ];
        $response = [
            'data' => view('laporan/pendapatan/viewpendapatan', $data),
        ];

        echo json_encode($response);
    }
}
