<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailPerawatan;
use App\Models\Obat;
use App\Models\Perawatan;
use App\Models\Booking;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class PerawatanController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Perawatan'
        ];
        return view('perawatan/dataperawatan', $title);
    }

    public function viewPerawatan()
    {
        $db = db_connect();
        $query = $db->table('perawatan')
                    ->select('perawatan.idperawatan, pasien.nama as nama_pasien, perawatan.tanggal, dokter.nama as nama_dokter')
                    ->join('booking', 'booking.idbooking = perawatan.idbooking')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->join('dokter', 'dokter.id_dokter = jadwal.iddokter');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idperawatan="' . $row->idperawatan . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idperawatan="' . $row->idperawatan . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idperawatan="' . $row->idperawatan . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->addNumbering()
        ->toJson();
    }
    public function formtambah()
    {
        $db = db_connect();
        $db->table('temp')->emptyTable();
        $data = [
            'title' => 'Tambah Data Perawatan'
        ];
        
        return view('perawatan/formtambah', $data);
    }
    public function getPerawatan()
    {

        return view('perawatan/getperawatan');
    }

    public function viewGetPerawatan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $perawatan = $db->table('perawatan')
            ->select('perawatan.idperawatan, booking.idbooking, pasien.nama as nama_pasien, perawatan.tanggal, dokter.nama as nama_dokter,perawatan.resep')
            ->join('booking', 'booking.idbooking = perawatan.idbooking')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->where('booking.status', 'diperiksa');
            return DataTable::of($perawatan)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihperawatan" data-idperawatan="' . $row->idperawatan . '" data-nama_pasien="' . esc($row->nama_pasien) . '"  data-tanggal="' . esc($row->tanggal) . '" data-dokter="' . esc($row->nama_dokter) . '" data-resep="' . esc($row->resep) . '" data-idbooking="' . esc($row->idbooking) . '">
                                Pilih
                            </button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->hide('resep')
                ->toJson();
        }
    }

    public function getObat()
    {

        return view('perawatan/getobat');
    }

    public function viewGetObat()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $obat = $db->table('obat')
            ->select('idobat, nama, harga,stok');
            return DataTable::of($obat)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihobat" data-idobat="' . $row->idobat . '" data-nama="' . esc($row->nama) . '" data-harga="' . esc($row->harga) . '" data-stok="' . esc($row->stok) . '">
                                Pilih
                            </button>';
                    return $button1;
                }, 'last')
                ->format('harga', function ($value, $meta) {
                    return 'Rp ' . number_format($value, 2, '.', ',');
                })
                ->addNumbering()
                ->toJson();
        }
    }

    public function addTemp()
    {
        if ($this->request->isAJAX()) {
            $idobat = $this->request->getPost('idobat');
            $total = $this->request->getPost('total');
            $qty = $this->request->getPost('qty');
          

            $rules = [
                'idobat' => [
                    'label' => 'Kode Obat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'qty' => [
                    'label' => 'Qty',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                    $db = db_connect();
                    $db->transStart();
                    
                    // Tambahkan ke tabel temp
                    $db->table('temp')->insert([
                        'qty' => $qty,
                        'total' => $total,
                        'idobat' => $idobat,
                    ]);
                    
                    // Update stok obat - kurangi stok saat menambahkan ke temp
                    $modelObat = new Obat();
                    $obat = $modelObat->find($idobat);
                    if ($obat) {
                        $stokBaru = $obat['stok'] - $qty;
                        $modelObat->update($idobat, ['stok' => $stokBaru]);
                    }
                    
                    $db->transComplete();

                    $json = [
                        'sukses' => 'Berhasil Ditambahkan'
                    ];
                 
            }
            return $this->response->setJSON($json);
        }
    }
    public function viewTemp()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $barang = $db->table('temp')->select('id,temp.idobat, obat.nama,obat.harga,temp.qty, temp.total')
             ->join('obat', 'obat.idobat = temp.idobat');            
             return DataTable::of($barang)
                ->add('action', function ($row) {
                    return 
                     '<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                }, 'last')
                ->addNumbering()
                ->format('harga', function ($value, $meta) {
                    return 'Rp ' . number_format($value, 2, '.', ',');
                })
                ->hide('idobat')
                ->hide('id')
                ->toJson();
        }
    }

    public function deleteTemp($id = null)
    {
        if ($this->request->isAJAX()) {
            // Ambil ID dari parameter segment URL atau dari POST data
            $idToDelete = $id ?? $this->request->getPost('id');

            $db = db_connect();
            $db->transStart();
            
            // Ambil data temp sebelum dihapus untuk revert stok
            $tempData = $db->table('temp')->where('id', $idToDelete)->get()->getRowArray();
            if ($tempData) {
                // Kembalikan stok obat yang telah dikurangi
                $modelObat = new Obat();
                $obat = $modelObat->find($tempData['idobat']);
                if ($obat) {
                    $stokBaru = $obat['stok'] + $tempData['qty']; // Tambahkan kembali stok (+)
                    $modelObat->update($tempData['idobat'], ['stok' => $stokBaru]);
                }
                
                // Hapus dari temp
                $db->table('temp')->where('id', $idToDelete)->delete();
            }
            
            $db->transComplete();
            
            $json = [
                'sukses' => 'Data berhasil dihapus'
            ];
            
            return $this->response->setJSON($json);
        }
    }
    public function deleteAllTemp()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $db->transStart();
            
            // Ambil semua data temp sebelum dihapus untuk revert stok
            $allTempData = $db->table('temp')->get()->getResultArray();
            
            if (!empty($allTempData)) {
                $modelObat = new Obat();
                
                // Revert stok untuk semua item di temp
                foreach ($allTempData as $temp) {
                    $obat = $modelObat->find($temp['idobat']);
                    if ($obat) {
                        $stokBaru = $obat['stok'] + $temp['qty']; // Tambahkan kembali stok (+)
                        $modelObat->update($temp['idobat'], ['stok' => $stokBaru]);
                    }
                }
            }
            
            // Kosongkan tabel temp
            $db->table('temp')->emptyTable();
            
            $db->transComplete();
            
            $json = [
                'sukses' => 'Semua data berhasil dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }
    public function save()
    {
        if ($this->request->isAJAX()) {
            $idperawatan = $this->request->getPost('idperawatan');
            $grandtotal = $this->request->getPost('grandtotal');
            $idbooking = $this->request->getPost('idbooking');
            
                $db = db_connect();
                $db->transStart();
                $modelDetail = new DetailPerawatan();
                $modelObat = new Obat(); // Model untuk mengupdate stok obat
                $modelBooking = new Booking();
                $modelPerawatan = new Perawatan();
                $temp = $db->table('temp')->get()->getResultArray();
                foreach ($temp as $item) {
                    $dataDetail = [
                        'idperawatan' => $idperawatan,
                        'idobat' => $item['idobat'],
                        'qty' => $item['qty'],
                        'total' => $item['total'],
                    ];
                    // Cek apakah detail sudah ada berdasarkan kdmasuk dan kdbarang
                    $existingDetail = $modelDetail->where(['idperawatan' => $idperawatan, 'idobat' => $item['idobat']])->first();
                    if ($existingDetail) {
                        // Update detail jika sudah ada
                        $modelDetail->update($existingDetail['idperawatan'], $dataDetail);
                    } else {
                        // Insert detail baru jika belum ada
                        $modelDetail->insert($dataDetail);
                    }
                    $modelBooking->update($idbooking, ['status' => 'selesai']);

                    $modelPerawatan->update($idperawatan, ['total' => $grandtotal]);
                }

                $db->table('temp')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal menyimpan data'];
                } else {
                    $json = ['sukses' => 'Perawatan berhasil disimpan'];
                }
                return $this->response->setJSON($json);
        }
    }
    

  
    public function formedit($idperawatan)
    {
        $db = db_connect();
        $db->table('temp')->emptyTable(); // Kosongkan tabel temp dulu
        $modelPerawatan = new Perawatan();
        $perawatan = $modelPerawatan->where('idperawatan', $idperawatan)->first();
        $modelBooking = new Booking();
        if (!$perawatan) {
            return redirect()->back()->with('error', 'Data Perawatan tidak ditemukan');
        }
        $booking = $modelBooking->where('idbooking', $perawatan['idbooking'])->first();

        $bookingData = $db->table('booking')
        ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, jenis_perawatan.namajenis')
        ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
        ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
        ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
        ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
        ->where('booking.idbooking', $perawatan['idbooking'])->get()->getRowArray();
        if (!$bookingData) {
            return redirect()->back()->with('error', 'Data Booking tidak ditemukan');
        }

        // Ambil data detail perawatan dan masukkan ke tabel temp
        $detailPerawatan = $db->table('detail_perawatan')
            ->select('idobat, qty, total')
            ->where('idperawatan', $idperawatan)
            ->get();

        foreach ($detailPerawatan->getResultArray() as $row) {
            $db->table('temp')->insert([
                'idobat' => $row['idobat'],
                'qty' => $row['qty'],
                'total' => $row['total'],
            ]);
        }

        $data = [
            'title' => 'Edit Data Perawatan',
            'perawatan' => $perawatan,
            'booking' => $booking,
            'bookingData' => $bookingData,
        ];

        return view('perawatan/formedit', $data);
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idperawatan = $this->request->getPost('idperawatan');
            $grandtotal = $this->request->getPost('grandtotal');
            $idbooking = $this->request->getPost('idbooking');
            
                $db = db_connect();
                $db->transStart();
                $modelDetail = new DetailPerawatan();
                $modelObat = new Obat(); // Model untuk mengupdate stok obat
                $modelBooking = new Booking();
                $modelPerawatan = new Perawatan();
                $temp = $db->table('temp')->get()->getResultArray();
                foreach ($temp as $item) {
                    $dataDetail = [
                        'idperawatan' => $idperawatan,
                        'idobat' => $item['idobat'],
                        'qty' => $item['qty'],
                        'total' => $item['total'],
                    ];
                    // Cek apakah detail sudah ada berdasarkan kdmasuk dan kdbarang
                    $existingDetail = $modelDetail->where(['idperawatan' => $idperawatan, 'idobat' => $item['idobat']])->first();
                    if ($existingDetail) {
                        // Update detail jika sudah ada
                        $modelDetail->update($existingDetail['idperawatan'], $dataDetail);
                    } else {
                        // Insert detail baru jika belum ada
                        $modelDetail->insert($dataDetail);
                    }

                
                    // Update status booking menjadi 'selesai' berdasarkan idbooking
                    $modelBooking->update($idbooking, ['status' => 'selesai']);

                    $modelPerawatan->update($idperawatan, ['total' => $grandtotal]);
                }

                $db->table('temp')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal menyimpan data'];
                } else {
                    $json = ['sukses' => 'Perawatan berhasil disimpan'];
                }
                return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idperawatan = $this->request->getPost('idperawatan');
            $db = db_connect();
            $modelPerawatan = new Perawatan();
            $modelDetailPerawatan = new DetailPerawatan();
            $modelObat = new Obat();
            
            // Ambil data perawatan dulu untuk mendapatkan idbooking terkait
            $perawatan = $modelPerawatan->where('idperawatan', $idperawatan)->first();
            
            if ($perawatan) {
                $modelBooking = new Booking();
                
                // Ambil data detail perawatan untuk mengembalikan stok obat
                $detailPerawatan = $modelDetailPerawatan->where('idperawatan', $idperawatan)->findAll();
                foreach ($detailPerawatan as $detail) {
                    // Kembalikan jumlah stok obat
                    $obat = $modelObat->find($detail['idobat']);
                    if ($obat) {
                        $jumlahBaru = $obat['stok'] + $detail['qty']; // Tambahkan kembali stok (+)
                        $modelObat->update($detail['idobat'], ['stok' => $jumlahBaru]);
                    }
                }

                // Hapus data di tabel detail_perawatan
                $modelDetailPerawatan->where('idperawatan', $idperawatan)->delete();
                
                // Update status booking menjadi 'diterima'
                if (!empty($perawatan['idbooking'])) {
                    $modelBooking->update($perawatan['idbooking'], ['status' => 'diterima']);
                }
                
                // Hapus data di tabel perawatan
                $modelPerawatan->delete($idperawatan);

                $json = [
                    'sukses' => 'Data Perawatan Berhasil Dihapus'
                ];
            } else {
                $json = [
                    'error' => 'Data Perawatan tidak ditemukan'
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function detail($idperawatan)
    {
        $db = db_connect();
        $modelPerawatan = new Perawatan();
        $perawatan = $modelPerawatan->where('idperawatan', $idperawatan)->first();

        if (!$perawatan) {
            return redirect()->back()->with('error', 'Data Perawatan tidak ditemukan');
        }

        // Ambil data booking terkait perawatan
        $bookingData = $db->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, pasien.alamat, pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $perawatan['idbooking'])
            ->get()
            ->getRowArray();

        // Ambil detail obat yang digunakan
        $detailObat = $db->table('detail_perawatan')
            ->select('detail_perawatan.*, obat.nama as nama_obat, obat.harga')
            ->join('obat', 'obat.idobat = detail_perawatan.idobat')
            ->where('detail_perawatan.idperawatan', $idperawatan)
            ->get()
            ->getResultArray();

        $data = [
            'perawatan' => $perawatan,
            'booking' => $bookingData,
            'detailObat' => $detailObat
        ];

        return view('perawatan/detail', $data);
    }


    public function DetailBarangMasuk($kdmasuk)
    {
        $db = db_connect();
        $userQuery = $db
            ->table('detailbarangmasuk')
            ->select('detailbarangmasuk.kdmasuk,barangmasuk.kdmasuk,barangmasuk.tglmasuk,supplier.namaspl,barangmasuk.grandtotal')
            ->select('(SELECT count(kdbarang) FROM detailbarangmasuk where detailbarangmasuk.kdmasuk = barangmasuk.kdmasuk) as countItem')
            ->select('(SELECT sum(jumlah) FROM detailbarangmasuk where detailbarangmasuk.kdmasuk = barangmasuk.kdmasuk) as totaljumlah')
            ->join('barangmasuk', 'barangmasuk.kdmasuk = detailbarangmasuk.kdmasuk')
            ->join('supplier', 'supplier.kdspl = barangmasuk.kdspl')
            ->groupBy('barangmasuk.kdmasuk')
            ->where('barangmasuk.kdmasuk', $kdmasuk);

        $user = $userQuery->get();

        $detailproduk = $db
            ->table('detailbarangmasuk')
            ->select('barang.namabarang,detailbarangmasuk.jumlah,barang.hargabeli,detailbarangmasuk.totalharga')
            ->join('barang', 'barang.kdbarang = detailbarangmasuk.kdbarang')
            ->where('kdmasuk', $kdmasuk);
        $detail = $detailproduk->get();

        $item = $detail->getResultArray();
        $userData = $user->getRow();
        if (!$userData) {
            return redirect()->back();
        }
        $data = [
            'barang' => $userData,
            'detail' => $item
        ];

        return view('barangmasuk/detail', $data);
    }

}
