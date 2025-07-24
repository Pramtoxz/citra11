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
        $builder = $db->table('kamar')->select('id_kamar, nama, harga, status_kamar');

        return DataTable::of($builder)
            ->addNumbering()
            ->edit('status_kamar', function ($row) {
                return $row->status_kamar === 'tersedia' ? '<span class="badge bg-success">Tersedia</span>' : '<span class="badge bg-danger">Terisi</span>';
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
            $rules = [
                'id_kamar' => 'required|is_unique[kamar.id_kamar]',
                'nama' => 'required',
                'harga' => 'required|numeric',
                'status_kamar' => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $this->validator->getErrors()]);
            }

            $model = new Kamar();
            $model->insert([
                'id_kamar' => $this->request->getPost('id_kamar'),
                'nama' => $this->request->getPost('nama'),
                'harga' => $this->request->getPost('harga'),
                'status_kamar' => $this->request->getPost('status_kamar')
            ]);

            return $this->response->setJSON(['sukses' => 'Data kamar berhasil disimpan']);
        }
    }

    public function formedit($id_kamar)
    {
        $model = new Kamar();
        $kamar = $model->find($id_kamar);

        if (!$kamar) {
            return redirect()->to('/kamar')->with('error', 'Data kamar tidak ditemukan');
        }

        return view('kamar/formedit', ['kamar' => $kamar]);
    }

    public function updatedata($id_kamar)
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'nama' => 'required',
                'harga' => 'required|numeric',
                'status_kamar' => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $this->validator->getErrors()]);
            }

            $model = new Kamar();
            $model->update($id_kamar, [
                'nama' => $this->request->getPost('nama'),
                'harga' => $this->request->getPost('harga'),
                'status_kamar' => $this->request->getPost('status_kamar')
            ]);

            return $this->response->setJSON(['sukses' => 'Data kamar berhasil diupdate']);
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
