<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Checkin;
use App\Models\Tamu as ModelsTamu; 
use Hermawan\DataTables\DataTable;

class CheckinController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Checkin'
        ];
        return view('checkin/datacheckin', $title);
    }


    public function viewCheckin()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('checkin')
                ->select('checkin.idcheckin,checkin.idbooking,tamu.nama as nama_tamu, kamar.nama as nama_kamar,reservasi.tglcheckin,reservasi.tglcheckout,reservasi.status')
                ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
                ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
                ->whereIn('reservasi.status', ['checkin', 'selesai']);
            return DataTable::of($builder)
                ->add('action', function ($row) {
                    $buttonDetail = '<a href="' . site_url('checkin/detail/' . $row->idcheckin) . '" class="btn btn-info btn-sm" data-idcheckin="' . $row->idcheckin . '" title="Detail"><i class="fas fa-eye"></i></a>';
                    
                    $buttonFaktur = '<a href="' . site_url('checkin/faktur/' . $row->idcheckin) . '" class="btn btn-warning btn-sm" data-idcheckin="' . $row->idcheckin . '" style="margin-left: 5px;" title="Faktur Check-in"><i class="fas fa-file-invoice"></i></a>';
                    
                    $buttonEdit = '';
                    if ($row->status != 'ditolak') {
                        $buttonEdit = '<button type="button" class="btn btn-success btn-sm btn-edit" data-idcheckin="' . $row->idcheckin . '" style="margin-left: 5px;" title="Edit"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;" title="Hapus"><i class="fas fa-trash"></i></button>';

                    $buttonsGroup = '<div style="display: flex;">' . $buttonDetail . $buttonFaktur . $buttonEdit . $buttonDelete . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->edit('status', function ($row) {
                    if ($row->status == 'checkin') {
                        return '<span class="badge badge-success">Check In</span>';
                    } else if ($row->status == 'selesai') {
                        return '<span class="badge badge-primary">Selesai</span>';
                    }
                    return '<span class="badge badge-secondary">' . ucfirst($row->status) . '</span>';
                })
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
        
        $prefix = "CK-$today-";
        
        $query = $db->query("SELECT idcheckin FROM checkin WHERE idcheckin LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();
        
        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idcheckin'], strlen($prefix));
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
        return view('checkin/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idcheckin = $this->request->getPost('idcheckin');
            $idbooking = $this->request->getPost('idbooking');
            $sisabayar = $this->request->getPost('sisabayar');
            $deposit = $this->request->getPost('deposit');
            
            // Validasi data
            $rules = [
                'idbooking' => [
                    'label' => 'Reservasi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'sisabayar' => [
                    'label' => 'Sisa Bayar',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
                'deposit' => [
                    'label' => 'Deposit',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih dari 0',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_idbooking' => $this->validator->getError('idbooking'),
                    'error_sisabayar' => $this->validator->getError('sisabayar'),
                    'error_deposit' => $this->validator->getError('deposit')
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                $db = db_connect();
                
                // Validasi reservasi masih ada dan status 'diterima'
                $reservasi = $db->table('reservasi')
                    ->where('idbooking', $idbooking)
                    ->where('status', 'diterima')
                    ->get()
                    ->getRowArray();
                
                if (!$reservasi) {
                    $json = [
                        'error' => [
                            'error_idbooking' => 'Reservasi tidak ditemukan atau sudah tidak bisa di-checkin'
                        ]
                    ];
                    return $this->response->setJSON($json);
                }
                
                // Insert data checkin menggunakan Model
                $checkinModel = new Checkin();
                $dataCheckin = [
                    'idcheckin' => $idcheckin,
                    'idbooking' => $idbooking,
                    'sisabayar' => $sisabayar,
                    'deposit' => $deposit
                ];
                $checkinModel->insert($dataCheckin); // ✅ Menggunakan Model - timestamps otomatis
                
                // Update status reservasi menjadi 'checkin'
                $db->table('reservasi')
                    ->where('idbooking', $idbooking)
                    ->update(['status' => 'checkin']);
                
                // Update status kamar menjadi 'tidak tersedia'
                $db->table('kamar')
                    ->where('id_kamar', $reservasi['idkamar'])
                    ->update(['status_kamar' => 'tidak tersedia']);
                
                $json = [
                    'sukses' => 'Checkin Berhasil Diproses',
                    'idcheckin' => $idcheckin
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

        return view('checkin/gettamu');
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
                // Logika hotel: checkout jam 12:00, checkin jam 14:00 - jadi tanggal sama bisa booking
                $bookedKamarQuery = $db->table('reservasi')
                    ->select('idkamar')
                    ->where('status !=', 'ditolak')
                    ->where('status !=', 'cancel')
                    ->where('status !=', 'selesai')
                    ->groupStart()
                        ->where("(tglcheckin < '$tglcheckout' AND tglcheckout > '$tglcheckin')")
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

 

    public function updateCheckin()
    {
        if ($this->request->isAJAX()) {
            $idcheckin = $this->request->getPost('idcheckin');
            $sisabayar = $this->request->getPost('sisabayar');
            $deposit = $this->request->getPost('deposit');
            
            $rules = [
                'sisabayar' => [
                    'label' => 'Sisa Bayar',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
                'deposit' => [
                    'label' => 'Deposit',
                    'rules' => 'required|numeric|greater_than[0]',
                    'errors' => [
                        'required' => '{field} wajib diisi',
                        'numeric' => '{field} harus berupa angka',
                        'greater_than' => '{field} harus lebih dari 0',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_sisabayar' => $this->validator->getError('sisabayar'),
                    'error_deposit' => $this->validator->getError('deposit')
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                // Update data checkin menggunakan Model
                $checkinModel = new Checkin();
                $checkinModel->update($idcheckin, [
                    'sisabayar' => $sisabayar,
                    'deposit' => $deposit
                ]); // ✅ Menggunakan Model - updated_at otomatis
                
                $json = [
                    'sukses' => 'Data checkin berhasil diupdate'
                ];
            }

            return $this->response->setJSON($json);
        }
    }


    public function detail($idcheckin)
    {
        $db = db_connect();
        
        // Ambil data checkin dengan join ke reservasi
        $checkin = $db->table('checkin')
            ->select('checkin.*, reservasi.*')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->where('checkin.idcheckin', $idcheckin)
            ->get()
            ->getRowArray();
            
        if (!$checkin) {
            return redirect()->to(base_url('checkin'))->with('error', 'Data checkin tidak ditemukan');
        }
        
        // Ambil data tamu
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email as email')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('nik', $checkin['nik'])
            ->get()
            ->getRowArray();
            
        // Ambil data kamar
        $kamar = $db->table('kamar')
            ->where('id_kamar', $checkin['idkamar'])
            ->get()
            ->getRowArray();
            
        $data = [
            'checkin' => $checkin,
            'reservasi' => $checkin, // Untuk kompatibilitas dengan view yang ada
            'tamu' => $tamu,
            'kamar' => $kamar
        ];
        
        return view('checkin/detail', $data);
    }
    
    public function faktur($idcheckin)
    {
        $db = db_connect();
        
        // Ambil data checkin dengan join ke reservasi
        $checkin = $db->table('checkin')
            ->select('checkin.*, reservasi.*')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->where('checkin.idcheckin', $idcheckin)
            ->get()
            ->getRowArray();
            
        if (!$checkin) {
            return redirect()->to(base_url('checkin'))->with('error', 'Data checkin tidak ditemukan');
        }
        
        // Ambil data tamu
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email as email')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('nik', $checkin['nik'])
            ->get()
            ->getRowArray();
            
        // Ambil data kamar
        $kamar = $db->table('kamar')
            ->where('id_kamar', $checkin['idkamar'])
            ->get()
            ->getRowArray();
            
        $data = [
            'checkin' => $checkin,
            'tamu' => $tamu,
            'kamar' => $kamar
        ];
        
        return view('checkin/faktur', $data);
    }
    
    public function formedit($idcheckin)
    {
        $db = db_connect();
        
        // Ambil data checkin dengan join ke reservasi, tamu, dan kamar
        $checkin = $db->table('checkin')
            ->select('checkin.*, reservasi.*, tamu.nama as nama_tamu, tamu.nik, tamu.nohp, kamar.nama as nama_kamar, kamar.harga as harga_kamar, kamar.cover, DATEDIFF(reservasi.tglcheckout, reservasi.tglcheckin) as lama_hari')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkin.idcheckin', $idcheckin)
            ->get()
            ->getRowArray();

        if (!$checkin) {
            return redirect()->back()->with('error', 'Data checkin tidak ditemukan');
        }

        $data = [
            'checkin' => $checkin
        ];

        return view('checkin/formedit', $data);
    }

    public function getReservasi()
    {
        return view('checkin/getreservasi');
    }

    public function viewGetReservasi()
    {
        if ($this->request->isAJAX()) {
            // ✅ TRIGGER: Auto-cleanup expired bookings saat cari reservasi untuk checkin
            $expiredCount = $this->autoCheckExpiredBookings();
            if ($expiredCount > 0) {
                log_message('info', "viewGetReservasi triggered cleanup: {$expiredCount} bookings expired");
            }
            
            $db = db_connect();
            $reservasi = $db->table('reservasi')
                ->select('reservasi.idbooking, reservasi.tglcheckin, tamu.nama as nama_tamu, kamar.nama as nama_kamar, reservasi.tglcheckout, reservasi.totalbayar, reservasi.tipe, reservasi.status, tamu.nik, tamu.nohp, kamar.harga as harga_kamar, kamar.cover, DATEDIFF(reservasi.tglcheckout, reservasi.tglcheckin) as lama_hari')
                ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
                ->where('reservasi.status', 'diterima')
                ->where('reservasi.tglcheckin <=', date('Y-m-d')); // Hanya tampilkan reservasi yang bisa di-checkin dan tglcheckin sudah tiba

            return DataTable::of($reservasi)
                ->add('action', function ($row) {
                    $button = '<button type="button" class="btn btn-primary btn-pilihreservasi" ';
                    $button .= 'data-idbooking="' . $row->idbooking . '" ';
                    $button .= 'data-kode_reservasi="' . esc($row->idbooking) . '" ';
                    $button .= 'data-nama_tamu="' . esc($row->nama_tamu) . '" ';
                    $button .= 'data-nik="' . esc($row->nik) . '" ';
                    $button .= 'data-nohp="' . esc($row->nohp) . '" ';
                    $button .= 'data-nama_kamar="' . esc($row->nama_kamar) . '" ';
                    $button .= 'data-tglcheckin="' . date('d-m-Y', strtotime($row->tglcheckin)) . '" ';
                    $button .= 'data-tglcheckout="' . date('d-m-Y', strtotime($row->tglcheckout)) . '" ';
                    $button .= 'data-totalbayar="' . $row->totalbayar . '" ';
                    $button .= 'data-tipe="' . $row->tipe . '" ';
                    $button .= 'data-harga_kamar="' . $row->harga_kamar . '" ';
                    $button .= 'data-cover="' . esc($row->cover) . '" ';
                    $button .= 'data-lama_hari="' . $row->lama_hari . '">Pilih</button>';
                    return $button;
                }, 'last')
                ->edit('tglcheckin', function ($row) {
                    return date('d-m-Y', strtotime($row->tglcheckin));
                })
                ->addNumbering()
                // Hanya tampilkan kolom yang diminta, kolom lain di-hide
                ->hide('tglcheckout')
                ->hide('tipe')
                ->hide('status')
                ->hide('nik')
                ->hide('nohp')
                ->hide('cover')
                ->hide('lama_hari')
                ->hide('idkamar')
                ->toJson();
        }
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