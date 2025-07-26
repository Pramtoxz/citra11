<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Tamu;
use App\Models\Checkin;
use App\Models\Checkout;
use App\Models\Pengeluaran;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $kamarModel;
    protected $reservasiModel;
    protected $tamuModel;
    protected $checkinModel;
    protected $checkoutModel;
    protected $pengeluaranModel;
    
    public function __construct()
    {
        $this->kamarModel = new Kamar();
        $this->reservasiModel = new Reservasi();
        $this->tamuModel = new Tamu();
        $this->checkinModel = new Checkin();
        $this->checkoutModel = new Checkout();
        $this->pengeluaranModel = new Pengeluaran();
    }

    public function index()
    {
        // Pastikan user sudah login dan memiliki role admin/pimpinan
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth')->with('error', 'Silakan login terlebih dahulu');
        }
        
        $userRole = session()->get('role');
        if (!in_array($userRole, ['admin', 'pimpinan'])) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        // Auto-cleanup expired bookings
        $this->autoCheckExpiredBookings();

        // Statistik Utama
        $totalKamar = $this->kamarModel->countAllResults();
        $totalTamu = $this->tamuModel->countAllResults();
        $totalReservasi = $this->reservasiModel->countAllResults();
        $totalCheckin = $this->checkinModel->countAllResults();
        
        // Statistik Kamar
        $kamarTersedia = $this->getKamarTersedia();
        $kamarTerisi = $totalKamar - $kamarTersedia;
        
        // Statistik Reservasi Bulan Ini
        $reservasiBulanIni = $this->reservasiModel
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->countAllResults();
            
        // Statistik Pendapatan Bulan Ini
        $pendapatanBulanIni = $this->getPendapatanBulanIni();
        
        // Statistik Pengeluaran Bulan Ini (untuk admin)
        $pengeluaranBulanIni = 0;
        if ($userRole === 'admin') {
            $pengeluaranBulanIni = $this->getPengeluaranBulanIni();
        }
        
        // Data untuk chart - Reservasi 6 bulan terakhir
        $chartReservasi = $this->getChartReservasi();
        
        // Data untuk chart - Pendapatan vs Pengeluaran (untuk admin)
        $chartKeuangan = [];
        if ($userRole === 'admin') {
            $chartKeuangan = $this->getChartKeuangan();
        }
        
        // Data Reservasi Terbaru
        $reservasiTerbaru = $this->getReservasiTerbaru();
        
        // Data Check-in Hari Ini
        $checkinHariIni = $this->getCheckinHariIni();
        
        // Data Check-out Hari Ini
        $checkoutHariIni = $this->getCheckoutHariIni();
        
        // Status Kamar Detail
        $statusKamar = $this->getStatusKamarDetail();

        $data = [
            'user_role' => $userRole,
            'total_kamar' => $totalKamar,
            'total_tamu' => $totalTamu,
            'total_reservasi' => $totalReservasi,
            'total_checkin' => $totalCheckin,
            'kamar_tersedia' => $kamarTersedia,
            'kamar_terisi' => $kamarTerisi,
            'reservasi_bulan_ini' => $reservasiBulanIni,
            'pendapatan_bulan_ini' => $pendapatanBulanIni,
            'pengeluaran_bulan_ini' => $pengeluaranBulanIni,
            'chart_reservasi' => $chartReservasi,
            'chart_keuangan' => $chartKeuangan,
            'reservasi_terbaru' => $reservasiTerbaru,
            'checkin_hari_ini' => $checkinHariIni,
            'checkout_hari_ini' => $checkoutHariIni,
            'status_kamar' => $statusKamar
        ];

        return view('dashboard/index', $data);
    }
    
    private function getKamarTersedia()
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        
        // Ambil semua kamar
        $allKamar = $this->kamarModel->findAll();
        $tersedia = 0;
        
        foreach ($allKamar as $kamar) {
            // Cek apakah kamar sedang dibook/checkin
            $activeBooking = $this->reservasiModel
                ->where('idkamar', $kamar['id_kamar'])
                ->where('status', 'diterima')
                ->where('tglcheckin <=', $tomorrow)
                ->where('tglcheckout >', $today)
                ->first();
                
            if (!$activeBooking) {
                $tersedia++;
            }
        }
        
        return $tersedia;
    }
    
    private function getPendapatanBulanIni()
    {
        $pendapatan = $this->reservasiModel
            ->selectSum('totalbayar')
            ->where('status', 'selesai')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->first();
            
        return $pendapatan['totalbayar'] ?? 0;
    }
    
    private function getPengeluaranBulanIni()
    {
        $pengeluaran = $this->pengeluaranModel
            ->selectSum('total')
            ->where('MONTH(tgl)', date('m'))
            ->where('YEAR(tgl)', date('Y'))
            ->first();
            
        return $pengeluaran['total'] ?? 0;
    }
    
    private function getChartReservasi()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));
            
            $count = $this->reservasiModel
                ->where('MONTH(created_at)', $month)
                ->where('YEAR(created_at)', $year)
                ->countAllResults();
                
            $data[] = [
                'month' => $monthName,
                'count' => $count
            ];
        }
        
        return $data;
    }
    
    private function getChartKeuangan()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));
            
            $pendapatan = $this->reservasiModel
                ->selectSum('totalbayar')
                ->where('status', 'selesai')
                ->where('MONTH(created_at)', $month)
                ->where('YEAR(created_at)', $year)
                ->first();
                
            $pengeluaran = $this->pengeluaranModel
                ->selectSum('total')
                ->where('MONTH(tgl)', $month)
                ->where('YEAR(tgl)', $year)
                ->first();
                
            $data[] = [
                'month' => $monthName,
                'pendapatan' => $pendapatan['totalbayar'] ?? 0,
                'pengeluaran' => $pengeluaran['total'] ?? 0
            ];
        }
        
        return $data;
    }
    
    private function getReservasiTerbaru()
    {
        return $this->reservasiModel
            ->select('reservasi.*, tamu.nama as nama_tamu, kamar.nama as nama_kamar')
            ->join('tamu', 'tamu.nik = reservasi.nik')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar')
            ->orderBy('reservasi.created_at', 'DESC')
            ->limit(5)
            ->find();
    }
    
    private function getCheckinHariIni()
    {
        $today = date('Y-m-d');
        
        return $this->reservasiModel
            ->select('reservasi.*, tamu.nama as nama_tamu, kamar.nama as nama_kamar')
            ->join('tamu', 'tamu.nik = reservasi.nik')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar')
            ->where('DATE(reservasi.tglcheckin)', $today)
            ->where('reservasi.status', 'diterima')
            ->orderBy('reservasi.tglcheckin', 'ASC')
            ->find();
    }
    
    private function getCheckoutHariIni()
    {
        $today = date('Y-m-d');
        
        return $this->reservasiModel
            ->select('reservasi.*, tamu.nama as nama_tamu, kamar.nama as nama_kamar')
            ->join('tamu', 'tamu.nik = reservasi.nik')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar')
            ->where('DATE(reservasi.tglcheckout)', $today)
            ->where('reservasi.status', 'checkin')
            ->orderBy('reservasi.tglcheckout', 'ASC')
            ->find();
    }
    
    private function getStatusKamarDetail()
    {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        
        $kamarList = $this->kamarModel->findAll();
        $statusDetail = [];
        
        foreach ($kamarList as $kamar) {
            $activeBooking = $this->reservasiModel
                ->select('reservasi.*, tamu.nama as nama_tamu')
                ->join('tamu', 'tamu.nik = reservasi.nik')
                ->where('reservasi.idkamar', $kamar['id_kamar'])
                ->where('reservasi.status', 'diterima')
                ->where('reservasi.tglcheckin <=', $tomorrow)
                ->where('reservasi.tglcheckout >', $today)
                ->first();
                
            $status = 'Tersedia';
            $tamu = null;
            $checkout = null;
            
            if ($activeBooking) {
                $status = 'Terisi';
                $tamu = $activeBooking['nama_tamu'];
                $checkout = $activeBooking['tglcheckout'];
            }
            
            $statusDetail[] = [
                'kamar' => $kamar,
                'status' => $status,
                'tamu' => $tamu,
                'checkout' => $checkout
            ];
        }
        
        return $statusDetail;
    }
}