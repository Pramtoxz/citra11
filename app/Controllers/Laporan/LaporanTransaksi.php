<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanTransaksi extends BaseController
{

    public function LaporanBooking()
    {
        $data['title'] = 'Laporan Booking';
        return view('laporan/booking/booking', $data);
    }


    public function viewallLaporanBooking()
    {
        $db = db_connect();
        $booking = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'booking' => $booking,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbooking', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBookingTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
           ->where('booking.created_at >=', $tglmulai)
            ->where('booking.created_at <=', $tglakhir)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbookingtanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBookingBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $db = db_connect();
        $query = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
            ->where('month(booking.created_at)', $bulan)
            ->where('year(booking.created_at)', $tahun)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbookingbulan', $data),
        ];

        echo json_encode($response);
    }
}
