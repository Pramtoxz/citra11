<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tamu as ModelsTamu;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class TamuController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Tamu'
        ];
        return view('tamu/datatamu', $title);
    }

    public function viewTamu()
    {
        $db = db_connect();
        $query = $db->table('tamu')
            ->select('nik, nama, nohp, jk, iduser');

        return DataTable::of($query)
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-nik="' . $row->nik . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-nik="' . $row->nik . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-nik="' . $row->nik . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';

                // Tambahkan tombol kunci untuk membuat user jika iduser NULL
                $button4 = '';
                if ($row->iduser === null) {
                    $button4 = '<button type="button" class="btn btn-warning btn-sm btn-create-user" data-nik="' . $row->nik . '" data-toggle="modal" data-target="#createUserModal" style="margin-left: 5px;"><i class="fas fa-key"></i></button>';
                }

                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $button4 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->edit('jk', function ($row) {
                return $row->jk == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addNumbering()
            ->hide('iduser')
            ->toJson();
    }

    public function formtambah()
    {
        $title ='Form Tambah Tamu';
        $data = [
            'title' => $title,
        ];
        return view('tamu/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('nik');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jk = $this->request->getPost('jk');

            $rules = [
                'nama' => [
                    'label' => 'Nama Tamu',
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
                'jk' => [
                    'label' => 'Jenkel',
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
                $modelTamu = new ModelsTamu();
                $modelTamu->insert([
                    'nik' => $nik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                    'jk' => $jk,
                ]);

                $json = [
                    'sukses' => 'Berhasil Simpan Data'
                ];
            }

            return $this->response->setJSON($json); // Lebih rapi pakai setJSON
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid' // respon default kalau bukan AJAX
            ]);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('nik');

            $model = new ModelsTamu();
            $model->where('nik', $nik)->delete();

            $json = [
                'sukses' => 'Data Tamu Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($nik)
    {
        $db = db_connect();
        
        // Join tabel tamu dengan users untuk mendapatkan email
        $tamu = $db->table('tamu')
            ->select('tamu.*, users.email, users.username')
            ->join('users', 'users.id = tamu.iduser', 'left')
            ->where('tamu.nik', $nik)
            ->get()
            ->getRowArray();

        if (!$tamu) {
            return redirect()->to('/tamu')->with('error', 'Data Tamu tidak ditemukan');
        }

        $data = [
            'tamu' => $tamu
        ];

        return view('tamu/formedit', $data);
    }

    public function updatedata($tamu)
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('nik');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jk = $this->request->getPost('jk');
            $password = $this->request->getPost('password');

            $rules = [
                'nama' => [
                    'label' => 'Nama tamu',
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
                'jk' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                $model = new ModelsTamu();
                $dataTamu = $model->where('nik', $nik)->first();

                $dataUpdate = [
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                    'jk' => $jk,
                ];
            }
            $dataUpdate = [
                'nama' => $nama,
                'alamat' => $alamat,
                'nohp' => $nohp,
                'jk' => $jk,
            ];

            // Jika update tanpa mengubah foto, tetap gunakan foto yang ada (jika ada)
        }

        $model->update($nik, $dataUpdate);

        // Update password jika ada
        if (!empty($password) && !empty($dataTamu['iduser'])) {
            $userModel = new \App\Models\UserModel();
            $userModel->save([
                'id' => $dataTamu['iduser'],
                'password' => $password
            ]);
        }

        $json = [
            'sukses' => 'Data berhasil diupdate'
        ];

        return $this->response->setJSON($json);
    }


    public function detail($nik)
    {
        $db = db_connect();
        $tamu = $db->table('tamu')->select('*')
            ->where('nik', $nik)->get()->getRowArray();

        if (!$tamu) {
            return redirect()->back()->with('error', 'Data tamu tidak ditemukan');
        }

        $data = [
            'tamu' => $tamu
        ];

        return view('tamu/detail', $data);
    }

    public function createUser($nik = null)
    {
        // Cek jika NIK tidak dikirim
        if ($nik === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'NIK tamu tidak ditemukan.'
            ]);
        }

        $tamuModel = new ModelsTamu();
        $userModel = new UserModel();

        // Cari data tamu berdasarkan NIK
        $tamu = $tamuModel->where('nik', $nik)->first();

        if (!$tamu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu dengan NIK tersebut tidak ditemukan.'
            ]);
        }

        // Cegah jika user sudah dibuat sebelumnya
        if (!empty($tamu['iduser'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akun user untuk tamu ini sudah ada.'
            ]);
        }

        // Validasi input
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'min_length' => 'Username minimal 5 karakter.',
                    'is_unique' => 'Username sudah digunakan.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Simpan ke tabel users
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active'
        ];

        $userModel->insert($userData);
        $userId = $userModel->getInsertID();

        // Update tabel tamu dengan ID user yang baru
        $updated = $tamuModel->where('nik', $nik)->set(['iduser' => $userId])->update();

        if (!$updated) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User berhasil dibuat, tetapi gagal mengupdate data tamu.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Akun user untuk tamu berhasil dibuat.'
        ]);
    }


    public function updatePassword($nik = null)
    {
        // Pastikan id_tamu tidak null
        if ($nik === null) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Tamu tidak ditemukan'
            ]);
        }

        $tamuModel = new ModelsTamu();
        $userModel = new UserModel();
        $tamu = $tamuModel->find($nik);

        if (!$tamu) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tamu tidak ditemukan'
            ]);
        }

        if (!$tamu['iduser']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tamu belum memiliki akun user'
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
            'id' => $tamu['iduser'],
            'password' => $password
        ];

        $userModel->save($userData);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
