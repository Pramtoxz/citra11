<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Jenis as ModelsJenis;
use Hermawan\DataTables\DataTable;

class JenisController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Jenis Perawatan'
        ];
        return view('jenis/datajenis', $title);
    }

    public function viewJenis()
    {
        $db = db_connect();
        $query = $db->table('jenis_perawatan')
                    ->select('idjenis, namajenis, estimasi, harga');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idjenis="' . $row->idjenis . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idjenis="' . $row->idjenis . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idjenis="' . $row->idjenis . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->edit('harga', function ($row) {
            return 'Rp ' . number_format($row->harga, 0, ',', '.');
        })
        ->addNumbering()
        ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('JN', LPAD(IFNULL(MAX(SUBSTRING(idjenis, 3)) + 1, 1), 4, '0')) AS next_number FROM jenis_perawatan");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        $data = [
            'next_number' => $next_number,
        ];
        return view('jenis/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idjenis = $this->request->getPost('idjenis');
            $namajenis = $this->request->getPost('namajenis');
            $estimasi = $this->request->getPost('estimasi');
            $harga = $this->request->getPost('harga');
            $keterangan = $this->request->getPost('keterangan');

            $rules = [
                'namajenis' => [
                    'label' => 'Nama Jenis',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'estimasi' => [
                    'label' => 'Estimasi',
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
                $modelJenis = new ModelsJenis();
                $modelJenis->insert([
                    'idjenis' => $idjenis,
                    'namajenis' => $namajenis,
                    'estimasi' => $estimasi,
                    'harga' => $harga,
                    'keterangan' => $keterangan
                ]);

                $json = [
                    'sukses' => 'Data Jenis Perawatan berhasil disimpan'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idjenis = $this->request->getPost('idjenis');

            $model = new ModelsJenis();
            $model->where('idjenis', $idjenis)->delete();

            $json = [
                'sukses' => 'Data Jenis Perawatan berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idjenis)
    {
        $modelJenis = new ModelsJenis();
        $jenis = $modelJenis->find($idjenis);

        if (!$jenis) {
            return redirect()->to('/jenis')->with('error', 'Data Jenis Perawatan tidak ditemukan');
        }
        
        $data = [
            'jenis' => $jenis
        ];

        return view('jenis/formedit', $data);
    }

    public function updatedata($idjenis)
    {
        if ($this->request->isAJAX()) {
            $namajenis = $this->request->getPost('namajenis');
            $estimasi = $this->request->getPost('estimasi');
            $harga = $this->request->getPost('harga');
            $keterangan = $this->request->getPost('keterangan');
            
            $rules = [
                'namajenis' => [
                    'label' => 'Nama Jenis',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'estimasi' => [
                    'label' => 'Estimasi',
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
                $model = new ModelsJenis();
                $dataUpdate = [
                    'namajenis' => $namajenis,
                    'estimasi' => $estimasi,
                    'harga' => $harga,
                    'keterangan' => $keterangan
                ];
                
                $model->update($idjenis, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data Jenis Perawatan berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
    
    public function detail($idjenis)
    {
        $db = db_connect();
        $jenis = $db->table('jenis_perawatan')
            ->select('*')
            ->where('idjenis', $idjenis)
            ->get()
            ->getRowArray();

        if (!$jenis) {
            return redirect()->back()->with('error', 'Data jenis perawatan tidak ditemukan');
        }

        $data = [
            'jenis' => $jenis
        ];

        return view('jenis/detail', $data);
    }
}
