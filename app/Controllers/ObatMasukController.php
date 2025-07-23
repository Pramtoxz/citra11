<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ObatMasuk as ModelObatMasuk;
use App\Models\Obat as ModelObat;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;


class ObatMasukController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Obat Masuk'
        ];
        return view('obatmasuk/obatmasuk', $title);
    }

    public function view()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            // Ambil data faktur, tglmasuk, dan jumlah total qty per faktur
            $produk = $db->table('obatmasuk')
                ->select('faktur, tglmasuk, SUM(qty) as total_item, MIN(id) as id')
                ->groupBy('faktur, tglmasuk');

            return DataTable::of($produk)
                ->add('action', function ($row) {
                    $btnDetail = '<a href="#" class="btn btn-primary btn-sm btn-detail mr-1" data-id="' . $row->id . '" data-faktur="' . $row->faktur . '" data-toggle="tooltip" title="Detail Data"><i class="fas fa-eye"></i></a>';
                    $btnEdit = '<a href="#" class="btn btn-secondary btn-sm btn-edit mr-1" data-id="' . $row->id . '" data-faktur="' . $row->faktur . '" data-toggle="tooltip" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>';
                    $btnDelete = '<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-faktur="' . $row->faktur . '" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                    return $btnDetail . $btnEdit . $btnDelete;
                }, 'last')
                ->addNumbering()
                ->edit('total_item', function ($row) {
                    // Periksa apakah nilai adalah objek
                    if (is_object($row)) {
                        // Jika objek, ambil total_item sebagai properti atau gunakan 0 jika tidak ada
                        return isset($row->total_item) ? (int)$row->total_item : 0;
                    }
                    // Jika bukan objek, pastikan nilai dikonversi ke integer
                    return is_null($row) ? 0 : (int)$row;
                })
                ->hide('id')
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        $db->table('temp_masuk')->emptyTable();

       
        $data = [
            'title' => 'Tambah Barang Masuk',
        ];
        return view('obatmasuk/formtambah', $data);
    }

    public function getObat()
    {

        return view('obatmasuk/getobat');
    }

    public function addTemp()
    {
        if ($this->request->isAJAX()) {
            $idobat = $this->request->getPost('idobat');
            $tglexpired = $this->request->getPost('tglexpired');
            $qty = $this->request->getPost('qty');
          

            $rules = [
                'idobat' => [
                    'label' => 'Kode Obat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglexpired' => [
                    'label' => 'Tanggal Expired',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'qty' => [
                    'label' => 'QTY',
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
                
                // Tambahkan ke tabel temp_masuk
                $db->table('temp_masuk')->insert([
                    'idobat' => $idobat,
                    'tglexpired' => $tglexpired,
                    'qty' => $qty,
                ]);
                
                // Update stok obat langsung saat menambahkan ke temp
                $modelObat = new ModelObat();
                $obat = $modelObat->find($idobat);
                if ($obat) {
                    $stokBaru = $obat['stok'] + $qty;
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
            $obat = $db->table('temp_masuk')->select('id,temp_masuk.idobat, obat.nama,temp_masuk.tglexpired,temp_masuk.qty,')
             ->join('obat', 'obat.idobat = temp_masuk.idobat');            
             return DataTable::of($obat)
                ->add('action', function ($row) {
                    return 
                     '<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                }, 'last')
                ->addNumbering()
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
            
            // Ambil data temp yang akan dihapus untuk revert stok
            $tempData = $db->table('temp_masuk')->where('id', $idToDelete)->get()->getRowArray();
            if ($tempData) {
                // Revert stok obat
                $modelObat = new ModelObat();
                $obat = $modelObat->find($tempData['idobat']);
                if ($obat) {
                    $stokBaru = $obat['stok'] - $tempData['qty'];
                    $modelObat->update($tempData['idobat'], ['stok' => $stokBaru]);
                }
                
                // Hapus dari temp
                $db->table('temp_masuk')->where('id', $idToDelete)->delete();
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
            $allTempData = $db->table('temp_masuk')->get()->getResultArray();
            
            if (!empty($allTempData)) {
                $modelObat = new ModelObat();
                
                // Revert stok untuk semua item di temp
                foreach ($allTempData as $temp) {
                    $obat = $modelObat->find($temp['idobat']);
                    if ($obat) {
                        $stokBaru = $obat['stok'] - $temp['qty'];
                        $modelObat->update($temp['idobat'], ['stok' => $stokBaru]);
                    }
                }
            }
            
            // Kosongkan tabel temp
            $db->table('temp_masuk')->emptyTable();
            
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
            $faktur = $this->request->getPost('faktur');
            $tglmasuk = $this->request->getPost('tglmasuk');

            $rules = [
                'faktur' => [
                    'label' => 'Faktur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglmasuk' => [
                    'label' => 'Tanggal Masuk',
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
                return $this->response->setJSON($json);
            } else {
                $db = db_connect();
                $db->transStart();

                // Inisialisasi model yang benar
                $modelObatMasuk = new ModelObatMasuk();

                // Ambil data dari temp_masuk
                $tempMasuk = $db->table('temp_masuk')->get()->getResultArray();
                
                if (empty($tempMasuk)) {
                    return $this->response->setJSON([
                        'error' => ['error_general' => 'Tidak ada data obat yang ditambahkan']
                    ]);
                }

                foreach ($tempMasuk as $item) {
                    // Simpan data ke tabel obatmasuk
                    $datasetmasuk = [
                        'faktur' => $faktur,
                        'tglmasuk' => $tglmasuk,
                        'idobat' => $item['idobat'],
                        'tglexpired' => $item['tglexpired'],
                        'qty' => $item['qty'],
                    ];
                    $modelObatMasuk->insert($datasetmasuk);
                    
                    // Tidak perlu update stok lagi karena sudah diupdate saat addTemp
                }

                // Kosongkan tabel temporary tanpa mengubah stok lagi
                $db->table('temp_masuk')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal menyimpan data'];
                } else {
                    $json = ['sukses' => 'Obat Masuk berhasil disimpan'];
                }
                return $this->response->setJSON($json);
            }
        }
    }

  
    public function formedit($faktur)
    {
        $db = db_connect();
        $db->table('temp_masuk')->emptyTable();
        
        // Ambil data obatmasuk berdasarkan faktur
        $obatMasukData = $db->table('obatmasuk')
            ->where('faktur', $faktur)
            ->get()->getResultArray();
        
        if (empty($obatMasukData)) {
            return redirect()->back()->with('error', 'Data Obat Masuk tidak ditemukan');
        }
        
        // Ambil data pertama untuk informasi faktur dan tanggal
        $firstData = $obatMasukData[0];
        
        // Masukkan semua data ke temp_masuk untuk ditampilkan di form edit
        foreach ($obatMasukData as $row) {
            $db->table('temp_masuk')->insert([
                'idobat' => $row['idobat'],
                'tglexpired' => $row['tglexpired'],
                'qty' => $row['qty'],
            ]);
        }

        // Verifikasi apakah data berhasil dimasukkan ke temp_masuk
        $tempData = $db->table('temp_masuk')->get()->getResultArray();
        
        $data = [
            'title' => 'Edit Obat Masuk',
            'faktur' => $faktur,
            'tglmasuk' => $firstData['tglmasuk'],
            'obatmasuk' => $obatMasukData,
            'tempData' => $tempData // Tambahkan untuk debugging
        ];
        
        return view('obatmasuk/formedit', $data);
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $tglmasuk = $this->request->getPost('tglmasuk');

            $rules = [
                'faktur' => [
                    'label' => 'Faktur',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglmasuk' => [
                    'label' => 'Tanggal Masuk',
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

                $modelObatMasuk = new ModelObatMasuk();

                // Hapus semua data lama dengan faktur yang sama
                // Stok sudah diupdate melalui addTemp dan deleteTemp, jadi tidak perlu diubah di sini
                $db->table('obatmasuk')->where('faktur', $faktur)->delete();
                
                // Ambil data dari temp_masuk
                $tempMasuk = $db->table('temp_masuk')->get()->getResultArray();
                
                if (empty($tempMasuk)) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'error' => ['error_general' => 'Tidak ada data obat yang ditambahkan']
                    ]);
                }

                // Simpan data baru
                foreach ($tempMasuk as $item) {
                    $datasetmasuk = [
                        'faktur' => $faktur,
                        'tglmasuk' => $tglmasuk,
                        'idobat' => $item['idobat'],
                        'tglexpired' => $item['tglexpired'],
                        'qty' => $item['qty'],
                    ];
                    $modelObatMasuk->insert($datasetmasuk);
                    
                    // Tidak perlu update stok lagi karena sudah diupdate saat addTemp
                }

                // Kosongkan tabel temporary tanpa mengubah stok lagi
                $db->table('temp_masuk')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal memperbarui data'];
                } else {
                    $json = [
                        'sukses' => 'Data obat masuk berhasil diperbarui',
                        'faktur' => $faktur
                    ];
                }
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $db = db_connect();
            
            // Ambil data faktur dari id yang diberikan
            $obatMasuk = $db->table('obatmasuk')
                ->where('id', $id)
                ->get()->getRowArray();
                
            if (!$obatMasuk) {
                return $this->response->setJSON([
                    'error' => 'Data tidak ditemukan'
                ]);
            }
            
            $faktur = $obatMasuk['faktur'];
            
            // Ambil semua data dengan faktur yang sama
            $allData = $db->table('obatmasuk')
                ->where('faktur', $faktur)
                ->get()->getResultArray();
                
            $modelObat = new ModelObat();
            
            $db->transStart();
            
            // Kembalikan stok obat
            foreach ($allData as $item) {
                $obat = $modelObat->find($item['idobat']);
                if ($obat) {
                    $stokBaru = $obat['stok'] - $item['qty'];
                    $modelObat->update($item['idobat'], ['stok' => $stokBaru]);
                }
            }
            
            // Hapus semua data dengan faktur tersebut
            $db->table('obatmasuk')->where('faktur', $faktur)->delete();
            
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                $json = ['error' => 'Gagal menghapus data'];
            } else {
                $json = ['sukses' => 'Data Obat Masuk berhasil dihapus'];
            }

            return $this->response->setJSON($json);
        }
    }


    public function DetailObatMasuk($faktur)
    {
        $db = db_connect();
        
        // Ambil informasi faktur dan tanggal
        $mainData = $db->table('obatmasuk')
            ->select('faktur, tglmasuk, SUM(qty) as total_qty')
            ->where('faktur', $faktur)
            ->groupBy('faktur, tglmasuk')
            ->get()->getRowArray();
            
        if (!$mainData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        
        // Ambil detail item obat dengan query yang lebih spesifik
        $query = "SELECT om.idobat, o.nama, om.tglexpired, om.qty 
                  FROM obatmasuk om 
                  LEFT JOIN obat o ON om.idobat = o.idobat 
                  WHERE om.faktur = ?";
        
        $detailData = $db->query($query, [$faktur])->getResultArray();
            
        $data = [
            'title' => 'Detail Obat Masuk',
            'mainData' => $mainData,
            'detailData' => $detailData
        ];

        return view('obatmasuk/detail', $data);
    }

}
