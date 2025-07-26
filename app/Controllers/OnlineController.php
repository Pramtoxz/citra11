<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Tamu;

class OnlineController extends BaseController
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
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('auth'))->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Pastikan user role adalah 'user'
        if (session()->get('role') !== 'user') {
            return redirect()->to(site_url('admin'));
        }
        
        // Trigger auto-cleanup expired bookings
        $this->autoCheckExpiredBookings();
        
        // Ambil data tamu berdasarkan user ID menggunakan model
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        
        if (!$tamuData) {
            // Jika belum ada data tamu, redirect ke form lengkapi data
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil semua data kamar menggunakan model
        $allKamar = $this->kamarModel->findAll();
        $totalKamar = count($allKamar);
        
        // Ambil data kamar tersedia (tidak sedang dibook hari ini)
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        
        $kamarTersedia = 0;
        foreach ($allKamar as $kamar) {
            // Cek apakah kamar sedang dibook hari ini
            $activeBooking = $this->reservasiModel
                ->where('idkamar', $kamar['id_kamar'])
                ->where('status', 'diterima')
                ->where('tglcheckin <=', $tomorrow)
                ->where('tglcheckout >', $today)
                ->first();
            
            if (!$activeBooking) {
                $kamarTersedia++;
            }
        }
        
        // Ambil reservasi user ini dengan join data kamar menggunakan model
        $reservasiUser = $this->reservasiModel
            ->select('reservasi.*, kamar.nama as nama_kamar, kamar.harga')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.nik', $tamuData['nik'])
            ->orderBy('reservasi.created_at', 'DESC')
            ->limit(10)
            ->findAll();
        
        // Hitung statistik reservasi user
        $totalBooking = count($reservasiUser);
        $activeBooking = 0;
        $completedBooking = 0;
        $pendingBooking = 0;
        
        foreach ($reservasiUser as $reservasi) {
            switch ($reservasi['status']) {
                case 'diterima':
                    $activeBooking++;
                    break;
                case 'selesai':
                    $completedBooking++;
                    break;
                case 'menunggu':
                    $pendingBooking++;
                    break;
            }
        }
        
        // Ambil reservasi terbaru untuk quick info
        $reservasiTerbaru = !empty($reservasiUser) ? $reservasiUser[0] : null;
        
        $data = [
            'tamu' => $tamuData,
            'total_kamar' => $totalKamar,
            'kamar_tersedia' => $kamarTersedia,
            'reservasi_user' => $reservasiUser,
            'total_booking' => $totalBooking,
            'active_booking' => $activeBooking,
            'completed_booking' => $completedBooking,
            'pending_booking' => $pendingBooking,
            'reservasi_terbaru' => $reservasiTerbaru,
            'all_kamar' => $allKamar
        ];
        
        return view('online/dashboard', $data);
    }
    
    public function lengkapiData()
    {
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(site_url('auth'))->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Pastikan user role adalah 'user'
        if (session()->get('role') !== 'user') {
            return redirect()->to(site_url('admin'));
        }
        
        // Cek apakah user sudah punya data tamu menggunakan model
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        
        if ($tamuData) {
            // Jika sudah ada data tamu, redirect ke homepage
            return redirect()->to(site_url('online'));
        }
        
        // Tampilkan form lengkapi data tamu
        return view('online/lengkapi-data');
    }
    
    public function simpanDataTamu()
    {
        // Validasi login
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        // Validasi input
        $rules = [
            'nik' => 'required|min_length[16]|max_length[16]|numeric|is_unique[tamu.nik]',
            'nama' => 'required|min_length[3]|max_length[50]',
            'alamat' => 'required|min_length[10]',
            'nohp' => 'required|min_length[10]|max_length[15]',
            'jk' => 'required|in_list[L,P]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        try {
            // Cek apakah user sudah punya data tamu menggunakan model
            $existingTamu = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
            
            if ($existingTamu) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tamu sudah ada'
                ]);
            }
            
            // Insert data tamu menggunakan model
            $tamuData = [
                'nik' => $this->request->getPost('nik'),
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'nohp' => $this->request->getPost('nohp'),
                'jk' => $this->request->getPost('jk'),
                'iduser' => session()->get('user_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->tamuModel->insert($tamuData);
            
            // Update session name
            session()->set('name', $tamuData['nama']);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data tamu berhasil disimpan',
                'redirect' => site_url('online')
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Booking form - tampilkan form untuk booking kamar
     */
    public function booking()
    {
        // Pastikan user sudah login dan memiliki data tamu
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil semua kamar dengan informasi lengkap
        $allKamar = $this->kamarModel->findAll();
        
        // Format data kamar untuk JavaScript
        $kamarFormatted = [];
        foreach ($allKamar as $kamar) {
            $kamarFormatted[] = [
                'id' => $kamar['id_kamar'],
                'nama' => $kamar['nama'],
                'harga' => (int)$kamar['harga'],
                'cover' => !empty($kamar['cover']) ? base_url('assets/img/kamar/' . urlencode($kamar['cover'])) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=500&h=300',
                'deskripsi' => $kamar['deskripsi'] ?? 'Kamar nyaman dengan fasilitas modern',
                'dp' => (int)($kamar['dp'] ?? 0)
            ];
        }
        
        $data = [
            'tamu' => $tamuData,
            'kamar_list' => $allKamar,
            'kamar_json' => json_encode($kamarFormatted)
        ];
        
        return view('online/booking', $data);
    }
    
    /**
     * Simpan booking baru
     */
    public function saveBooking()
    {
        // Validasi login
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        // Ambil data tamu dengan validasi lengkap
        $userId = session()->get('user_id');
        log_message('info', 'OnlineController::saveBooking - Processing for user_id: ' . $userId);
        
        $tamuData = $this->tamuModel->where('iduser', $userId)->first();
        if (!$tamuData) {
            log_message('error', 'OnlineController::saveBooking - Tamu data not found for user_id: ' . $userId);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak ditemukan. Silakan lengkapi data terlebih dahulu.'
            ]);
        }
        
        // Validasi kelengkapan data tamu
        if (empty($tamuData['nik']) || empty($tamuData['nama'])) {
            log_message('error', 'OnlineController::saveBooking - Incomplete tamu data: ' . json_encode($tamuData));
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak lengkap. Silakan lengkapi NIK dan nama terlebih dahulu.'
            ]);
        }
        
        // Get JSON input data
        $input = json_decode($this->request->getBody(), true);
        
        if (!$input) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ]);
        }
        
        // Validasi input
        $rules = [
            'checkin_date' => 'required',
            'checkout_date' => 'required',
            'room_id' => 'required',
            'tipe_bayar' => 'required|in_list[dp,lunas]',
            'total_price' => 'required|integer|greater_than[0]',
            'is_dp' => 'integer|in_list[0,1]'
        ];
        
        if (!$this->validate($rules, $input)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        try {
            // Validasi tanggal
            $checkinDate = $input['checkin_date'];
            $checkoutDate = $input['checkout_date'];
            
            if (strtotime($checkinDate) >= strtotime($checkoutDate)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Tanggal checkout harus setelah tanggal checkin'
                ]);
            }
            
            // Cek ketersediaan kamar
            $roomId = $input['room_id'];
            
            // Log untuk debugging
            log_message('info', 'OnlineController: Checking room availability for roomId=' . $roomId . 
                ', checkin=' . $checkinDate . ', checkout=' . $checkoutDate);
            
            // Logika: bentrok jika ada overlap waktu menginap
            $conflictBooking = $this->reservasiModel
                ->where('idkamar', $roomId)
                ->where('status !=', 'ditolak')      // Perbaikan: menggunakan 'ditolak' bukan 'dibatalkan'
                ->where('status !=', 'cancel')       // Tambahkan status cancel
                ->where('status !=', 'selesai')
                ->where('status !=', 'limit')        // Tambahkan status limit (expired)
                ->groupStart()
                    ->where("tglcheckin < '$checkoutDate'")
                    ->where("tglcheckout > '$checkinDate'")
                ->groupEnd()
                ->findAll();
            
            // Log hasil pencarian
            log_message('info', 'OnlineController: Found conflicts: ' . json_encode($conflictBooking));
            
            if (!empty($conflictBooking)) {
                log_message('warning', 'OnlineController: Room ' . $roomId . ' not available for dates ' . 
                    $checkinDate . ' to ' . $checkoutDate);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kamar tidak tersedia pada tanggal yang dipilih'
                ]);
            }
            
            // Generate ID booking baru menggunakan helper method
            $newBookingId = $this->generateBookingId();
            
            // Ambil data kamar dan validasi
            $kamarData = $this->kamarModel->find($roomId);
            if (!$kamarData) {
                log_message('error', 'OnlineController::saveBooking - Kamar not found: ' . $roomId);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data kamar tidak ditemukan'
                ]);
            }
            
            // Validasi kelengkapan data kamar
            if (empty($kamarData['id_kamar']) || empty($kamarData['nama']) || empty($kamarData['harga'])) {
                log_message('error', 'OnlineController::saveBooking - Incomplete kamar data: ' . json_encode($kamarData));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data kamar tidak lengkap'
                ]);
            }
            
            $tipeBayar = $input['tipe_bayar'];
            $totalPrice = $input['total_price'];
            $isDp = $input['is_dp'] ?? 0;
            
            // Validasi pembayaran DP
            if ($tipeBayar === 'dp' && $isDp && $kamarData['dp'] > 0) {
                if ($totalPrice != $kamarData['dp']) {
                    log_message('warning', 'OnlineController: Invalid DP amount: ' . $totalPrice . ' != ' . $kamarData['dp']);
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Jumlah DP tidak sesuai dengan ketentuan kamar'
                    ]);
                }
            }
            
            // Periksa sekali lagi ketersediaan kamar sebelum menyimpan
            $lastMinuteCheck = $this->reservasiModel
                ->where('idkamar', $roomId)
                ->where('status !=', 'ditolak')
                ->where('status !=', 'cancel')
                ->where('status !=', 'selesai')
                ->where('status !=', 'limit')
                ->groupStart()
                    ->where("tglcheckin < '$checkoutDate'")
                    ->where("tglcheckout > '$checkinDate'")
                ->groupEnd()
                ->countAllResults();
                
            if ($lastMinuteCheck > 0) {
                log_message('warning', 'OnlineController: Last minute conflict detected for room ' . $roomId);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Maaf, kamar baru saja dipesan oleh orang lain. Silakan pilih kamar lain.'
                ]);
            }
            
            // Validasi data sebelum insert
            log_message('info', 'OnlineController: Pre-insert validation - tamuData: ' . json_encode($tamuData));
            log_message('info', 'OnlineController: Pre-insert validation - kamarData: ' . json_encode($kamarData));
            
            // Validasi panjang field sesuai database constraint
            if (strlen($newBookingId) > 30) {
                throw new \Exception('ID booking terlalu panjang: ' . $newBookingId);
            }
            if (strlen($tamuData['nik']) > 30) {
                throw new \Exception('NIK terlalu panjang: ' . $tamuData['nik']);
            }
            if (strlen($roomId) > 30) {
                throw new \Exception('ID kamar terlalu panjang: ' . $roomId);
            }
            if (strlen($tipeBayar) > 255) {
                throw new \Exception('Tipe bayar terlalu panjang: ' . $tipeBayar);
            }
            
            // Validasi format tanggal
            if (!strtotime($checkinDate) || !strtotime($checkoutDate)) {
                throw new \Exception('Format tanggal tidak valid: checkin=' . $checkinDate . ', checkout=' . $checkoutDate);
            }
            
            // Validasi status enum
            $validStatuses = ['diproses', 'diterima', 'ditolak', 'checkin', 'selesai', 'cancel', 'limit'];
            if (!in_array('diproses', $validStatuses)) {
                throw new \Exception('Status tidak valid: diproses');
            }
            
            // Data reservasi
            $reservasiData = [
                'idbooking' => $newBookingId,
                'nik' => trim($tamuData['nik']),
                'idkamar' => trim($roomId),
                'tglcheckin' => $checkinDate,
                'tglcheckout' => $checkoutDate,
                'totalbayar' => (float)$totalPrice,
                'tipe' => trim($tipeBayar),
                'status' => 'diproses', // Status awal untuk booking online
                'online' => 1,
                'batas_waktu' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Log untuk debugging dengan detail lengkap
            log_message('info', 'OnlineController: Saving booking with data: ' . json_encode($reservasiData));
            log_message('info', 'OnlineController: Data types check - ' . json_encode([
                'idbooking' => gettype($reservasiData['idbooking']) . ' (' . strlen($reservasiData['idbooking']) . ' chars)',
                'nik' => gettype($reservasiData['nik']) . ' (' . strlen($reservasiData['nik']) . ' chars)',
                'idkamar' => gettype($reservasiData['idkamar']) . ' (' . strlen($reservasiData['idkamar']) . ' chars)',
                'tglcheckin' => gettype($reservasiData['tglcheckin']),
                'tglcheckout' => gettype($reservasiData['tglcheckout']),
                'totalbayar' => gettype($reservasiData['totalbayar']),
                'tipe' => gettype($reservasiData['tipe']) . ' (' . strlen($reservasiData['tipe']) . ' chars)',
                'status' => gettype($reservasiData['status']),
                'online' => gettype($reservasiData['online']),
                'batas_waktu' => gettype($reservasiData['batas_waktu'])
            ]));
            
            // Gunakan transaction untuk keamanan
            $db = db_connect();
            $db->transBegin();
            
            try {
                // Cek apakah ID booking sudah ada (untuk menghindari duplicate key error)
                $existingBooking = $this->reservasiModel->find($newBookingId);
                if ($existingBooking) {
                    $db->transRollback();
                    log_message('error', 'OnlineController: Duplicate booking ID: ' . $newBookingId);
                    throw new \Exception('ID booking sudah ada: ' . $newBookingId);
                }
                
                log_message('info', 'OnlineController: No existing booking found, proceeding with insert...');
                
                // Langsung gunakan query builder karena model insert tampaknya bermasalah
                log_message('info', 'OnlineController: Using query builder insert instead of model...');
                
                // Insert menggunakan query builder
                $insertResult = $db->table('reservasi')->insert($reservasiData);
                log_message('info', 'OnlineController: Query builder insert result: ' . ($insertResult ? 'TRUE' : 'FALSE'));
                
                if ($insertResult) {
                    // Verifikasi data tersimpan dengan benar
                    $savedBooking = $db->table('reservasi')->where('idbooking', $newBookingId)->get()->getRowArray();
                    
                    if ($savedBooking) {
                        log_message('info', 'OnlineController: Insert SUCCESS, saved data: ' . json_encode($savedBooking));
                        $db->transCommit();
                    } else {
                        $db->transRollback();
                        log_message('error', 'OnlineController: Insert result TRUE but data not found in DB');
                        throw new \Exception('Data tidak ditemukan setelah insert berhasil');
                    }
                } else {
                    $db->transRollback();
                    
                    // Ambil error dari database
                    $dbErrors = $db->error();
                    log_message('error', 'OnlineController: Query builder insert FAILED, DB errors: ' . json_encode($dbErrors));
                    
                    throw new \Exception('Query builder insert gagal - DB errors: ' . json_encode($dbErrors));
                }
                
                // Verifikasi data tersimpan dengan benar
                $savedBooking = $this->reservasiModel->find($newBookingId);
                
                if (!$savedBooking) {
                    $db->transRollback();
                    log_message('error', 'OnlineController: Booking verification failed - record not found');
                    throw new \Exception('Data booking tidak ditemukan setelah penyimpanan');
                }
                
                log_message('info', 'OnlineController: Saved booking verification: ' . json_encode($savedBooking));
                $db->transCommit();
                
                // Tambahan log untuk memastikan status tersimpan dengan benar
                $finalCheck = $this->reservasiModel->find($newBookingId);
                log_message('info', 'OnlineController: Final booking check: ' . json_encode([
                    'id' => $finalCheck['idbooking'],
                    'status' => $finalCheck['status'],
                    'online' => $finalCheck['online'],
                    'batas_waktu' => $finalCheck['batas_waktu']
                ]));
                
            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', 'OnlineController: Transaction error: ' . $e->getMessage());
                throw new \Exception('Gagal menyimpan booking: ' . $e->getMessage());
            }
            
            // Simpan info DP ke session jika booking menggunakan DP
            if ($tipeBayar === 'dp' && $isDp) {
                $sisaBayar = $input['sisa_bayar'] ?? 0;
                session()->set('reservasi_'.$newBookingId.'_dp', $totalPrice);
                session()->set('reservasi_'.$newBookingId.'_sisabayar', $sisaBayar);
                log_message('info', 'OnlineController: Saved DP info to session for booking ' . $newBookingId);
            }
            
            log_message('info', 'OnlineController: Booking success: ' . $newBookingId);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Booking berhasil disimpan',
                'booking_id' => $newBookingId,
                'payment_type' => $tipeBayar,
                'total_price' => $totalPrice,
                'data' => $reservasiData
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'OnlineController: Exception in saveBooking: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan booking: ' . $e->getMessage(),
                'debug_info' => ENVIRONMENT !== 'production' ? [
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString()
                ] : null
            ]);
        }
    }
    
    /**
     * History booking user
     */
    public function bookingHistory()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil semua reservasi user dengan pagination
        $reservasiUser = $this->reservasiModel
            ->select('reservasi.*, kamar.nama as nama_kamar, kamar.harga, kamar.cover')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.nik', $tamuData['nik'])
            ->orderBy('reservasi.created_at', 'DESC')
            ->findAll();
        
        $data = [
            'tamu' => $tamuData,
            'reservasi_list' => $reservasiUser
        ];
        
        return view('online/booking_history', $data);
    }
    
    /**
     * Detail booking
     */
    public function bookingDetail($idbooking)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil detail reservasi dengan join kamar
        $reservasi = $this->reservasiModel
            ->select('reservasi.*, kamar.nama as nama_kamar, kamar.harga, kamar.cover, kamar.deskripsi')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.idbooking', $idbooking)
            ->where('reservasi.nik', $tamuData['nik']) // Pastikan user hanya bisa lihat booking sendiri
            ->first();
        
        if (!$reservasi) {
            return redirect()->to(site_url('online/booking/history'))->with('error', 'Booking tidak ditemukan');
        }
        
        $data = [
            'tamu' => $tamuData,
            'reservasi' => $reservasi
        ];
        
        return view('online/booking_detail', $data);
    }
    
    /**
     * Lihat faktur booking (hanya untuk status diterima)
     */
    public function bookingFaktur($idbooking)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil detail reservasi dengan join kamar
        $reservasi = $this->reservasiModel
            ->select('reservasi.*, kamar.nama as nama_kamar, kamar.harga, kamar.cover, kamar.deskripsi')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.idbooking', $idbooking)
            ->where('reservasi.nik', $tamuData['nik']) // Pastikan user hanya bisa lihat booking sendiri
            ->first();
        
        if (!$reservasi) {
            return redirect()->to(site_url('online/booking/history'))->with('error', 'Booking tidak ditemukan');
        }
        
        // Cek apakah status sudah diterima
        if ($reservasi['status'] !== 'diterima') {
            return redirect()->to(site_url('online/booking/detail/' . $idbooking))
                ->with('error', 'Faktur hanya tersedia untuk booking yang sudah diterima');
        }
        
        // Ambil data kamar lengkap
        $kamar = $this->kamarModel->find($reservasi['idkamar']);
        
        // Ambil email dari users table
        $userModel = new \App\Models\UserModel();
        $userData = $userModel->find($tamuData['iduser']);
        $tamuData['email'] = $userData['email'] ?? 'Tidak tersedia';
        
        $data = [
            'tamu' => $tamuData,
            'reservasi' => $reservasi,
            'kamar' => $kamar
        ];
        
        return view('online/faktur', $data);
    }
    
    /**
     * Cancel booking
     */
    public function cancelBooking($idbooking)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        try {
            // Cek apakah booking milik user ini dan masih bisa dibatalkan
            $reservasi = $this->reservasiModel
                ->where('idbooking', $idbooking)
                ->where('nik', $tamuData['nik'])
                ->where('status', 'menunggu') // Hanya bisa cancel yang masih menunggu
                ->first();
            
            if (!$reservasi) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Booking tidak ditemukan atau tidak dapat dibatalkan'
                ]);
            }
            
            // Update status menjadi dibatalkan
            $this->reservasiModel->update($idbooking, [
                'status' => 'dibatalkan',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Booking berhasil dibatalkan'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal membatalkan booking: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Profile user
     */
    public function profile()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        $data = [
            'tamu' => $tamuData
        ];
        
        return view('online/profile', $data);
    }
    
    /**
     * Update profile user
     */
    public function updateProfile()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required|min_length[3]|max_length[50]',
            'alamat' => 'required|min_length[10]',
            'nohp' => 'required|min_length[10]|max_length[15]',
            'jk' => 'required|in_list[L,P]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        try {
            // Update data tamu
            $updateData = [
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'nohp' => $this->request->getPost('nohp'),
                'jk' => $this->request->getPost('jk'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->tamuModel->update($tamuData['nik'], $updateData);
            
            // Update session name jika nama berubah
            session()->set('name', $updateData['nama']);
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal update profile: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Get profile data untuk modal edit
     */
    public function getProfile()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }

        try {
            // Ambil data tamu
            $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
            if (!$tamuData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tamu tidak ditemukan'
                ]);
            }

            // Ambil data user untuk email
            $userModel = new \App\Models\UserModel();
            $userData = $userModel->find(session()->get('user_id'));
            if (!$userData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data user tidak ditemukan'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'tamu' => $tamuData,
                    'user' => [
                        'email' => $userData['email'],
                        'username' => $userData['username']
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengambil data profile: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update profile lengkap (tamu + user)
     */
    public function updateProfileComplete()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }

        try {
            $db = \Config\Database::connect();
            $db->transBegin();

            // Ambil data tamu dan user
            $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
            if (!$tamuData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tamu tidak ditemukan'
                ]);
            }

            $userModel = new \App\Models\UserModel();
            $userData = $userModel->find(session()->get('user_id'));
            if (!$userData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data user tidak ditemukan'
                ]);
            }

            // Validasi input
            $rules = [
                'nama' => 'required|min_length[3]|max_length[50]',
                'alamat' => 'required|min_length[10]',
                'nohp' => 'required|min_length[10]|max_length[15]',
                'jk' => 'required|in_list[L,P]',
                'email' => 'required|valid_email'
            ];

            // Validasi password jika diisi
            $newPassword = $this->request->getPost('password');
            if (!empty($newPassword)) {
                $rules['password'] = 'min_length[6]';
                $rules['confirm_password'] = 'matches[password]';
            }

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak valid',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Cek apakah email sudah digunakan user lain
            $emailCheck = $userModel->where('email', $this->request->getPost('email'))
                                   ->where('id !=', session()->get('user_id'))
                                   ->first();
            if ($emailCheck) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Email sudah digunakan oleh user lain'
                ]);
            }

            // Update data tamu
            $updateTamuData = [
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'nohp' => $this->request->getPost('nohp'),
                'jk' => $this->request->getPost('jk'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->tamuModel->update($tamuData['nik'], $updateTamuData);

            // Update data user
            $updateUserData = [
                'email' => $this->request->getPost('email'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update password jika diisi
            if (!empty($newPassword)) {
                $updateUserData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $userModel->update(session()->get('user_id'), $updateUserData);

            // Update session data
            session()->set([
                'name' => $updateTamuData['nama'],
                'email' => $updateUserData['email']
            ]);

            $db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile berhasil diupdate'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal update profile: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Generate ID booking otomatis (konsisten dengan admin)
     */
    private function generateBookingId($debugDate = null)
    {
        if (!empty($debugDate) && ENVIRONMENT !== 'production') {
            $today = date('Ymd', strtotime($debugDate));
        } else {
            $today = date('Ymd');
        }
        
        $prefix = "RS-$today-";
        
        // Query untuk mencari ID booking dengan prefix hari ini
        $db = db_connect();
        $query = $db->query("SELECT idbooking FROM reservasi WHERE idbooking LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();
        
        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idbooking'], strlen($prefix));
                if (is_numeric($num)) {
                    $numbers[] = (int)$num;
                }
            }
            
            if (!empty($numbers)) {
                $nextNo = max($numbers) + 1;
            } else {
                $nextNo = 1;
            }
        }
        
        return $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Cek ketersediaan kamar berdasarkan tanggal
     */
    public function checkAvailability()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        $checkinDate = $this->request->getGet('checkin_date');
        $checkoutDate = $this->request->getGet('checkout_date');
        
        if (!$checkinDate || !$checkoutDate) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tanggal checkin dan checkout harus diisi'
            ]);
        }
        
        if (strtotime($checkinDate) >= strtotime($checkoutDate)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tanggal checkout harus setelah tanggal checkin'
            ]);
        }
        
        try {
            // Ambil semua kamar
            $allKamar = $this->kamarModel->findAll();
            $availableRooms = [];
            
            foreach ($allKamar as $kamar) {
                // Cek apakah kamar ini bentrok dengan booking yang ada
                // Log untuk debugging
                log_message('info', 'OnlineController: Checking availability for room ' . $kamar['id_kamar'] . 
                    ' (' . $kamar['nama'] . ') for dates ' . $checkinDate . ' to ' . $checkoutDate);
                
                // Perbaikan: menggunakan status yang konsisten dan query yang benar
                $conflictBooking = $this->reservasiModel
                    ->where('idkamar', $kamar['id_kamar'])
                    ->where('status !=', 'ditolak')      // Perbaikan: menggunakan 'ditolak' bukan 'dibatalkan'
                    ->where('status !=', 'cancel')       // Tambahkan status cancel
                    ->where('status !=', 'selesai')
                    ->where('status !=', 'limit')        // Tambahkan status limit (expired)
                    ->groupStart()
                        ->where("tglcheckin < '$checkoutDate'")
                        ->where("tglcheckout > '$checkinDate'")
                    ->groupEnd()
                    ->first();
                
                // Log hasil
                if ($conflictBooking) {
                    log_message('info', 'OnlineController: Room ' . $kamar['id_kamar'] . ' is NOT available due to conflict with booking ' . $conflictBooking['idbooking']);
                }
                
                if (!$conflictBooking) {
                    $availableRooms[] = [
                        'id' => $kamar['id_kamar'],
                        'nama' => $kamar['nama'],
                        'harga' => (int)$kamar['harga'],
                        'cover' => !empty($kamar['cover']) ? base_url('assets/img/kamar/' . urlencode($kamar['cover'])) : 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=500&h=300',
                        'deskripsi' => $kamar['deskripsi'] ?? 'Kamar nyaman dengan fasilitas modern',
                        'dp' => (int)($kamar['dp'] ?? 0),
                        'status_kamar' => $kamar['status_kamar'] ?? 'tersedia'
                    ];
                }
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Berhasil mengecek ketersediaan kamar',
                'available_rooms' => $availableRooms,
                'total_available' => count($availableRooms)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengecek ketersediaan: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Halaman upload pembayaran
     */
    public function paymentUpload($idbooking)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return redirect()->to(site_url('auth'));
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return redirect()->to(site_url('online/lengkapi-data'));
        }
        
        // Ambil data reservasi dengan join kamar
        $reservasi = $this->reservasiModel
            ->select('reservasi.*, kamar.nama as nama_kamar, kamar.harga, kamar.cover, kamar.deskripsi')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.idbooking', $idbooking)
            ->where('reservasi.nik', $tamuData['nik']) // Pastikan user hanya bisa akses booking sendiri
            ->where('reservasi.online', 1) // Hanya booking online
            ->first();
        
        if (!$reservasi) {
            return redirect()->to(site_url('online/booking/history'))->with('error', 'Booking tidak ditemukan');
        }
        
        // Cek status - hanya bisa upload jika status diproses atau ditolak
        if (!in_array($reservasi['status'], ['diproses', 'ditolak'])) {
            return redirect()->to(site_url('online/booking/history'))->with('error', 'Upload pembayaran tidak tersedia untuk booking ini');
        }
        
        // Cek batas waktu untuk status diproses (booking baru)
        if ($reservasi['status'] === 'diproses') {
            $batasWaktu = strtotime($reservasi['batas_waktu']);
            $sekarang = time();
            
            if ($batasWaktu < $sekarang) {
                // Update status ke limit jika sudah expired
                $this->reservasiModel->update($idbooking, [
                    'status' => 'limit',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->to(site_url('online/booking/history'))->with('error', 'Waktu upload pembayaran telah habis');
            }
        }
        
        // Untuk status ditolak, berikan batas waktu baru 15 menit dari sekarang
        if ($reservasi['status'] === 'ditolak') {
            $batasWaktuBaru = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            $this->reservasiModel->update($idbooking, [
                'status' => 'diproses',
                'batas_waktu' => $batasWaktuBaru,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $reservasi['batas_waktu'] = $batasWaktuBaru;
            $reservasi['status'] = 'diproses';
        }
        
        $data = [
            'tamu' => $tamuData,
            'reservasi' => $reservasi
        ];
        
        return view('online/payment_upload', $data);
    }
    
    /**
     * Simpan bukti pembayaran
     */
    public function savePayment($idbooking)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        $tamuData = $this->tamuModel->where('iduser', session()->get('user_id'))->first();
        if (!$tamuData) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }
        
        // Log untuk debugging
        log_message('info', 'OnlineController::savePayment - Start upload for booking: ' . $idbooking);
        
        // Validasi file upload
        $rules = [
            'bukti_bayar' => [
                'label' => 'Bukti Pembayaran',
                'rules' => 'uploaded[bukti_bayar]|max_size[bukti_bayar,2048]|is_image[bukti_bayar]',
                'errors' => [
                    'uploaded' => 'File bukti pembayaran harus diupload',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'is_image' => 'File harus berupa gambar (JPG, PNG, GIF)'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            log_message('error', 'OnlineController::savePayment - Validation failed: ' . json_encode($this->validator->getErrors()));
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi file gagal',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        try {
            // Cek reservasi masih valid
            $reservasi = $this->reservasiModel
                ->where('idbooking', $idbooking)
                ->where('nik', $tamuData['nik'])
                ->where('online', 1)
                ->whereIn('status', ['diproses', 'ditolak']) // Allow both diproses and ditolak
                ->first();
            
            if (!$reservasi) {
                log_message('error', 'OnlineController::savePayment - Booking not found or invalid for: ' . $idbooking);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Booking tidak ditemukan atau tidak valid untuk upload'
                ]);
            }
            
            log_message('info', 'OnlineController::savePayment - Found booking: ' . json_encode($reservasi));
            
            // Cek batas waktu hanya untuk status diproses
            if ($reservasi['status'] === 'diproses' && !empty($reservasi['batas_waktu'])) {
                $batasWaktu = strtotime($reservasi['batas_waktu']);
                $sekarang = time();
                
                if ($batasWaktu < $sekarang) {
                    // Update status ke limit
                    $this->reservasiModel->update($idbooking, [
                        'status' => 'limit',
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    log_message('warning', 'OnlineController::savePayment - Upload time expired for: ' . $idbooking);
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Waktu upload pembayaran telah habis'
                    ]);
                }
            }
            
            // Upload file
            $file = $this->request->getFile('bukti_bayar');
            if ($file->isValid() && !$file->hasMoved()) {
                // Generate nama file unik
                $fileName = 'bukti-' . $idbooking . '-' . time() . '.' . $file->getExtension();
                
                // Path upload - ubah ke public/assets/img/bukti_bayar/ agar bisa diakses
                $uploadPath = FCPATH . 'assets/img/bukti_bayar/';
                
                log_message('info', 'OnlineController::savePayment - Upload path: ' . $uploadPath);
                log_message('info', 'OnlineController::savePayment - File name: ' . $fileName);
                
                // Buat folder jika belum ada
                if (!is_dir($uploadPath)) {
                    if (!mkdir($uploadPath, 0755, true)) {
                        log_message('error', 'OnlineController::savePayment - Failed to create upload directory: ' . $uploadPath);
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Gagal membuat folder upload'
                        ]);
                    }
                    log_message('info', 'OnlineController::savePayment - Created upload directory: ' . $uploadPath);
                }
                
                // Hapus file lama jika ada
                if (!empty($reservasi['buktibayar']) && file_exists($uploadPath . $reservasi['buktibayar'])) {
                    unlink($uploadPath . $reservasi['buktibayar']);
                    log_message('info', 'OnlineController::savePayment - Deleted old file: ' . $reservasi['buktibayar']);
                }
                
                // Move file ke folder upload
                if ($file->move($uploadPath, $fileName)) {
                    log_message('info', 'OnlineController::savePayment - File moved successfully to: ' . $uploadPath . $fileName);
                    
                    // Verifikasi file tersimpan
                    if (!file_exists($uploadPath . $fileName)) {
                        log_message('error', 'OnlineController::savePayment - File not found after move: ' . $uploadPath . $fileName);
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'File tidak ditemukan setelah upload'
                        ]);
                    }
                } else {
                    log_message('error', 'OnlineController::savePayment - Failed to move file: ' . $file->getErrorString());
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Gagal memindahkan file: ' . $file->getErrorString()
                    ]);
                }
                
                // Data untuk update
                $updateData = [
                    'buktibayar' => $fileName,
                    'tipe' => 'transfer',
                    'status' => 'diproses', // Tetap diproses, menunggu verifikasi admin
                    'batas_waktu' => null, // Clear batas waktu karena sudah upload
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                log_message('info', 'OnlineController::savePayment - Updating database with: ' . json_encode($updateData));
                
                // Gunakan database transaction untuk keamanan
                $db = db_connect();
                $db->transBegin();
                
                try {
                                    // Update database menggunakan query builder untuk debugging yang lebih baik
                $updateResult = $db->table('reservasi')
                    ->where('idbooking', $idbooking)
                    ->update($updateData);
                
                log_message('info', 'OnlineController::savePayment - Update result: ' . ($updateResult ? 'SUCCESS' : 'FAILED'));
                
                if ($updateResult) {
                    // Verifikasi update berhasil
                    $updatedReservasi = $db->table('reservasi')
                        ->where('idbooking', $idbooking)
                        ->get()
                        ->getRowArray();
                    
                    log_message('info', 'OnlineController::savePayment - Updated data verification: ' . json_encode([
                        'idbooking' => $updatedReservasi['idbooking'],
                        'buktibayar' => $updatedReservasi['buktibayar'],
                        'status' => $updatedReservasi['status'],
                        'batas_waktu' => $updatedReservasi['batas_waktu']
                    ]));
                    
                    if ($updatedReservasi['buktibayar'] === $fileName) {
                        $db->transCommit();
                        log_message('info', 'OnlineController::savePayment - Payment upload completed successfully for: ' . $idbooking);
                        
                        return $this->response->setJSON([
                            'status' => 'success',
                            'message' => 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.',
                            'redirect' => site_url('online/booking/history'),
                            'data' => [
                                'booking_id' => $idbooking,
                                'file_name' => $fileName,
                                'status' => 'diproses'
                            ]
                        ]);
                    } else {
                            $db->transRollback();
                            log_message('error', 'OnlineController::savePayment - Database update verification failed. Expected: ' . $fileName . ', Got: ' . $updatedReservasi['buktibayar']);
                            
                            // Hapus file yang sudah diupload karena database gagal
                            if (file_exists($uploadPath . $fileName)) {
                                unlink($uploadPath . $fileName);
                            }
                            
                            return $this->response->setJSON([
                                'status' => 'error',
                                'message' => 'Gagal memverifikasi update database'
                            ]);
                        }
                    } else {
                        $db->transRollback();
                        $dbError = $db->error();
                        log_message('error', 'OnlineController::savePayment - Database update failed: ' . json_encode($dbError));
                        
                        // Hapus file yang sudah diupload karena database gagal
                        if (file_exists($uploadPath . $fileName)) {
                            unlink($uploadPath . $fileName);
                        }
                        
                        return $this->response->setJSON([
                            'status' => 'error',
                            'message' => 'Gagal mengupdate database: ' . ($dbError['message'] ?? 'Unknown error')
                        ]);
                    }
                } catch (\Exception $dbException) {
                    $db->transRollback();
                    log_message('error', 'OnlineController::savePayment - Database transaction exception: ' . $dbException->getMessage());
                    
                    // Hapus file yang sudah diupload karena database gagal
                    if (file_exists($uploadPath . $fileName)) {
                        unlink($uploadPath . $fileName);
                    }
                    
                    throw $dbException;
                }
                
            } else {
                $errorMsg = $file->isValid() ? 'File sudah dipindahkan' : $file->getErrorString();
                log_message('error', 'OnlineController::savePayment - File upload failed: ' . $errorMsg);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal mengupload file: ' . $errorMsg
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'OnlineController::savePayment - Exception: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menyimpan bukti pembayaran: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Debug endpoint untuk testing ID generation (hanya untuk development)
     */
    public function debugNewId()
    {
        // Hanya tersedia di lingkungan non-production
        if (ENVIRONMENT === 'production') {
            return $this->response->setJSON([
                'error' => 'Debug tidak tersedia di environment production'
            ]);
        }
        
        if ($this->request->isAJAX()) {
            $debugDate = $this->request->getPost('debug_date');
            
            try {
                $newId = $this->generateBookingId($debugDate);
                
                return $this->response->setJSON([
                    'success' => true,
                    'new_id' => $newId,
                    'debug_date' => $debugDate
                ]);
                
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'error' => 'Gagal generate ID: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'error' => 'Metode tidak diizinkan'
        ]);
    }
    
    /**
     * API endpoint untuk mengambil tanggal-tanggal yang sudah terisi
     */
    public function getOccupiedDates()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'user') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
        }
        
        try {
            // Ambil semua reservasi yang active (tidak dibatalkan/ditolak/selesai)
            $occupiedReservations = $this->reservasiModel
                ->select('idkamar, tglcheckin, tglcheckout, status, nik, idbooking')
                ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
                ->select('kamar.nama as nama_kamar')
                ->where('status !=', 'ditolak')
                ->where('status !=', 'cancel')
                ->where('status !=', 'selesai')
                ->where('status !=', 'limit')
                ->where('tglcheckout >=', date('Y-m-d')) // Hanya ambil yang belum checkout
                ->findAll();
            
            // Format data untuk calendar
            $occupiedDates = [];
            
            foreach ($occupiedReservations as $reservation) {
                $checkinDate = new \DateTime($reservation['tglcheckin']);
                $checkoutDate = new \DateTime($reservation['tglcheckout']);
                
                // Generate semua tanggal dari checkin sampai checkout-1 (checkout tidak termasuk)
                $period = new \DatePeriod(
                    $checkinDate,
                    new \DateInterval('P1D'),
                    $checkoutDate
                );
                
                foreach ($period as $date) {
                    $dateStr = $date->format('Y-m-d');
                    
                    if (!isset($occupiedDates[$dateStr])) {
                        $occupiedDates[$dateStr] = [];
                    }
                    
                    $occupiedDates[$dateStr][] = [
                        'kamar_id' => $reservation['idkamar'],
                        'kamar_nama' => $reservation['nama_kamar'],
                        'booking_id' => $reservation['idbooking'],
                        'status' => $reservation['status'],
                        'checkin' => $reservation['tglcheckin'],
                        'checkout' => $reservation['tglcheckout']
                    ];
                }
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'occupied_dates' => $occupiedDates,
                'total_reservations' => count($occupiedReservations)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengambil data tanggal terisi: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Debug endpoint untuk testing database connection dan structure
     */
    public function debugDatabase()
    {
        // Hanya tersedia di lingkungan non-production
        if (ENVIRONMENT === 'production') {
            return $this->response->setJSON([
                'error' => 'Debug tidak tersedia di environment production'
            ]);
        }
        
        try {
            $db = db_connect();
            
            // Test koneksi
            $query = $db->query('SELECT 1 as test');
            $connectionTest = $query->getResultArray();
            
            // Test struktur tabel reservasi
            $fields = $db->getFieldData('reservasi');
            
            // Test sample data
            $sampleData = [
                'idbooking' => 'TEST-DEBUG-' . date('YmdHis'),
                'nik' => '1234567890',
                'idkamar' => 'KM0001',
                'tglcheckin' => date('Y-m-d'),
                'tglcheckout' => date('Y-m-d', strtotime('+1 day')),
                'totalbayar' => 100000,
                'tipe' => 'debug',
                'status' => 'diproses',
                'online' => 1,
                'batas_waktu' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
            ];
            
            // Test insert dengan transaction
            $db->transBegin();
            
            try {
                $insertResult = $db->table('reservasi')->insert($sampleData);
                $insertedData = $db->table('reservasi')->where('idbooking', $sampleData['idbooking'])->get()->getRowArray();
                
                // Test update buktibayar
                $updateData = ['buktibayar' => 'test-file.jpg', 'status' => 'menunggu'];
                $updateResult = $db->table('reservasi')->where('idbooking', $sampleData['idbooking'])->update($updateData);
                $updatedData = $db->table('reservasi')->where('idbooking', $sampleData['idbooking'])->get()->getRowArray();
                
                // Rollback karena ini hanya test
                $db->transRollback();
                
                return $this->response->setJSON([
                    'success' => true,
                    'connection_test' => $connectionTest,
                    'table_fields' => $fields,
                    'sample_data' => $sampleData,
                    'insert_result' => $insertResult,
                    'inserted_data' => $insertedData,
                    'update_data' => $updateData,
                    'update_result' => $updateResult,
                    'updated_data' => $updatedData,
                    'bukti_bayar_field_test' => [
                        'before_update' => $insertedData['buktibayar'] ?? 'NULL',
                        'after_update' => $updatedData['buktibayar'] ?? 'NULL',
                        'update_successful' => ($updatedData['buktibayar'] ?? null) === 'test-file.jpg'
                    ],
                    'message' => 'Database test berhasil (data tidak disimpan karena rollback)'
                ]);
                
            } catch (\Exception $insertError) {
                $db->transRollback();
                
                return $this->response->setJSON([
                    'success' => false,
                    'connection_test' => $connectionTest,
                    'table_fields' => $fields,
                    'sample_data' => $sampleData,
                    'insert_error' => $insertError->getMessage(),
                    'db_error' => $db->error(),
                    'message' => 'Insert test gagal'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Database connection test gagal'
            ]);
        }
    }
    
    /**
     * Debug endpoint khusus untuk testing update buktibayar
     */
    public function debugPaymentUpdate($idbooking = null)
    {
        // Hanya tersedia di lingkungan non-production
        if (ENVIRONMENT === 'production') {
            return $this->response->setJSON([
                'error' => 'Debug tidak tersedia di environment production'
            ]);
        }
        
        if (!$idbooking) {
            return $this->response->setJSON([
                'error' => 'ID booking diperlukan'
            ]);
        }
        
        try {
            $db = db_connect();
            
            // Ambil data booking sebelum update
            $beforeUpdate = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRowArray();
            
            if (!$beforeUpdate) {
                return $this->response->setJSON([
                    'error' => 'Booking tidak ditemukan: ' . $idbooking
                ]);
            }
            
            // Test update buktibayar
            $testFileName = 'debug-bukti-' . time() . '.jpg';
            $updateData = [
                'buktibayar' => $testFileName,
                'status' => 'menunggu',
                'batas_waktu' => null
            ];
            
            $db->transBegin();
            
            try {
                $updateResult = $db->table('reservasi')
                    ->where('idbooking', $idbooking)
                    ->update($updateData);
                
                $afterUpdate = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRowArray();
                
                // Rollback karena ini hanya test
                $db->transRollback();
                
                return $this->response->setJSON([
                    'success' => true,
                    'booking_id' => $idbooking,
                    'before_update' => [
                        'buktibayar' => $beforeUpdate['buktibayar'],
                        'status' => $beforeUpdate['status'],
                        'batas_waktu' => $beforeUpdate['batas_waktu']
                    ],
                    'update_data' => $updateData,
                    'update_result' => $updateResult,
                    'after_update' => [
                        'buktibayar' => $afterUpdate['buktibayar'],
                        'status' => $afterUpdate['status'],
                        'batas_waktu' => $afterUpdate['batas_waktu']
                    ],
                    'test_results' => [
                        'update_executed' => $updateResult,
                        'buktibayar_updated' => ($afterUpdate['buktibayar'] === $testFileName),
                        'status_updated' => ($afterUpdate['status'] === 'menunggu'),
                        'batas_waktu_cleared' => ($afterUpdate['batas_waktu'] === null)
                    ],
                    'message' => 'Test update berhasil (data tidak disimpan karena rollback)'
                ]);
                
            } catch (\Exception $updateError) {
                $db->transRollback();
                
                return $this->response->setJSON([
                    'success' => false,
                    'booking_id' => $idbooking,
                    'before_update' => $beforeUpdate,
                    'update_data' => $updateData,
                    'update_error' => $updateError->getMessage(),
                    'db_error' => $db->error(),
                    'message' => 'Test update gagal'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Test gagal'
            ]);
                 }
     }
     

 }  