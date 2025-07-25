<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Reservasi;
use App\Models\Tamu as ModelsTamu; 
use Hermawan\DataTables\DataTable;

class ReservasiController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Reservasi'
        ];
        return view('reservasi/datareservasi', $title);
    }


    public function viewReservasi()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('reservasi')
                ->select('reservasi.idbooking,reservasi.tglcheckin,reservasi.tglcheckout,tamu.nama as nama_tamu, kamar.nama as nama_kamar, reservasi.status, reservasi.online')
                ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left');
            return DataTable::of($builder)
                ->edit('status', function ($row) {
                    if ($row->status == 'diterima') {
                        return '<span class="badge badge-success">Diterima</span>';
                    } elseif ($row->status == 'diproses') {
                        return '<span class="badge badge-warning">Diproses</span>';
                    } elseif ($row->status == 'ditolak') {
                        return '<span class="badge badge-danger">Ditolak</span>';
                    } elseif ($row->status == 'selesai') {
                        return '<span class="badge badge-info">Selesai</span>';
                    } elseif ($row->status == 'checkin') {
                        return '<span class="badge badge-primary">Check In</span>';
                    } elseif ($row->status == 'cancel') {
                        return '<span class="badge badge-secondary">Dibatalkan</span>';
                    } else {
                        return '<span class="badge badge-dark">-</span>';
                    }
                })
                ->add('action', function ($row) {
                    $buttonDetail = '<a href="' . site_url('reservasi/detail/' . $row->idbooking) . '" class="btn btn-info btn-sm" data-idbooking="' . $row->idbooking . '"><i class="fas fa-eye"></i></a>';
                    
                    $buttonEdit = '';
                    if ($row->status != 'ditolak') {
                        $buttonEdit = '<button type="button" class="btn btn-success btn-sm btn-edit" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';

                    $buttonCekBukti = '';
                    if ($row->online == 1) {
                        if ($row->status == 'diproses') {
                            $buttonCekBukti = '<button type="button" class="btn btn-warning btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Verifikasi</button>';
                        } elseif ($row->status == 'diterima') {
                            $buttonCekBukti = '<button type="button" class="btn btn-success btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Bukti</button>';
                        } else {
                            $buttonCekBukti = '<button type="button" class="btn btn-info btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-image"></i> Bukti</button>';
                        }
                    }

                    $buttonsGroup = '<div style="display: flex;">' . $buttonDetail . $buttonEdit . $buttonDelete . $buttonCekBukti . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->edit('tglcheckin', function ($row) {
                    return date('d-m-Y', strtotime($row->tglcheckin));
                })
                ->edit('tglcheckout', function ($row) {
                    return date('d-m-Y', strtotime($row->tglcheckout));
                })
                ->addNumbering()
                ->hide('online')
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        
        $debug_date = $this->request->getGet('debug_date');
        
        if (!empty($debug_date) && ENVIRONMENT !== 'production') {
            $today = date('Ymd', strtotime($debug_date));
        } else {
            $today = date('Ymd');
        }
        
        $prefix = "RS-$today-";
        
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
        
        $next_id = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
        
        $data = [
            'next_id' => $next_id,
            'debug_date' => $debug_date // Kirim tanggal debug ke view jika ada
        ];
        return view('reservasi/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $tglcheckin = $this->request->getPost('tglcheckin');
            $tglcheckout = $this->request->getPost('tglcheckout');
            $tipebayar = $this->request->getPost('tipebayar');
            $nik = $this->request->getPost('nik');
            $idkamar = $this->request->getPost('idkamar');
            $is_dp = $this->request->getPost('is_dp') ? 1 : 0;
            $dp = $this->request->getPost('dp');
            $totalbayar = $this->request->getPost('totalbayar');
            $sisabayar = $this->request->getPost('sisabayar');
            
            // Validasi data
            $rules = [
                'nik' => [
                    'label' => 'Nama Tamu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idkamar' => [
                    'label' => 'Nama Kamar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_nama_tamu' => $this->validator->getError('nik'),
                    'error_nama_kamar' => $this->validator->getError('idkamar'),
                    'error_harga' => $this->validator->getError('harga')
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                $db = db_connect();
                
                // Validasi kamar masih tersedia untuk tanggal yang dipilih
                $bookedCount = $db->table('reservasi')
                    ->where('idkamar', $idkamar)
                    ->where('status !=', 'ditolak')
                    ->where('status !=', 'cancel')
                    ->where('status !=', 'selesai')
                    ->groupStart()
                        ->where("(tglcheckin <= '$tglcheckout' AND tglcheckout >= '$tglcheckin')")
                    ->groupEnd()
                    ->countAllResults();
                
                if ($bookedCount > 0) {
                    $json = [
                        'error' => [
                            'error_nama_kamar' => 'Kamar sudah dipesan untuk periode tanggal yang dipilih'
                        ]
                    ];
                    return $this->response->setJSON($json);
                }
                
                $dataReservasi = [
                    'idbooking' => $idbooking,
                    'tglcheckin' => $tglcheckin,
                    'tglcheckout' => $tglcheckout,
                    'nik' => $nik,
                    'idkamar' => $idkamar,
                    'tipe' => $tipebayar,
                    'totalbayar' => $totalbayar,
                    'status' => 'diterima',
                    'online' => 0
                ];
                $db->table('reservasi')->insert($dataReservasi);
                if ($is_dp) {
                    session()->set('reservasi_'.$idbooking.'_dp', $dp);
                    session()->set('reservasi_'.$idbooking.'_sisabayar', $sisabayar);
                }
                
                $json = [
                    'sukses' => 'Data Reservasi Berhasil Disimpan',
                    'idbooking' => $idbooking
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid'
            ]);
        }
    }

    public function getTamu()
    {

        return view('reservasi/gettamu');
    }

    public function viewGetTamu()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $tamu = $db->table('tamu')
                ->select('nik, nama as nama_tamu, alamat, nohp, jk, iduser, users.email as email')
                ->join('users', 'users.id = tamu.iduser', 'left');

            return DataTable::of($tamu)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihtamu" data-nik="' . $row->nik . '" data-nama_tamu="' . esc($row->nama_tamu) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->edit('jk', function ($row) {
                    return $row->jk == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->edit('email', function ($row) {
                    // Jika iduser null, tampilkan "Belum Memiliki Akun"
                    return is_null($row->iduser) ? 'Belum Memiliki Akun' : $row->email;
                })
                ->addNumbering()
                ->hide('iduser')
                ->toJson();
        }
    }

    public function getKamar()
    {
        $data = [];
        if ($this->request->getGet('tglcheckin') && $this->request->getGet('tglcheckout')) {
            $data['tglcheckin'] = $this->request->getGet('tglcheckin');
            $data['tglcheckout'] = $this->request->getGet('tglcheckout');
        }
        return view('reservasi/getkamar', $data);
    }

    public function viewGetKamar()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            $tglcheckin = $this->request->getPost('tglcheckin');
            $tglcheckout = $this->request->getPost('tglcheckout');
            
            $kamarBuilder = $db->table('kamar')
                ->select('id_kamar, nama as nama_kamar, harga, dp, status_kamar, cover');
            
            if (!empty($tglcheckin) && !empty($tglcheckout)) {
                $bookedKamarQuery = $db->table('reservasi')
                    ->select('idkamar')
                    ->where('status !=', 'ditolak')
                    ->where('status !=', 'cancel')
                    ->where('status !=', 'selesai')
                    ->groupStart()
                        ->where("(tglcheckin <= '$tglcheckout' AND tglcheckout >= '$tglcheckin')")
                    ->groupEnd();
                $kamarBuilder->whereNotIn('id_kamar', $bookedKamarQuery);
            }

            return DataTable::of($kamarBuilder)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-pilihkamar" data-id_kamar="' . $row->id_kamar . 
                           '" data-nama_kamar="' . esc($row->nama_kamar) . 
                           '" data-harga="' . esc($row->harga) . 
                           '" data-dp="' . esc($row->dp) . 
                           '" data-cover="' . esc($row->cover) . '">Pilih</button>';
                }, 'last')
                ->add('foto', function ($row) {
                    $cover = !empty($row->cover) ? $row->cover : 'kamar.png';
                    return '<img src="' . base_url('assets/img/kamar/' . $cover) . '" alt="Foto Kamar" class="img-thumbnail" style="max-height:80px">';
                })
                ->edit('status_kamar', function ($row) {
                    return $row->status_kamar == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
                })
                ->addNumbering()
                ->hide('cover')
                ->toJson();
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');

            $db = db_connect();
            $reservasi = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRow();
            
            if ($reservasi) {
                $idkamar = $reservasi->idkamar;
                $db->table('reservasi')->where('idbooking', $idbooking)->delete();
                $db->table('kamar')->where('id_kamar', $idkamar)->update(['status_kamar' => 'tersedia']);
                
                $json = [
                    'sukses' => 'Data Reservasi Berhasil Dihapus'
                ];
            } else {
                $json = [
                    'error' => 'Data Reservasi tidak ditemukan'
                ];
            }
            
            return $this->response->setJSON($json);
        }
    }

 

    public function updatedata($idbooking)
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $tglcheckin = $this->request->getPost('tglcheckin');
            $tglcheckout = $this->request->getPost('tglcheckout');
            $tipebayar = $this->request->getPost('tipebayar');
            $status = $this->request->getPost('status');
            
            $rules = [
                'tglcheckin' => [
                    'label' => 'Tanggal Checkin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tglcheckout' => [
                    'label' => 'Tanggal Checkout',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tipebayar' => [
                    'label' => 'Tipe Bayar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status' => [
                    'label' => 'Status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
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
               
              
            $model = new Reservasi();
            $model->update($idbooking, [
                'tglcheckin' => $this->request->getPost('tglcheckin'),
                'tglcheckout' => $this->request->getPost('tglcheckout'),
                'tipe' => $this->request->getPost('tipebayar'),
                'status' => $this->request->getPost('status')
            ]);
                
                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }

            return $this->response->setJSON($json);
        }
    }


    public function detail($idbooking)
    {
        $db = db_connect();
        
        // Ambil data reservasi
        $reservasi = $db->table('reservasi')
            ->where('idbooking', $idbooking)
            ->get()
            ->getRowArray();
            
        if (!$reservasi) {
            return redirect()->to(base_url('reservasi'))->with('error', 'Data reservasi tidak ditemukan');
        }
        
        // Ambil data tamu
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email as email')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('nik', $reservasi['nik'])
            ->get()
            ->getRowArray();
            
        // Ambil data kamar
        $kamar = $db->table('kamar')
            ->where('id_kamar', $reservasi['idkamar'])
            ->get()
            ->getRowArray();
            
        $data = [
            'reservasi' => $reservasi,
            'tamu' => $tamu,
            'kamar' => $kamar
        ];
        
        return view('reservasi/detail', $data);
    }
    
    public function formedit($idbooking)
    {
        $db = db_connect();
        $reservasi = $db->table('reservasi')
            ->select('reservasi.*, tamu.nama as nama_tamu, kamar.nama as nama_kamar')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.idbooking', $idbooking)
            ->get()->getRowArray();

        if (!$reservasi) {
            return redirect()->back()->with('error', 'Data reservasi tidak ditemukan');
        }

        $data = [
            'reservasi' => $reservasi
        ];

        return view('reservasi/formedit', $data);
    }

    // Tambahkan endpoint debug untuk regenerasi ID berdasarkan tanggal
    public function debugNewId()
    {
        // Hanya tersedia di lingkungan non-production
        if (ENVIRONMENT === 'production') {
            return $this->response->setJSON([
                'error' => 'Debug tidak tersedia di environment production'
            ]);
        }
        
        if ($this->request->isAJAX()) {
            $debug_date = $this->request->getPost('debug_date');
            
            if (empty($debug_date)) {
                return $this->response->setJSON([
                    'error' => 'Tanggal debug harus disediakan'
                ]);
            }
            
            $db = db_connect();
            
            // Gunakan tanggal dari input debug
            $today = date('Ymd', strtotime($debug_date));
            
            // Prefix untuk ID reservasi
            $prefix = "RS-$today-";
            
            // Dapatkan semua ID reservasi yang dimulai dengan prefix tanggal debug
            $query = $db->query("SELECT idbooking FROM reservasi WHERE idbooking LIKE ?", ["$prefix%"]);
            $results = $query->getResultArray();
            
            // Jika tidak ada reservasi untuk tanggal debug, mulai dari 1
            if (empty($results)) {
                $nextNo = 1;
            } else {
                // Ekstrak semua angka urutan dari ID yang ada
                $numbers = [];
                foreach ($results as $row) {
                    // Ambil bagian setelah prefix (4 digit terakhir)
                    $num = substr($row['idbooking'], strlen($prefix));
                    if (is_numeric($num)) {
                        $numbers[] = (int)$num;
                    }
                }
                
                // Jika ada angka yang berhasil diekstrak, cari yang tertinggi dan tambahkan 1
                if (!empty($numbers)) {
                    $nextNo = max($numbers) + 1;
                } else {
                    $nextNo = 1;
                }
            }
            
            // Format ID Reservasi baru: RS-[YYYYMMDD]-[0001]
            $new_id = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
            
            return $this->response->setJSON([
                'success' => true,
                'new_id' => $new_id,
                'debug_date' => $debug_date
            ]);
        }
        
        return $this->response->setJSON([
            'error' => 'Metode tidak diizinkan'
        ]);
    }

    public function cancel($idbooking)
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            try {
                // Log untuk debugging
                log_message('info', 'Mencoba membatalkan reservasi: ' . $idbooking);
                
                // Periksa apakah reservasi ada
                $reservasi = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRowArray();
                if (!$reservasi) {
                    log_message('error', 'Reservasi tidak ditemukan: ' . $idbooking);
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Reservasi tidak ditemukan'
                    ]);
                }
                
                // Update status reservasi menjadi 'cancel'
                $db->table('reservasi')
                    ->where('idbooking', $idbooking)
                    ->update(['status' => 'cancel']);
                
                // Log sukses
                log_message('info', 'Berhasil membatalkan reservasi: ' . $idbooking);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Reservasi berhasil dibatalkan'
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Gagal membatalkan reservasi: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal membatalkan reservasi: ' . $e->getMessage()
                ]);
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Akses tidak valid'
        ]);
    }

    public function cekin($idbooking)
    {
        $db = db_connect();
        
        try {
            $reservasi = $db->table('reservasi')
                ->where('idbooking', $idbooking)
                ->get()
                ->getRowArray();
                
            if (!$reservasi) {
                return redirect()->to(base_url('reservasi'))->with('error', 'Data reservasi tidak ditemukan');
            }
            
            $db->table('kamar')
                ->where('id_kamar', $reservasi['idkamar'])
                ->update(['status_kamar' => 'tidak tersedia']);
            
            $db->table('reservasi')
                ->where('idbooking', $idbooking)
                ->update(['status' => 'checkin']);
            
            return redirect()->to(base_url('reservasi'))->with('success', 'Check-in berhasil dilakukan');
        } catch (\Exception $e) {
            return redirect()->to(base_url('reservasi'))->with('error', 'Gagal melakukan check-in: ' . $e->getMessage());
        }
    }
}