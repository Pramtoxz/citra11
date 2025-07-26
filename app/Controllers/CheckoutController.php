<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Checkout;
use Hermawan\DataTables\DataTable;

class CheckoutController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Checkout'
        ];
        return view('checkout/datacheckout', $title);
    }

    public function viewCheckout()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $builder = $db->table('checkout')
                ->select('checkout.idcheckout, checkin.idcheckin, checkout.tglcheckout, tamu.nama as nama_tamu,kamar.nama as nama_kamar, checkout.potongan')
                ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
                ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
                ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
                ->where('reservasi.status', 'selesai');
            
            return DataTable::of($builder)
                ->add('action', function ($row) {
                    $buttonDetail = '<a href="' . site_url('checkout/detail/' . $row->idcheckout) . '" class="btn btn-info btn-sm" data-idcheckout="' . $row->idcheckout . '" title="Detail"><i class="fas fa-eye"></i></a>';
                    
                    $buttonEdit = '<button type="button" class="btn btn-success btn-sm btn-edit" data-idcheckout="' . $row->idcheckout . '" style="margin-left: 5px;" title="Edit"><i class="fas fa-pencil-alt"></i></button>';
                    
                    $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idcheckout="' . $row->idcheckout . '" style="margin-left: 5px;" title="Hapus"><i class="fas fa-trash"></i></button>';

                    $buttonsGroup = '<div style="display: flex;">' . $buttonDetail . $buttonEdit . $buttonDelete . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->edit('tglcheckin', function ($row) {
                    return date('d-m-Y', strtotime($row->tglcheckin));
                })
                ->edit('tglcheckout', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->tglcheckout));
                })
                ->edit('potongan', function ($row) {
                    return 'Rp ' . number_format($row->potongan, 0, ',', '.');
                })
                ->addNumbering()
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
        
        $prefix = "CO-$today-";
        
        $query = $db->query("SELECT idcheckout FROM checkout WHERE idcheckout LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();
        
        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idcheckout'], strlen($prefix));
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
            'debug_date' => $debug_date
        ];
        return view('checkout/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idcheckout = $this->request->getPost('idcheckout');
            $idcheckin = $this->request->getPost('idcheckin');
            $potongan = $this->request->getPost('potongan');
            $keterangan = $this->request->getPost('keterangan');
            $tglcheckout_actual = $this->request->getPost('tglcheckout_actual');
            $grandtotal_numeric = $this->request->getPost('grandtotal_numeric');
            
            // Validasi data
            $rules = [
                'idcheckin' => [
                    'label' => 'Checkin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'potongan' => [
                    'label' => 'Potongan',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],

                'tglcheckout_actual' => [
                    'label' => 'Tanggal Checkout Aktual',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_idcheckin' => $this->validator->getError('idcheckin'),
                    'error_potongan' => $this->validator->getError('potongan'),
                    'error_tglcheckout_actual' => $this->validator->getError('tglcheckout_actual'),
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                $db = db_connect();
                
                // Validasi checkin ada dan status reservasi 'checkin'
                $checkin = $db->table('checkin')
                    ->where('idcheckin', $idcheckin)
                    ->get()
                    ->getRowArray();
                
                if (!$checkin) {
                    $json = [
                        'error' => [
                            'error_idcheckin' => 'Checkin tidak ditemukan'
                        ]
                    ];
                    return $this->response->setJSON($json);
                }
                
                $reservasi = $db->table('reservasi')
                    ->where('idbooking', $checkin['idbooking'])
                    ->where('status', 'checkin')
                    ->get()
                    ->getRowArray();
                
                if (!$reservasi) {
                    $json = [
                        'error' => [
                            'error_idcheckin' => 'Reservasi tidak ditemukan atau sudah tidak bisa di-checkout'
                        ]
                    ];
                    return $this->response->setJSON($json);
                }
                
                // Insert data checkout menggunakan Model
                $checkoutModel = new Checkout();
                $dataCheckout = [
                    'idcheckout' => $idcheckout,
                    'idcheckin' => $idcheckin,
                    'tglcheckout' => $tglcheckout_actual . ' ' . date('H:i:s'), // Tanggal dari input + waktu sekarang
                    'potongan' => $potongan,
                    'grandtotal' => $grandtotal_numeric,
                    'keterangan' => $keterangan
                ];
                $checkoutModel->insert($dataCheckout);
                
                // Update status reservasi menjadi 'selesai'
                $db->table('reservasi')
                    ->where('idbooking', $checkin['idbooking'])
                    ->update(['status' => 'selesai']);
                
                // Update status kamar menjadi 'tersedia'
                $db->table('kamar')
                    ->where('id_kamar', $reservasi['idkamar'])
                    ->update(['status_kamar' => 'tersedia']);
                
                $json = [
                    'sukses' => 'Checkout Berhasil Diproses',
                    'idcheckout' => $idcheckout
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid'
            ]);
        }
    }

    public function getCheckin()
    {
        return view('checkout/getcheckin');
    }

    public function viewGetCheckin()
    {
        if ($this->request->isAJAX()) {
            try {
                $db = db_connect();
                $builder = $db->table('checkin')
                    ->select('checkin.idcheckin, checkin.idbooking, checkin.sisabayar, checkin.deposit, tamu.nama as nama_tamu, kamar.nama as nama_kamar, reservasi.tglcheckin, reservasi.tglcheckout, reservasi.totalbayar, tamu.nik, tamu.nohp, kamar.harga as harga_kamar, DATEDIFF(reservasi.tglcheckout, reservasi.tglcheckin) as lama_hari')
                    ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
                    ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                    ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
                    ->where('reservasi.status', 'checkin');

                return DataTable::of($builder)
                    ->add('action', function ($row) {
                        $button = '<button type="button" class="btn btn-primary btn-pilihcheckin" ';
                        $button .= 'data-idbooking="' . $row->idbooking . '" ';
                        $button .= 'data-idcheckin="' . esc($row->idcheckin) . '" ';
                        $button .= 'data-nama_tamu="' . esc($row->nama_tamu) . '" ';
                        $button .= 'data-nik="' . esc($row->nik) . '" ';
                        $button .= 'data-nohp="' . esc($row->nohp) . '" ';
                        $button .= 'data-nama_kamar="' . esc($row->nama_kamar) . '" ';
                        $button .= 'data-tglcheckin="' . date('d-m-Y', strtotime($row->tglcheckin)) . '" ';
                        $button .= 'data-tglcheckout="' . date('d-m-Y', strtotime($row->tglcheckout)) . '" ';
                        $button .= 'data-totalbayar="' . $row->totalbayar . '" ';
                        $button .= 'data-sisabayar="' . $row->sisabayar . '" ';
                        $button .= 'data-deposit="' . $row->deposit . '" ';
                        $button .= 'data-harga_kamar="' . $row->harga_kamar . '" ';
                        $button .= 'data-lama_hari="' . $row->lama_hari . '">Pilih</button>';
                        return $button;
                    }, 'last')
                    ->edit('tglcheckin', function ($row) {
                        return date('d-m-Y', strtotime($row->tglcheckin));
                    })
                    ->edit('tglcheckout', function ($row) {
                        return date('d-m-Y', strtotime($row->tglcheckout));
                    })
                    ->edit('totalbayar', function ($row) {
                        return 'Rp ' . number_format($row->totalbayar, 0, ',', '.');
                    })
                    ->edit('sisabayar', function ($row) {
                        return 'Rp ' . number_format($row->sisabayar, 0, ',', '.');
                    })
                    ->edit('deposit', function ($row) {
                        return 'Rp ' . number_format($row->deposit, 0, ',', '.');
                    })
                    ->addNumbering()
                    // Hanya tampilkan kolom yang diminta, kolom lain di-hide
                    ->hide('idbooking')
                    ->hide('totalbayar')
                    ->hide('sisabayar')
                    ->hide('deposit')
                    ->hide('nik')
                    ->hide('nohp')
                    ->hide('lama_hari')
                    ->hide('harga_kamar')
                    ->toJson();
            } catch (\Exception $e) {
                log_message('error', 'Error in viewGetCheckin: ' . $e->getMessage());
                return $this->response->setJSON([
                    'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            return $this->response->setJSON([
                'error' => 'Request tidak valid - bukan AJAX'
            ]);
        }
    }

    public function updateCheckout()
    {
        if ($this->request->isAJAX()) {
            $idcheckout = $this->request->getPost('idcheckout');
            $potongan = $this->request->getPost('potongan');
            $keterangan = $this->request->getPost('keterangan');
            
            $rules = [
                'potongan' => [
                    'label' => 'Potongan',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_potongan' => $this->validator->getError('potongan')
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                // Update data checkout menggunakan Model
                $checkoutModel = new Checkout();
                $checkoutModel->update($idcheckout, [
                    'potongan' => $potongan,
                    'keterangan' => $keterangan
                ]);
                
                $json = [
                    'sukses' => 'Data checkout berhasil diupdate'
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idcheckout = $this->request->getPost('idcheckout');

            $db = db_connect();
            
            // Ambil data checkout untuk mendapatkan idcheckin
            $checkout = $db->table('checkout')->where('idcheckout', $idcheckout)->get()->getRow();
            
            if ($checkout) {
                // Ambil data checkin
                $checkin = $db->table('checkin')->where('idcheckin', $checkout->idcheckin)->get()->getRow();
                
                if ($checkin) {
                    $reservasi = $db->table('reservasi')->where('idbooking', $checkin->idbooking)->get()->getRow();
                    
                    if ($reservasi) {
                        // Hapus data checkout
                        $db->table('checkout')->where('idcheckout', $idcheckout)->delete();
                        
                        // Kembalikan status reservasi ke 'checkin'
                        $db->table('reservasi')->where('idbooking', $checkin->idbooking)->update(['status' => 'checkin']);
                        
                        // Kembalikan status kamar ke 'tidak tersedia'
                        $db->table('kamar')->where('id_kamar', $reservasi->idkamar)->update(['status_kamar' => 'tidak tersedia']);
                        
                        $json = [
                            'sukses' => 'Data Checkout Berhasil Dihapus'
                        ];
                    } else {
                        $json = [
                            'error' => 'Data Reservasi tidak ditemukan'
                        ];
                    }
                } else {
                    $json = [
                        'error' => 'Data Checkin tidak ditemukan'
                    ];
                }
            } else {
                $json = [
                    'error' => 'Data Checkout tidak ditemukan'
                ];
            }
            
            return $this->response->setJSON($json);
        }
    }

    public function detail($idcheckout)
    {
        $db = db_connect();
        
        // Ambil data checkout dengan join ke checkin dan reservasi
        $checkout = $db->table('checkout')
            ->select('checkout.*, reservasi.*')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->where('checkout.idcheckout', $idcheckout)
            ->get()
            ->getRowArray();
            
        if (!$checkout) {
            return redirect()->to(base_url('checkout'))->with('error', 'Data checkout tidak ditemukan');
        }
        
        // Ambil data tamu
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email as email')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('nik', $checkout['nik'])
            ->get()
            ->getRowArray();
            
        // Ambil data kamar
        $kamar = $db->table('kamar')
            ->where('id_kamar', $checkout['idkamar'])
            ->get()
            ->getRowArray();
            
        // Ambil data checkin
        $checkin = $db->table('checkin')
            ->where('idcheckin', $checkout['idcheckin'])
            ->get()
            ->getRowArray();
            
        $data = [
            'checkout' => $checkout,
            'reservasi' => $checkout, // Untuk kompatibilitas dengan view yang ada
            'tamu' => $tamu,
            'kamar' => $kamar,
            'checkin' => $checkin
        ];
        
        return view('checkout/detail', $data);
    }

    public function faktur($idcheckout)
    {
        $db = db_connect();
        
        // Ambil data checkout dengan join ke checkin, reservasi, tamu, dan kamar
        $checkout = $db->table('checkout')
            ->select('checkout.*, reservasi.*, tamu.nama as nama_tamu, tamu.nik, tamu.nohp, tamu.alamat, users.email, kamar.nama as nama_kamar, kamar.harga as harga_kamar, kamar.cover, DATEDIFF(reservasi.tglcheckout, reservasi.tglcheckin) as lama_hari')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('checkout.idcheckout', $idcheckout)
            ->get()
            ->getRowArray();

        if (!$checkout) {
            return redirect()->back()->with('error', 'Data checkout tidak ditemukan');
        }

        // Ambil data checkin
        $checkin = $db->table('checkin')
            ->where('idcheckin', $checkout['idcheckin'])
            ->get()
            ->getRowArray();
            
        // Ambil data tamu lengkap
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email as email')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('nik', $checkout['nik'])
            ->get()
            ->getRowArray();
            
        // Ambil data kamar lengkap
        $kamar = $db->table('kamar')
            ->where('id_kamar', $checkout['idkamar'])
            ->get()
            ->getRowArray();

        $data = [
            'checkout' => $checkout,
            'reservasi' => $checkout, // Untuk kompatibilitas dengan view
            'checkin' => $checkin,
            'tamu' => $tamu,
            'kamar' => $kamar
        ];

        return view('checkout/faktur', $data);
    }

    public function formedit($idcheckout)
    {
        $db = db_connect();
        
        // Ambil data checkout dengan join ke checkin, reservasi, tamu, dan kamar
        $checkout = $db->table('checkout')
            ->select('checkout.*, reservasi.*, tamu.nama as nama_tamu, tamu.nik, tamu.nohp, kamar.nama as nama_kamar, kamar.harga as harga_kamar, kamar.cover, DATEDIFF(reservasi.tglcheckout, reservasi.tglcheckin) as lama_hari')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkout.idcheckout', $idcheckout)
            ->get()
            ->getRowArray();

        if (!$checkout) {
            return redirect()->back()->with('error', 'Data checkout tidak ditemukan');
        }

        // Ambil data checkin
        $checkin = $db->table('checkin')
            ->where('idcheckin', $checkout['idcheckin'])
            ->get()
            ->getRowArray();

        $data = [
            'checkout' => $checkout,
            'checkin' => $checkin
        ];

        return view('checkout/formedit', $data);
    }

    public function updatedata($idcheckout)
    {
        if ($this->request->isAJAX()) {
            $idcheckin = $this->request->getPost('idcheckin');
            $potongan = $this->request->getPost('potongan');
            $keterangan = $this->request->getPost('keterangan');
            $tglcheckout_actual = $this->request->getPost('tglcheckout_actual');
            $grandtotal_numeric = $this->request->getPost('grandtotal_numeric');
            
            // Validasi data
            $rules = [
                'idcheckin' => [
                    'label' => 'Checkin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'potongan' => [
                    'label' => 'Potongan',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
                'tglcheckout_actual' => [
                    'label' => 'Tanggal Checkout Aktual',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_date' => '{field} harus berupa tanggal yang valid',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [
                    'error_idcheckin' => $this->validator->getError('idcheckin'),
                    'error_potongan' => $this->validator->getError('potongan'),
                    'error_tglcheckout_actual' => $this->validator->getError('tglcheckout_actual'),
                ];

                $json = [
                    'error' => $errors
                ];
            } else {
                // Update data checkout menggunakan Model
                $checkoutModel = new Checkout();
                $dataCheckout = [
                    'idcheckin' => $idcheckin,
                    'tglcheckout' => $tglcheckout_actual . ' ' . date('H:i:s'), // Tanggal dari input + waktu sekarang
                    'potongan' => $potongan,
                    'grandtotal' => $grandtotal_numeric,
                    'keterangan' => $keterangan
                ];
                $checkoutModel->update($idcheckout, $dataCheckout);
                
                $json = [
                    'sukses' => 'Data Checkout Berhasil Diupdate',
                    'idcheckout' => $idcheckout
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid'
            ]);
        }
    }
} 