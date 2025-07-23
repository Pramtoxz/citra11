<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PasienDashboardController extends BaseController
{
    public function __construct()
    {
        // Memastikan user sudah login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu');
            return redirect()->to('auth')->send();
        }
    }
    
    public function index()
    {
        // Dapatkan data pasien berdasarkan user ID
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        // Hitung total booking
        $totalBooking = $db->table('booking')
            ->where('id_pasien', $pasien['id_pasien'])
            ->where('deleted_at IS NULL')
            ->countAllResults();
        
        // Hitung booking dengan status diproses
        $bookingDiproses = $db->table('booking')
            ->where('id_pasien', $pasien['id_pasien'])
            ->where('status', 'diproses')
            ->where('deleted_at IS NULL')
            ->countAllResults();
        
        // Hitung booking dengan status diterima
        $bookingDiterima = $db->table('booking')
            ->where('id_pasien', $pasien['id_pasien'])
            ->where('status', 'diterima')
            ->where('deleted_at IS NULL')
            ->countAllResults();
        
        // Ambil 5 booking terakhir
        $recentBookings = $db->table('booking')
            ->select('booking.*, dokter.nama as nama_dokter, jenis_perawatan.namajenis')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.id_pasien', $pasien['id_pasien'])
            ->where('booking.deleted_at IS NULL')
            ->orderBy('booking.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        $data = [
            'pasien' => $pasien,
            'totalBooking' => $totalBooking,
            'bookingDiproses' => $bookingDiproses,
            'bookingDiterima' => $bookingDiterima,
            'recentBookings' => $recentBookings,
            'title' => 'Dashboard Pasien'
        ];
        
        return view('pasien/dashboard', $data);
    }
    
    public function histori()
    {
        // Dapatkan data pasien berdasarkan user ID
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        // Ambil semua booking
        $bookings = $db->table('booking')
            ->select('booking.*, dokter.nama as nama_dokter, jenis_perawatan.namajenis, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.id_pasien', $pasien['id_pasien'])
            ->where('booking.deleted_at IS NULL')
            ->orderBy('booking.created_at', 'DESC')
            ->get()
            ->getResultArray();
        
        $data = [
            'pasien' => $pasien,
            'bookings' => $bookings,
            'title' => 'Histori Booking'
        ];
        
        return view('pasien/histori', $data);
    }
    
    public function editProfil()
    {
        // Dapatkan data pasien berdasarkan user ID
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        $data = [
            'pasien' => $pasien,
            'title' => 'Edit Profil'
        ];
        
        return view('pasien/edit_profil', $data);
    }
    
    public function updateProfil()
    {
        // Dapatkan data pasien berdasarkan user ID
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required',
            'jenkel' => 'required',
            'tgllahir' => 'required|valid_date',
            'nohp' => 'required',
            'alamat' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Update data pasien
        $pasienModel = new \App\Models\Pasien();
        $updateData = [
            'nama' => $this->request->getPost('nama'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'nohp' => $this->request->getPost('nohp'),
            'alamat' => $this->request->getPost('alamat'),
        ];
        
        // Handle foto profil jika diupload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Generate nama file unik
            $newName = 'foto-' . date('Ymd') . '-' . $pasien['id_pasien'] . '.' . $foto->getClientExtension();
            
            // Pindahkan file
            $foto->move('assets/img/pasien', $newName);
            
            // Hapus foto lama jika ada
            if (!empty($pasien['foto']) && file_exists('assets/img/pasien/' . $pasien['foto'])) {
                unlink('assets/img/pasien/' . $pasien['foto']);
            }
            
            // Update nama foto di database
            $updateData['foto'] = $newName;
        }
        
        $pasienModel->update($pasien['id_pasien'], $updateData);
        
        return redirect()->to('pasien/dashboard')->with('success', 'Profil berhasil diperbarui');
    }
    
    public function detailBooking($idbooking)
    {
        // Dapatkan data pasien berdasarkan user ID
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        // Ambil data booking
        $booking = $db->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $idbooking)
            ->where('booking.id_pasien', $pasien['id_pasien']) // Pastikan booking milik pasien ini
            ->get()
            ->getRowArray();
            
        if (!$booking) {
            return redirect()->to('pasien/histori')->with('error', 'Data booking tidak ditemukan');
        }
        
        // Buat QR Code untuk check-in
        $qrCode = new \Endroid\QrCode\QrCode($idbooking);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();
        
        $data = [
            'pasien' => $pasien,
            'booking' => $booking,
            'qrCodeImage' => $qrCodeImage,
            'faktur_id' => 'INV-'.date('Ymd', strtotime($booking['created_at'])).'-'.$idbooking,
            'title' => 'Detail Booking'
        ];
        
        return view('pasien/detail_booking', $data);
    }
} 