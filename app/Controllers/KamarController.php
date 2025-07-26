<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kamar;
use Hermawan\DataTables\DataTable;

class KamarController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Data Kamar'
        ];
        return view('kamar/datakamar', $data); // View kamu simpan di app/Views/kamar/data.php
    }

    public function viewKamar()
    {
        $db = db_connect();
        $builder = $db->table('kamar')->select('id_kamar, nama, harga, dp,status_kamar');

        return DataTable::of($builder)
            ->addNumbering()
            ->edit('status_kamar', function ($row) {
                return $row->status_kamar === 'tersedia' ? '<span class="badge bg-success">Tersedia</span>' : '<span class="badge bg-danger">Terisi</span>';
            })
            ->edit('harga', function ($row) {
                return 'Rp. ' . number_format($row->harga, 0, ',', '.');
            })
            ->edit('dp', function ($row) {
                return 'Rp. ' . number_format($row->dp, 0, ',', '.');
            })
            ->add('action', function ($row) {
                return '
                    <button type="button" class="btn btn-info btn-sm btn-detail" data-id="' . $row->id_kamar . '"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id_kamar . '"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id_kamar . '"><i class="fas fa-trash-alt"></i></button>
                ';
            }, 'last')
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('KM', LPAD(IFNULL(MAX(SUBSTRING(id_kamar, 3)) + 1, 1), 4, '0')) AS next_id FROM kamar");
        $row = $query->getRow();
        $data = [
            'next_id' => $row->next_id
        ];
        return view('kamar/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $id_kamar = $this->request->getPost('id_kamar');
            $nama = $this->request->getPost('nama');
            $harga = $this->request->getPost('harga');
            $status_kamar = $this->request->getPost('status_kamar');
            $deskripsi = $this->request->getPost('deskripsi');
            $cover = $this->request->getFile('cover');
            $dp = $this->request->getPost('dp');
            $rules = [
                'nama' => [
                    'label' => 'Nama kamar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kamar' => [
                    'label' => 'Status Kamar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'cover' => [
                    'label' => 'Foto',
                    'rules' => 'mime_in[cover,image/jpg,image/jpeg,image/gif,image/png]|max_size[cover,4096]', 
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 4MB'
                    ]
                ],
                'dp' => [
                    'label' => 'DP',
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
                if ($cover->isValid() && !$cover->hasMoved()) {
                    $newName = 'cover-' . date('Ymd') . '-' . $id_kamar . '.' . $cover->getClientExtension();
                    $cover->move('assets/img/kamar', $newName);

                    $modelKamar = new Kamar();
                    $modelKamar->insert([
                        'id_kamar' => $id_kamar,
                        'nama' => $nama,
                        'harga' => $harga,
                        'status_kamar' => $status_kamar,
                        'deskripsi' => $deskripsi,
                        'cover' => $newName,
                        'dp' => $dp,
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Simpan Data'
                    ];
                } else {
                    $json = [
                        'error' => ['cover' => $cover->getErrorString() . '(' . $cover->getError() . ')']
                    ];
                }
            }
            echo json_encode($json);
        }
    }

    public function formedit($id_kamar)
    {
        $model = new Kamar();
        $kamar = $model->find($id_kamar);

        if (!$kamar) {
            return redirect()->to('/kamar')->with('error', 'Data Kamar tidak ditemukan');
        }
        
        $data = [
            'kamar' => $kamar
        ];

        return view('kamar/formedit', $data);
    }

    public function updatedata($id_kamar)
    {
        if ($this->request->isAJAX()) {
            $id_kamar = $this->request->getPost('id_kamar');
            $nama = $this->request->getPost('nama');
            $harga = $this->request->getPost('harga');
            $status_kamar = $this->request->getPost('status_kamar');
            $deskripsi = $this->request->getPost('deskripsi');
            $cover = $this->request->getFile('cover');
            $dp = $this->request->getPost('dp');
            $rules = [
                'nama' => [
                    'label' => 'Nama kamar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'harga' => [
                    'label' => 'Harga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kamar' => [
                    'label' => 'Status Kamar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'cover' => [
                    'label' => 'Foto',
                    'rules' => 'mime_in[cover,image/jpg,image/jpeg,image/gif,image/png]|max_size[cover,4096]',
                    'errors' => [
                        'mime_in' => 'File harus berformat jpg, jpeg, atau png',
                        'max_size' => 'Ukuran file maksimal adalah 4MB'
                    ]
                ],
                'dp' => [
                    'label' => 'DP',
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
                $model = new Kamar();
                $dataKamar = $model->where('id_kamar', $id_kamar)->first();
                
                if ($cover->isValid() && !$cover->hasMoved()) {
                    $random = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
                    $newName = 'cover-' . date('Ymd') . '-' . $id_kamar . '.' . $random . '.' . $cover->getClientExtension();
                    $cover->move('assets/img/kamar', $newName);

                    // Hapus foto lama jika ada
                    if (!empty($dataKamar['cover']) && file_exists('assets/img/kamar/' . $dataKamar['cover'])) {
                        unlink('assets/img/kamar/' . $dataKamar['cover']);
                    }

                    $dataUpdate = [
                        'nama' => $nama,
                        'harga' => $harga,
                        'status_kamar' => $status_kamar,
                        'deskripsi' => $deskripsi,
                        'cover' => $newName,
                        'dp' => $dp,
                    ];
                } else {
                    $dataUpdate = [
                        'nama' => $nama,
                        'harga' => $harga,
                        'status_kamar' => $status_kamar,
                        'deskripsi' => $deskripsi,
                        'dp' => $dp,
                    ];

                    // Jika update tanpa mengubah foto, tetap gunakan foto yang ada (jika ada)
                    if (isset($dataKamar['cover'])) {
                        $dataUpdate['cover'] = $dataKamar['cover'];
                    }
                }
                
                $model->update($id_kamar, $dataUpdate);
                
                // Update password jika ada
                if (!empty($password) && !empty($dataKamar['iduser'])) {
                    $userModel = new \App\Models\UserModel();
                    $userModel->save([
                        'id' => $dataKamar['iduser'],
                        'password' => $password
                    ]);
                }
                
                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_kamar = $this->request->getPost('id_kamar');
            $model = new Kamar();
            $model->delete($id_kamar);

            return $this->response->setJSON(['sukses' => 'Data kamar berhasil dihapus']);
        }
    }

    public function detail($id_kamar)
    {
        $model = new Kamar();
        $kamar = $model->find($id_kamar);

        if (!$kamar) {
            return redirect()->back()->with('error', 'Data kamar tidak ditemukan');
        }

        return view('kamar/detail', ['kamar' => $kamar]);
    }
}
