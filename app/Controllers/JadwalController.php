<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jadwal as ModelsJadwal;
use App\Models\Dokter;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class JadwalController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Jadwal'
        ];
        return view('jadwal/datajadwal', $title);
    }

    public function viewJadwal()
    {
        $db = db_connect();
        $query = $db->table('jadwal')
                    ->select('jadwal.idjadwal, dokter.nama as nama_dokter, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, jadwal.is_active')
                    ->join('dokter', 'dokter.id_dokter = jadwal.iddokter');

        return DataTable::of($query)
        ->edit('is_active', function ($row) {
            return $row->is_active == 1 ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>';
        })
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idjadwal="' . $row->idjadwal . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idjadwal="' . $row->idjadwal . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idjadwal="' . $row->idjadwal . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tombol toggle status
            $statusIcon = $row->is_active == 1 ? 'fa-toggle-on text-success' : 'fa-toggle-off text-secondary';
            $button4 = '<button type="button" class="btn btn-light btn-sm btn-toggle-status" data-idjadwal="' . $row->idjadwal . '" data-status="' . $row->is_active . '" style="margin-left: 5px;"><i class="fas ' . $statusIcon . '"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->addNumbering()
        ->toJson();
    }

    public function formtambah()
    {

        $db = db_connect();
        $query = $db->query("SELECT CONCAT('JW', LPAD(IFNULL(MAX(SUBSTRING(idjadwal, 3)) + 1, 1), 4, '0')) AS next_number FROM jadwal");
        $row = $query->getRow();
        $next_number = $row->next_number;
        $dokterModel = new Dokter();
        $dokter = $dokterModel->findAll();
        
        $data = [
            'dokter' => $dokter,
            'next_number' => $next_number,
        ];
        return view('jadwal/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $iddokter = $this->request->getPost('iddokter');
            $hari = $this->request->getPost('hari');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $is_active = $this->request->getPost('is_active');

            $rules = [
                'iddokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'waktu_mulai' => [
                    'label' => 'Waktu Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_selesai' => [
                    'label' => 'Waktu Selesai',
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
                $modelJadwal = new ModelsJadwal();
                $modelJadwal->insert([
                    'iddokter' => $iddokter,
                    'hari' => $hari,
                    'waktu_mulai' => $waktu_mulai,
                    'waktu_selesai' => $waktu_selesai,
                    'is_active' => $is_active
                ]);

                $json = [
                    'sukses' => 'Jadwal berhasil disimpan'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');

            $model = new ModelsJadwal();
            $model->where('idjadwal', $idjadwal)->delete();

            $json = [
                'sukses' => 'Jadwal berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idjadwal)
    {
        $modelJadwal = new ModelsJadwal();
        $jadwal = $modelJadwal->find($idjadwal);

        if (!$jadwal) {
            return redirect()->to('/jadwal')->with('error', 'Data Jadwal tidak ditemukan');
        }
        
        $dokterModel = new Dokter();
        $dokter = $dokterModel->findAll();
        
        $data = [
            'jadwal' => $jadwal,
            'dokter' => $dokter
        ];

        return view('jadwal/formedit', $data);
    }

    public function updatedata($idjadwal)
    {
        if ($this->request->isAJAX()) {
            $iddokter = $this->request->getPost('iddokter');
            $hari = $this->request->getPost('hari');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $is_active = $this->request->getPost('is_active');
            
            $rules = [
                'iddokter' => [
                    'label' => 'Dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'hari' => [
                    'label' => 'Hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'waktu_mulai' => [
                    'label' => 'Waktu Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_selesai' => [
                    'label' => 'Waktu Selesai',
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
                $model = new ModelsJadwal();
                $dataUpdate = [
                    'iddokter' => $iddokter,
                    'hari' => $hari,
                    'waktu_mulai' => $waktu_mulai,
                    'waktu_selesai' => $waktu_selesai,
                    'is_active' => $is_active
                ];
                
                $model->update($idjadwal, $dataUpdate);
                
                $json = [
                    'sukses' => 'Jadwal berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
    
    public function detail($idjadwal)
    {
        $db = db_connect();
        $jadwal = $db->table('jadwal')
            ->select('jadwal.*, dokter.nama')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->where('jadwal.idjadwal', $idjadwal)
            ->get()
            ->getRowArray();

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Data jadwal tidak ditemukan');
        }

        $data = [
            'jadwal' => $jadwal,
            'dokter' => [
                'nama' => $jadwal['nama']
            ]
        ];

        return view('jadwal/detail', $data);
    }
    
    public function toggleStatus()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $status = $this->request->getPost('status');
            
            // Ubah status: 0 menjadi 1, 1 menjadi 0
            $newStatus = ($status == 1) ? 0 : 1;
            
            $model = new ModelsJadwal();
            $updated = $model->update($idjadwal, ['is_active' => $newStatus]);
            
            if ($updated) {
                $message = $newStatus == 1 ? 'Jadwal berhasil diaktifkan' : 'Jadwal berhasil dinonaktifkan';
                return $this->response->setJSON([
                    'sukses' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'Gagal mengubah status jadwal'
                ]);
            }
        }
    }


    public function getDokter()
    {

        return view('jadwal/getdokter');
    }

    public function viewGetDokter()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $dokter = $db->table('dokter')
                ->select('id_dokter, nama,jenkel,tgllahir,nohp');
            return DataTable::of($dokter)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihdokter" data-id_dokter="' . $row->id_dokter . '" data-nama_dokter="' . esc($row->nama) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->edit('jenkel', function ($row) {
                    return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->edit('tgllahir', function ($row) {
                    return date('d-m-Y', strtotime($row->tgllahir));
                })
                ->addNumbering()
                ->toJson();
        }
    }
}
