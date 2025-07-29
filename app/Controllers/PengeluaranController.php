<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengeluaran;
use Hermawan\DataTables\DataTable;

class PengeluaranController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Data Pengeluaran'
        ];
        return view('pengeluaran/datapengeluaran', $data);
    }

    public function viewPengeluaran()
    {
        $db = db_connect();
        $builder = $db->table('pengeluaran')->select('id, tgl, keterangan, total');

        return DataTable::of($builder)
            ->addNumbering()
            ->edit('tgl', function ($row) {
                return date('d-m-Y', strtotime($row->tgl));
            })
            ->edit('total', function ($row) {
                return 'Rp ' . number_format($row->total, 0, ',', '.');
            })
            ->add('action', function ($row) {
                return '
                    <button type="button" class="btn btn-info btn-sm btn-detail" data-id="' . $row->id . '"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="' . $row->id . '"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '"><i class="fas fa-trash-alt"></i></button>
                ';
            }, 'last')
            ->hide('id')
            ->toJson();
    }

    public function formtambah()
    {
        // Buat ID otomatis jika perlu (contoh: "PG0001")
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PG', LPAD(IFNULL(MAX(SUBSTRING(id, 3)) + 1, 1), 4, '0')) AS next_id FROM pengeluaran");
        $row = $query->getRow();
        $data = [
            'next_id' => $row->next_id
        ];
        return view('pengeluaran/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'tgl' => 'required|valid_date',
                'keterangan' => 'required',
                'total' => 'required|numeric'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $this->validator->getErrors()]);
            }

            $model = new Pengeluaran();
            $model->insert([
                'tgl' => $this->request->getPost('tgl'),
                'keterangan' => $this->request->getPost('keterangan'),
                'total' => $this->request->getPost('total')
            ]);

            return $this->response->setJSON(['sukses' => 'Data pengeluaran berhasil disimpan']);
        }
    }

    public function formedit($id)
    {
        $model = new Pengeluaran();
        $pengeluaran = $model->find($id);

        if (!$pengeluaran) {
            return redirect()->to('/pengeluaran')->with('error', 'Data pengeluaran tidak ditemukan');
        }

        return view('pengeluaran/formedit', ['pengeluaran' => $pengeluaran]);
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'tgl' => 'required|valid_date',
                'keterangan' => 'required',
                'total' => 'required|numeric'
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['error' => $this->validator->getErrors()]);
            }

            $model = new Pengeluaran();
            $model->update($id, [
                'tgl' => $this->request->getPost('tgl'),
                'keterangan' => $this->request->getPost('keterangan'),
                'total' => $this->request->getPost('total')
            ]);

            return $this->response->setJSON(['sukses' => 'Data pengeluaran berhasil diperbarui']);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $model = new Pengeluaran();
            $model->delete($id);

            return $this->response->setJSON(['sukses' => 'Data pengeluaran berhasil dihapus']);
        }
    }

    public function detail($id)
    {
        $model = new Pengeluaran();
        $pengeluaran = $model->find($id);

        if (!$pengeluaran) {
            return redirect()->back()->with('error', 'Data pengeluaran tidak ditemukan');
        }

        return view('pengeluaran/detail', ['pengeluaran' => $pengeluaran]);
    }
}
