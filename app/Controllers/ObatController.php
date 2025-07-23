<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Obat as ModelsObat;
use Hermawan\DataTables\DataTable;

class ObatController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Obat'
        ];
        return view('obat/dataobat', $title);
    }

    public function viewObat()
    {
        $db = db_connect();
        $query = $db->table('obat')
                    ->select('idobat, nama, stok, jenis');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idobat="' . $row->idobat . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idobat="' . $row->idobat . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idobat="' . $row->idobat . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->addNumbering()
        ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('OB', LPAD(IFNULL(MAX(SUBSTRING(idobat, 3)) + 1, 1), 4, '0')) AS next_number FROM obat");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        $data = [
            'next_number' => $next_number,
        ];
        return view('obat/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idobat = $this->request->getPost('idobat');
            $nama = $this->request->getPost('nama');
            $stok = $this->request->getPost('stok');
            $jenis = $this->request->getPost('jenis');
            $keterangan = $this->request->getPost('keterangan');

            $rules = [
                'nama' => [
                    'label' => 'Nama Obat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'stok' => [
                    'label' => 'Stok',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
                'jenis' => [
                    'label' => 'Jenis Obat',
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
                $modelObat = new ModelsObat();
                $modelObat->insert([
                    'idobat' => $idobat,
                    'nama' => $nama,
                    'stok' => $stok,
                    'jenis' => $jenis,
                    'keterangan' => $keterangan
                ]);

                $json = [
                    'sukses' => 'Data Obat berhasil disimpan'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idobat = $this->request->getPost('idobat');

            $model = new ModelsObat();
            $model->where('idobat', $idobat)->delete();

            $json = [
                'sukses' => 'Data Obat berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idobat)
    {
        $modelObat = new ModelsObat();
        $obat = $modelObat->find($idobat);

        if (!$obat) {
            return redirect()->to('/obat')->with('error', 'Data Obat tidak ditemukan');
        }
        
        $data = [
            'obat' => $obat
        ];

        return view('obat/formedit', $data);
    }

    public function updatedata($idobat)
    {
        if ($this->request->isAJAX()) {
            $nama = $this->request->getPost('nama');
            $stok = $this->request->getPost('stok');
            $jenis = $this->request->getPost('jenis');
            $keterangan = $this->request->getPost('keterangan');
            
            $rules = [
                'nama' => [
                    'label' => 'Nama Obat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'stok' => [
                    'label' => 'Stok',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
                'jenis' => [
                    'label' => 'Jenis Obat',
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
                $model = new ModelsObat();
                $dataUpdate = [
                    'nama' => $nama,
                    'stok' => $stok,
                    'jenis' => $jenis,
                    'keterangan' => $keterangan
                ];
                
                $model->update($idobat, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data Obat berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }
    
    public function detail($idobat)
    {
        $db = db_connect();
        $obat = $db->table('obat')
            ->select('*')
            ->where('idobat', $idobat)
            ->get()
            ->getRowArray();

        if (!$obat) {
            return redirect()->back()->with('error', 'Data obat tidak ditemukan');
        }

        $data = [
            'obat' => $obat
        ];

        return view('obat/detail', $data);
    }
} 