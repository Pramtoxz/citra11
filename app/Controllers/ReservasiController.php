<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        $db = db_connect();
        $query = $db->table('reservasi')
                    ->select('reservasi.idbooking, reservasi.tglcheckin, reservasi.tglcheckout,tamu.nama as nama_tamu, kamar.nama as nama_kamar, reservasi.online, reservasi.status')
                    ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
                    ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left');

        return DataTable::of($query)
        ->edit('status', function ($row) {
            $statusClass = '';
            $statusText = ucfirst($row->status);
            
            switch($row->status) {
                case 'diproses':
                    $statusClass = 'badge badge-warning';
                    break;
                case 'diterima':
                    $statusClass = 'badge badge-maroon';
                    break;
                case 'ditolak':
                    $statusClass = 'badge badge-danger';
                    break;
                case 'selesai':
                    $statusClass = 'badge badge-success';
                    break;
                case 'cancel':
                    $statusClass = 'badge badge-dark';
                    $statusText = 'Cancel';
                    break;
                default:
                    $statusClass = 'badge badge-secondary';
                    break;
            }
            
            return '<span class="' . $statusClass . '">' . $statusText . '</span>';
        })
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idbooking="' . $row->idbooking . '"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';

            // Tombol cek bukti booking online
            $buttonCekBukti = '';
            if (isset($row->online) && $row->online == 1) {
                if ($row->status == 'diproses') {
                    $buttonCekBukti = '<button type="button" class="btn btn-warning btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Verifikasi</button>';
                } else if ($row->status == 'diterima') {
                    $buttonCekBukti = '<button type="button" class="btn btn-success btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Bukti</button>';
                } else {
                    $buttonCekBukti = '<button type="button" class="btn btn-info btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-image"></i> Bukti</button>';
                }
            }

            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $buttonCekBukti . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->edit('tglcheckin', function ($row) {
            return date('d-m-Y', strtotime($row->tglcheckin));
        })
        ->addNumbering()
        ->hide('online')
        ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $today = date('Ymd');
        $query = $db->query("SELECT MAX(SUBSTRING(idbooking, 12, 4)) AS max_no FROM reservasi WHERE SUBSTRING(idbooking, 4, 8) = '$today'");
        $row = $query->getRow();
        $nextNo = ($row && $row->max_no) ? (int)$row->max_no + 1 : 1;
        $next_id = 'RS-' . $today . '-' . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
        $data = [
            'next_id' => $next_id
        ];
        return view('reservasi/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $tglcheckin = $this->request->getPost('tglcheckin');
            $tglcheckout = $this->request->getPost('tglcheckout');
            $lama = $this->request->getPost('lama');
            $tipebayar = $this->request->getPost('tipebayar');
            $nik = $this->request->getPost('nik');
            $harga = $this->request->getPost('harga');
            $idkamar = $this->request->getPost('idkamar');
            
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
                
                // Simpan data reservasi
                $dataReservasi = [
                    'idbooking' => $idbooking,
                    'tglcheckin' => $tglcheckin,
                    'tglcheckout' => $tglcheckout,
                    'nik' => $nik,
                    'idkamar' => $idkamar,
                    'lama' => $lama,
                    'harga' => $harga,
                    'tipebayar' => $tipebayar,
                    'status' => 'diterima',
                    'online' => 0
                ];
                
                $db->table('reservasi')->insert($dataReservasi);
                
                // Update status kamar menjadi tidak tersedia
                $db->table('kamar')->where('id_kamar', $idkamar)->update(['status_kamar' => 'tidak tersedia']);
                
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

        return view('reservasi/getkamar');
    }

    public function viewGetKamar()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $kamar = $db->table('kamar')
                ->select('id_kamar, nama as nama_kamar, harga,dp, status_kamar')
                ->where('status_kamar', 'tersedia');

            return DataTable::of($kamar)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihkamar" data-id_kamar="' . $row->id_kamar . '" data-nama_kamar="' . esc($row->nama_kamar) . '" data-harga="' . esc($row->harga) . '" data-dp="' . esc($row->dp) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->edit('status_kamar', function ($row) {
                    return $row->status_kamar == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia';
                })
                ->addNumbering()
                ->toJson();
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');

            $db = db_connect();
            
            // Dapatkan ID kamar sebelum menghapus reservasi
            $reservasi = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRow();
            
            if ($reservasi) {
                $idkamar = $reservasi->idkamar;
                
                // Hapus reservasi
                $db->table('reservasi')->where('idbooking', $idbooking)->delete();
                
                // Update status kamar menjadi tersedia
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
            $tglcheckin = $this->request->getPost('tglcheckin');
            $tglcheckout = $this->request->getPost('tglcheckout');
            $lama = $this->request->getPost('lama');
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
                $db = db_connect();
                
                // Data untuk update
                $dataUpdate = [
                    'tglcheckin' => $tglcheckin,
                    'tglcheckout' => $tglcheckout,
                    'lama' => $lama,
                    'tipebayar' => $tipebayar,
                    'status' => $status
                ];
                
                // Update data reservasi
                $db->table('reservasi')->where('idbooking', $idbooking)->update($dataUpdate);
                
                // Jika status adalah 'selesai', update status kamar menjadi tersedia
                if ($status === 'selesai') {
                    $reservasi = $db->table('reservasi')->where('idbooking', $idbooking)->get()->getRow();
                    if ($reservasi) {
                        $db->table('kamar')->where('id_kamar', $reservasi->idkamar)->update(['status_kamar' => 'tersedia']);
                    }
                }
                
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
}