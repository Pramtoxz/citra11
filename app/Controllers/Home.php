<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Tamu;

class Home extends BaseController
{
    protected $kamarModel;
    protected $reservasiModel;
    protected $tamuModel;
    
    public function __construct()
    {
        $this->kamarModel = new Kamar();
        $this->reservasiModel = new Reservasi();
        $this->tamuModel = new Tamu();
    }

    public function index()
    {
        // Trigger auto-cleanup expired bookings saat ada yang akses homepage
        $this->autoCheckExpiredBookings();
        
        // ✅ LOGIC REDIRECT YANG BENAR:
        if (session()->get('logged_in')) {
            $userRole = session()->get('role');
            
            if ($userRole === 'user') {
                // Cek apakah user sudah punya data tamu menggunakan model
                $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
                
                // HANYA redirect jika belum ada data tamu
                if (!$tamuData) {
                    return redirect()->to(site_url('online/lengkapi-data'));
                }
                // Jika sudah ada data tamu, lanjut tampilkan homepage (tidak redirect)
                
            } elseif ($userRole === 'admin' || $userRole === 'pimpinan') {
                // Admin/pimpinan bisa langsung ke dashboard atau tetap di homepage
                // Tidak perlu redirect paksa, biarkan mereka pilih
            }
        }
        
        // ✅ AMBIL DATA KAMAR DARI DATABASE menggunakan model
        $dataKamar = $this->kamarModel->findAll();
        
        // Hitung total kamar untuk statistik
        $totalKamar = count($dataKamar);
        $kamarTersedia = 0;
        
        // Cek ketersediaan kamar hari ini (logic sederhana)
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        
        foreach ($dataKamar as &$kamar) {
            // Cek apakah kamar ini sedang dibook hari ini menggunakan model
            $activeBooking = $this->reservasiModel
                ->where('idkamar', $kamar['id_kamar'])
                ->where('status', 'diterima')
                ->where('tglcheckin <=', $tomorrow)
                ->where('tglcheckout >', $today)
                ->first();
            
            $kamar['available'] = ($activeBooking === null);
            if ($kamar['available']) {
                $kamarTersedia++;
            }
        }
        
        // Ambil statistik tambahan untuk homepage
        $totalReservasi = $this->reservasiModel->countAll();
        $totalTamu = $this->tamuModel->countAll();
        
        // Hitung rating rata-rata (bisa ditambahkan logic rating nanti)
        $averageRating = '4.9';
        
        $data = [
            'kamar_list' => $dataKamar,
            'total_kamar' => $totalKamar,
            'kamar_tersedia' => $kamarTersedia,
            'total_reservasi' => $totalReservasi,
            'total_tamu' => $totalTamu,
            'stats' => [
                'total_kamar' => $totalKamar,
                'tersedia' => $kamarTersedia,
                'rating' => $averageRating,
                'total_reservasi' => $totalReservasi,
                'total_tamu' => $totalTamu
            ]
        ];
        
        // Jika belum login, tampilkan homepage landing page dengan data kamar
        return view('online/index', $data);
    }
}