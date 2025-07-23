<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Dokter as ModelsDokter;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class DokterController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Dokter'
        ];
        return view('dokter/datadokter', $title);
    }

    public function viewDokter()
    {
        $db = db_connect();
        $query = $db->table('dokter')
                    ->select('id_dokter, nama, nohp, jenkel, iduser');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-id_dokter="' . $row->id_dokter . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-id_dokter="' . $row->id_dokter . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id_dokter="' . $row->id_dokter . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tambahkan tombol kunci untuk membuat user jika iduser NULL
            $button4 = '';
            if ($row->iduser === null) {
                $button4 = '<button type="button" class="btn btn-warning btn-sm btn-create-user" data-id_dokter="' . $row->id_dokter . '" data-toggle="modal" data-target="#createUserModal" style="margin-left: 5px;"><i class="fas fa-key"></i></button>';
            }
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('jenkel', function ($row) {
                return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addNumbering()
            ->hide('iduser')
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PS', LPAD(IFNULL(MAX(SUBSTRING(id_dokter, 3)) + 1, 1), 4, '0')) AS next_number FROM dokter");
        $row = $query->getRow();
        $next_number = $row->next_number;
        $data = [
            'next_number' => $next_number,
        ];
        return view('dokter/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $id_dokter = $this->request->getPost('id_dokter');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');

            $rules = [
                'nama' => [
                    'label' => 'Nama dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgllahir' => [
                    'label' => 'Tanggal Lahir',
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
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $newName = 'foto-' . date('Ymd') . '-' . $id_dokter . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/dokter', $newName);

                    $modelDokter = new ModelsDokter();
                    $modelDokter->insert([
                        'id_dokter' => $id_dokter,
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                        'foto' => $newName,
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Simpan Data'
                    ];
                } else {
                    $json = [
                        'error' => ['foto' => $foto->getErrorString() . '(' . $foto->getError() . ')']
                    ];
                }
            }
            echo json_encode($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_dokter = $this->request->getPost('id_dokter');

            $model = new ModelsDokter();
            $model->where('id_dokter', $id_dokter)->delete();

            $json = [
                'sukses' => 'Data Dokter Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($id_dokter)
    {
        $model = new ModelsDokter();
        $dokter = $model->find($id_dokter);

        if (!$dokter) {
            return redirect()->to('/dokter')->with('error', 'Data Dokter tidak ditemukan');
        }
        
        $user = null;
        if (!empty($dokter['iduser'])) {
            $userModel = new UserModel();
            $user = $userModel->find($dokter['iduser']);
        }
        
        $data = [
            'dokter' => $dokter,
            'user' => $user
        ];

        return view('dokter/formedit', $data);
    }

    public function updatedata($id_dokter)
    {
        if ($this->request->isAJAX()) {
            $id_dokter = $this->request->getPost('id_dokter');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jenkel = $this->request->getPost('jenkel');
            $tgllahir = $this->request->getPost('tgllahir');
            $foto = $this->request->getFile('cover');
            $password = $this->request->getPost('password');
            
            $rules = [
                'nama' => [
                    'label' => 'Nama dokter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgllahir' => [
                    'label' => 'Tanggal Lahir',
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
                'password' => [
                    'label' => 'Password',
                    'rules' => 'permit_empty|min_length[6]',
                    'errors' => [
                        'min_length' => 'Password minimal 6 karakter'
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
                $model = new ModelsDokter();
                $dataDokter = $model->where('id_dokter', $id_dokter)->first();
                
                if ($foto->isValid() && !$foto->hasMoved()) {
                    $newName = 'foto-' . date('Ymd') . '-' . $id_dokter . '.' . $foto->getClientExtension();
                    $foto->move('assets/img/dokter', $newName);

                    // Hapus foto lama jika ada
                    if (!empty($dataDokter['foto']) && file_exists('assets/img/dokter/' . $dataDokter['foto'])) {
                        unlink('assets/img/dokter/' . $dataDokter['foto']);
                    }

                    $dataUpdate = [
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                        'foto' => $newName,
                    ];
                } else {
                    $dataUpdate = [
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'nohp' => $nohp,
                        'jenkel' => $jenkel,
                        'tgllahir' => $tgllahir,
                    ];
                    
                    // Jika update tanpa mengubah foto, tetap gunakan foto yang ada (jika ada)
                    if (isset($dataDokter['foto'])) {
                        $dataUpdate['foto'] = $dataDokter['foto'];
                    }
                }
                
                $model->update($id_dokter, $dataUpdate);
                
                // Update password jika ada
                if (!empty($password) && !empty($dataDokter['iduser'])) {
                    $userModel = new \App\Models\UserModel();
                    $userModel->save([
                        'id' => $dataDokter['iduser'],
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
    public function detail($id_dokter)
    {
        $db = db_connect();
        $dokter = $db->table('dokter')->select('*')
        ->where('id_dokter', $id_dokter)->get()->getRowArray();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Data dokter tidak ditemukan');
        }

        $data = [
            'dokter' => $dokter
        ];

        return view('dokter/detail', $data);
}

    public function createUser($id_dokter = null)
    {
        // Pastikan id_dokter tidak null
        if ($id_dokter === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Dokter tidak ditemukan'
            ]);
        }
        
        $dokterModel = new ModelsDokter();
        $userModel = new UserModel();
        $dokter = $dokterModel->find($id_dokter);
        
        if (!$dokter) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Dokter tidak ditemukan'
            ]);
        }
        
        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'min_length' => 'Username minimal 5 karakter',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah digunakan'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        // Buat user baru
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'user',
            'status' => 'active'
        ];
        
        $userModel->insert($userData);
        $userId = $userModel->getInsertID();
        
        // Update data dokter dengan ID user baru
        $dokterModel->update($id_dokter, ['iduser' => $userId]);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Akun user untuk dokter berhasil dibuat'
        ]);
    }
    
    public function updatePassword($id_dokter = null)
    {
        // Pastikan id_dokter tidak null
        if ($id_dokter === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Dokter tidak ditemukan'
            ]);
        }
        
        $dokterModel = new ModelsDokter();
        $userModel = new UserModel();
        $dokter = $dokterModel->find($id_dokter);
        
        if (!$dokter) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data dokter tidak ditemukan'
            ]);
        }
        
        if (!$dokter['iduser']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Dokter belum memiliki akun user'
            ]);
        }
        
        // Validasi input
        $rules = [
            'password' => [
                'rules' => 'permit_empty|min_length[6]',
                'errors' => [
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        $password = $this->request->getPost('password');
        
        // Jika password kosong, abaikan update password
        if (empty($password)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Tidak ada perubahan pada password'
            ]);
        }
        
        // Update password user
        $userData = [
            'id' => $dokter['iduser'],
            'password' => $password
        ];
        
        $userModel->save($userData);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
