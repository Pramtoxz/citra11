<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanObat extends BaseController
{

    public function LaporanObat()
    {
        $data['title'] = 'Laporan Obat';
        return view('laporan/obat/obat', $data);
    }

    public function viewallLaporanObat()
    {
        $db = db_connect();
        $obat = $db
            ->table('obat')
            ->select('idobat, nama, stok, jenis')
            ->groupBy('obat.idobat, obat.nama, obat.stok, obat.jenis')
            ->get()
            ->getResultArray();
        $data = [
            'obat' => $obat,
        ];
        $response = [
            'data' => view('laporan/obat/viewallobat', $data),
        ];

        echo json_encode($response);
    }


    public function LaporanObatMasuk()
    {
        $data['title'] = 'Laporan Obat Masuk';
        return view('laporan/obat/obatmasuk', $data);
    }

    public function viewallLaporanObatMasuk()
    {
        $db = db_connect();
        $obat = $db
            ->table('obatmasuk')
            ->select('faktur, tglmasuk, idobat, tglexpired, qty')
            ->orderBy('faktur')
            ->get()
            ->getResultArray();
        $data = [
            'obat' => $obat,
        ];
        $response = [
            'data' => view('laporan/obat/viewallobatmasuk', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanObatMasukTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $obat = $db
            ->table('obatmasuk')
            ->select('faktur, tglmasuk, idobat, tglexpired, qty')
            ->where('tglmasuk >=', $tglmulai)
            ->where('tglmasuk <=', $tglakhir)
            ->orderBy('faktur')
            ->get()
            ->getResultArray();
        $data = [
            'obat' => $obat,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/obat/viewallobatmasuktanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanObatMasukBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $db = db_connect();
        $obat = $db
            ->table('obatmasuk')
            ->select('faktur, tglmasuk, idobat, tglexpired, qty')
            ->where('MONTH(tglmasuk)', $bulan)
            ->where('YEAR(tglmasuk)', $tahun)
            ->orderBy('faktur')
            ->get()
            ->getResultArray();
        $data = [
            'obat' => $obat,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/obat/viewallobatmasukbulan', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBarangMasukTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
            ->table('detailbarangmasuk')
            ->select('barangmasuk.kdmasuk, supplier.namaspl,barangmasuk.tglmasuk, detailbarangmasuk.kdbarang, MAX(barang.hargabeli) as hargabeli, SUM(detailbarangmasuk.jumlah) as jumlah, SUM(detailbarangmasuk.totalharga) as totalharga, MAX(barangmasuk.grandtotal) as grandtotal')
            ->join('barangmasuk', 'barangmasuk.kdmasuk = detailbarangmasuk.kdmasuk')
            ->join('barang', 'barang.kdbarang = detailbarangmasuk.kdbarang')
            ->join('supplier', 'supplier.kdspl = barangmasuk.kdspl')
            ->groupBy('barangmasuk.kdmasuk, supplier.namaspl, detailbarangmasuk.kdbarang')
            ->where('barangmasuk.tglmasuk >=', $tglmulai)
            ->where('barangmasuk.tglmasuk <=', $tglakhir)
            ->getCompiledSelect();
        $barangmasuk = $db->query($query)->getResultArray();
        $data = [
            'barang' => $barangmasuk,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/barang/viewallbarangmasuktanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBarangMasukBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $db = db_connect();
        $query = $db
            ->table('detailbarangmasuk')
            ->select('barangmasuk.kdmasuk, supplier.namaspl,barangmasuk.tglmasuk, detailbarangmasuk.kdbarang, MAX(barang.hargabeli) as hargabeli, SUM(detailbarangmasuk.jumlah) as jumlah, SUM(detailbarangmasuk.totalharga) as totalharga, MAX(barangmasuk.grandtotal) as grandtotal')
            ->join('barangmasuk', 'barangmasuk.kdmasuk = detailbarangmasuk.kdmasuk')
            ->join('barang', 'barang.kdbarang = detailbarangmasuk.kdbarang')
            ->join('supplier', 'supplier.kdspl = barangmasuk.kdspl')
            ->groupBy('barangmasuk.kdmasuk, supplier.namaspl, detailbarangmasuk.kdbarang')
            ->where('month(barangmasuk.tglmasuk)', $bulan)
            ->where('year(barangmasuk.tglmasuk)', $tahun)
            ->getCompiledSelect();
        $barangmasuk = $db->query($query)->getResultArray();
        $data = [
            'barang' => $barangmasuk,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/barang/viewallbarangmasukbulan', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBarangStok()
    {
        $db = db_connect();
        $barang = $db
            ->table('barang')
            ->select('barang.kdbarang, barang.namabarang, barang.jumlah, barang.hargabeli, barang.hargajual, kategori.namakategori')
            ->join('kategori', 'kategori.kdkategori = barang.kdkategori')
            ->groupBy('barang.kdbarang, barang.namabarang, barang.jumlah, barang.hargabeli, barang.hargajual, kategori.namakategori')
            ->where('barang.jumlah', '<=', 10)
            ->get()
            ->getResultArray();
        $data = [
            'barang' => $barang,
        ];
        $response = [
            'data' => view('laporan/barang/viewallbarang', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanJenis()
    {
        $data['title'] = 'Laporan Jenis Perawatan';
        return view('laporan/jenis/jenisperawatan', $data);
    }

    public function viewallLaporanJenis()
    {
        $db = db_connect();
        $jenis = $db
            ->table('jenis_perawatan')
            ->select('idjenis, namajenis, estimasi,harga')
            ->groupBy('jenis_perawatan.idjenis, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->get()
            ->getResultArray();
        $data = [
            'jenis' => $jenis,
        ];
        $response = [
            'data' => view('laporan/jenis/viewalljenisperawatan', $data),
        ];

        echo json_encode($response);
    }
    public function LaporanJadwal()
    {
        $data['title'] = 'Laporan Jadwal Dokter';
        return view('laporan/jadwal/jadwal', $data);
    }

    public function viewallLaporanJadwal()
    {
        $db = db_connect();
        $jadwal = $db
            ->table('jadwal')
            ->select('jadwal.idjadwal, dokter.nama, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->groupBy('jadwal.idjadwal, dokter.nama, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai')
            ->get()
            ->getResultArray();
        $data = [
            'jadwal' => $jadwal,
        ];
        $response = [
            'data' => view('laporan/jadwal/viewalljadwal', $data),
        ];

        echo json_encode($response);
    }
}
