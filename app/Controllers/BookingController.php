<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking as ModelsBooking;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Perawatan;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;

class BookingController extends BaseController
{

    public function detail($idbooking)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $idbooking)
            ->get()
            ->getRowArray();

       
            if (!$booking) {
                return redirect()->back();
            }
            // Membuat QR Code
            $qrCode = new QrCode($idbooking);
            $qrCode->setSize(300);
            $qrCode->setMargin(10);
    
            $writer = new PngWriter();
            $qrCodeImage = $writer->write($qrCode)->getDataUri();
            $data = [
                'qrCodeImage' => $qrCodeImage,
                'booking' => $booking,
            ];
    
        return view('booking/detail', $data);
    }

    public function index()
    {
        $title = [
            'title' => 'Kelola Data Booking'
        ];
        return view('booking/databooking', $title);
    }

    public function viewBooking()
    {
        $db = db_connect();
        $query = $db->table('booking')
                    ->select('booking.idbooking, booking.tanggal,pasien.nama as nama_pasien,dokter.nama as nama_dokter, booking.waktu_mulai, booking.waktu_selesai, booking.status, booking.online')
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                    ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis');

        return DataTable::of($query)
        ->edit('status', function ($row) {
            $statusClass = '';
            $statusText = ucfirst($row->status);
            
            switch($row->status) {
                case 'pending':
                    $statusClass = 'badge badge-warning';
                    break;
                case 'diproses':
                    $statusClass = 'badge badge-info';
                    break;
                case 'diterima':
                    $statusClass = 'badge badge-success';
                    break;
                case 'diperiksa':
                    $statusClass = 'badge badge-primary';
                    break;
                case 'ditolak':
                    $statusClass = 'badge badge-danger';
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

            // Tombol untuk ubah status
            $buttonApprove = '';
            $buttonReject = '';

            // Tombol cek bukti booking online
            $buttonCekBukti = '';
            if (isset($row->online) && $row->online == 1) {
                // Jika status diproses, tampilkan icon dengan warna berbeda
                if ($row->status == 'diproses') {
                    $buttonCekBukti = '<button type="button" class="btn btn-warning btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Verifikasi</button>';
                } else if ($row->status == 'diterima') {
                    $buttonCekBukti = '<button type="button" class="btn btn-success btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-file-invoice"></i> Bukti</button>';
                } else {
                    $buttonCekBukti = '<button type="button" class="btn btn-info btn-sm btn-cek-bukti" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-image"></i> Bukti</button>';
                }
            }

            if ($row->status == 'pending') {
                $buttonApprove = '<button type="button" class="btn btn-success btn-sm btn-approve" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-check"></i></button>';
                $buttonReject = '<button type="button" class="btn btn-danger btn-sm btn-reject" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-times"></i></button>';
            }

            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $buttonCekBukti . $buttonApprove . $buttonReject . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->edit('tanggal', function ($row) {
            return date('d-m-Y', strtotime($row->tanggal));
        })
        ->addNumbering()
        ->hide('online')
        ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('BK', LPAD(IFNULL(MAX(SUBSTRING(idbooking, 3)) + 1, 1), 4, '0')) AS next_number FROM booking");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data pasien
        $pasienModel = new Pasien();
        $pasien = $pasienModel->findAll();
        
        // Ambil data jadwal
        $jadwalModel = new Jadwal();
        $jadwal = $db->table('jadwal')
                 ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter')
                 ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                 ->where('jadwal.is_active', 1)
                 ->get()->getResultArray();
                 
        // Ambil data jenis perawatan
        $jenisModel = new Jenis();
        $jenis = $jenisModel->findAll();
        
        $data = [
            'next_number' => $next_number,
            'pasien' => $pasien,
            'jadwal' => $jadwal,
            'jenis' => $jenis
        ];
        
        return view('booking/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $id_pasien = $this->request->getPost('id_pasien');
            $idjadwal = $this->request->getPost('idjadwal');
            $idjenis = $this->request->getPost('idjenis');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $status = $this->request->getPost('status');
            $catatan = $this->request->getPost('catatan');
            $bukti_bayar = $this->request->getFile('bukti_bayar');

            $rules = [
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjadwal' => [
                    'label' => 'Jadwal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjenis' => [
                    'label' => 'Jenis Perawatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'tanggal' => [
                    'label' => 'Tanggal Booking',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                ]
            ];
            if ($bukti_bayar && $bukti_bayar->isValid()) {
                $rules['bukti_bayar'] = [
                    'label' => 'Bukti Pembayaran',
                    'rules' => 'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_bayar,2048]',
                    'errors' => [
                        'mime_in' => 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF',
                        'max_size' => 'Ukuran file maksimal 2MB',
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    if ($this->validator->hasError($field)) {
                        $errors["error_$field"] = $this->validator->getError($field);
                    }
                }

                $json = [
                    'error' => $errors
                ];
                return $this->response->setJSON($json);
            }

            // Cek ketersediaan jadwal
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai);

            if (!$isAvailable) {
                $json = [
                    'error' => [
                        'error_jadwal' => 'Jadwal sudah terisi pada waktu tersebut. Silahkan pilih waktu lain.'
                    ]
                ];
                return $this->response->setJSON($json);
            }

            // Proses upload bukti bayar jika ada
            $bukti_bayar_name = null;
            if ($bukti_bayar && $bukti_bayar->isValid() && !$bukti_bayar->hasMoved()) {
                $newName = 'bukti-' . date('Ymd') . '-' . $idbooking . '.' . $bukti_bayar->getClientExtension();
                $bukti_bayar->move('uploads/bukti_bayar', $newName);
                $bukti_bayar_name = $newName;
            }

            $bookingModel->insert([
                'idbooking' => $idbooking,
                'id_pasien' => $id_pasien,
                'idjadwal' => $idjadwal,
                'idjenis' => $idjenis,
                'tanggal' => $tanggal,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'status' => $status ?? 'diterima',
                'bukti_bayar' => $bukti_bayar_name,
                'catatan' => $catatan
            ]);

            $json = [
                'sukses' => 'Booking berhasil disimpan'
            ];
            
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');

            $model = new ModelsBooking();
            
            // Cek apakah ada file bukti bayar yang perlu dihapus
            $booking = $model->find($idbooking);
            if ($booking && !empty($booking['bukti_bayar'])) {
                $filePath = 'uploads/bukti_bayar/' . $booking['bukti_bayar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $model->where('idbooking', $idbooking)->delete();

            $json = [
                'sukses' => 'Data Booking berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idbooking)
    {
        $modelBooking = new ModelsBooking();
        $booking = $modelBooking->find($idbooking);

        if (!$booking) {
            return redirect()->to('/booking')->with('error', 'Data Booking tidak ditemukan');
        }
        
        // Get database connection
        $db = db_connect();
        
        // Get pasien data for the selected booking
        $pasienData = $db->table('pasien')
                       ->where('id_pasien', $booking['id_pasien'])
                       ->get()
                       ->getRowArray();
        
        // Get jadwal data for the selected booking, including dokter name
        $jadwalData = $db->table('jadwal')
                       ->select('jadwal.*, dokter.nama as nama_dokter')
                       ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                       ->where('jadwal.idjadwal', $booking['idjadwal'])
                       ->get()
                       ->getRowArray();
                       
        // Format booking data to include related info
        if ($jadwalData) {
            $booking['jadwal_info'] = $jadwalData['nama_dokter'] . ' - ' . $jadwalData['hari'] . ' ' . 
                                      substr($jadwalData['waktu_mulai'], 0, 5) . ' - ' . 
                                      substr($jadwalData['waktu_selesai'], 0, 5);
        }
        
        if ($pasienData) {
            $booking['pasien_nama'] = $pasienData['nama'];
        }
        
        // Format time values to ensure they're in HH:MM format
        $booking['waktu_mulai'] = substr($booking['waktu_mulai'], 0, 5);
        $booking['waktu_selesai'] = substr($booking['waktu_selesai'], 0, 5);
        
        // Ambil data pasien
        $pasienModel = new Pasien();
        $pasien = $pasienModel->findAll();
        
        // Ambil data jadwal
        $jadwal = $db->table('jadwal')
                 ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter, jadwal.is_active')
                 ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                 ->where('jadwal.is_active', 1)
                 ->get()->getResultArray();
                 
        // Ambil data jenis perawatan
        $jenisModel = new Jenis();
        $jenis = $jenisModel->findAll();
        
        $data = [
            'booking' => $booking,
            'pasien' => $pasien,
            'jadwal' => $jadwal,
            'jenis' => $jenis
        ];
        
        return view('booking/formedit', $data);
    }

    public function updatedata($idbooking)
    {
        if ($this->request->isAJAX()) {
            $id_pasien = $this->request->getPost('id_pasien');
            $idjadwal = $this->request->getPost('idjadwal');
            $idjenis = $this->request->getPost('idjenis');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $status = $this->request->getPost('status');
            $catatan = $this->request->getPost('catatan');
            $bukti_bayar = $this->request->getFile('bukti_bayar');

            $rules = [
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjadwal' => [
                    'label' => 'Jadwal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjenis' => [
                    'label' => 'Jenis Perawatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'tanggal' => [
                    'label' => 'Tanggal Booking',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                ]
            ];

            // Jika bukti_bayar diupload, tambahkan validasi
            if ($bukti_bayar && $bukti_bayar->isValid()) {
                $rules['bukti_bayar'] = [
                    'label' => 'Bukti Pembayaran',
                    'rules' => 'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_bayar,2048]',
                    'errors' => [
                        'mime_in' => 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF',
                        'max_size' => 'Ukuran file maksimal 2MB',
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    if ($this->validator->hasError($field)) {
                        $errors["error_$field"] = $this->validator->getError($field);
                    }
                }

                $json = [
                    'error' => $errors
                ];
                return $this->response->setJSON($json);
            }

            // Cek ketersediaan jadwal
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai, $idbooking);

            if (!$isAvailable) {
                $json = [
                    'error' => [
                        'error_jadwal' => 'Jadwal sudah terisi pada waktu tersebut. Silahkan pilih waktu lain.'
                    ]
                ];
                return $this->response->setJSON($json);
            }

            $dataBooking = $bookingModel->find($idbooking);
            
            // Proses upload bukti bayar jika ada
            $bukti_bayar_name = $dataBooking['bukti_bayar']; // Gunakan yang lama jika tidak ada upload baru
            if ($bukti_bayar && $bukti_bayar->isValid() && !$bukti_bayar->hasMoved()) {
                // Hapus file lama jika ada
                if (!empty($dataBooking['bukti_bayar']) && file_exists('uploads/bukti_bayar/' . $dataBooking['bukti_bayar'])) {
                    unlink('uploads/bukti_bayar/' . $dataBooking['bukti_bayar']);
                }
                
                $newName = 'bukti-' . date('Ymd') . '-' . $idbooking . '.' . $bukti_bayar->getClientExtension();
                $bukti_bayar->move('uploads/bukti_bayar', $newName);
                $bukti_bayar_name = $newName;
            }

            $bookingModel->update($idbooking, [
                'id_pasien' => $id_pasien,
                'idjadwal' => $idjadwal,
                'idjenis' => $idjenis,
                'tanggal' => $tanggal,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'status' => $status,
                'bukti_bayar' => $bukti_bayar_name,
                'catatan' => $catatan
            ]);

            $json = [
                'sukses' => 'Data Booking berhasil diupdate'
            ];
            
            return $this->response->setJSON($json);
        }
    }
    

    
    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $status = $this->request->getPost('status');
            
            if (!in_array($status, ['pending', 'diterima', 'ditolak'])) {
                return $this->response->setJSON([
                    'error' => 'Status tidak valid'
                ]);
            }
            
            $model = new ModelsBooking();
            $updated = $model->update($idbooking, ['status' => $status]);
            
            if ($updated) {
                $message = 'Booking berhasil ' . ($status === 'diterima' ? 'diterima' : 'ditolak');
                return $this->response->setJSON([
                    'sukses' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'Gagal mengubah status booking'
                ]);
            }
        }
    }
    
    public function checkSlotAvailability()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $exclude_id = $this->request->getPost('idbooking'); // Optional untuk edit
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Validasi jadwal
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                       ->where('idjadwal', $idjadwal)
                       ->get()
                       ->getRowArray();
                        
            if (!$jadwal) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => 'Jadwal tidak ditemukan'
                ]);
            }
            
            // Validasi apakah tanggal sesuai dengan hari jadwal dokter
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
            $dayName = $dayNames[$dayOfWeek];
            
            if ($dayName !== $jadwal['hari']) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
                ]);
            }
            
            // Cek apakah waktu berada dalam range jadwal dokter
            if (strtotime($waktu_mulai) < strtotime($jadwal['waktu_mulai']) || 
                strtotime($waktu_selesai) > strtotime($jadwal['waktu_selesai'])) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => "Waktu yang dipilih di luar jam praktik dokter (" . 
                        substr($jadwal['waktu_mulai'], 0, 5) . " - " . 
                        substr($jadwal['waktu_selesai'], 0, 5) . ")"
                ]);
            }
            
            // Validasi apakah waktu sudah lewat untuk hari ini
            $today = date('Y-m-d');
            if ($tanggal == $today) {
                $currentTime = date('H:i:s');
                if ($currentTime > $waktu_mulai) {
                    return $this->response->setJSON([
                        'available' => false,
                        'message' => "Waktu yang dipilih sudah lewat. Silakan pilih waktu lain."
                    ]);
                }
            }
            
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai, $exclude_id);
            
            if ($isAvailable) {
                return $this->response->setJSON([
                    'available' => true,
                    'message' => 'Slot waktu tersedia'
                ]);
            } else {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => 'Slot waktu sudah terisi. Silakan pilih waktu lain.'
                ]);
            }
        }
    }
    
    public function findAvailableSlot()
    {
        if ($this->request->isAJAX()) {
            try {
                $idjadwal = $this->request->getPost('idjadwal');
                $tanggal = $this->request->getPost('tanggal');
                $idjenis = $this->request->getPost('idjenis');
                $is_walk_in = filter_var($this->request->getPost('is_walk_in') ?? false, FILTER_VALIDATE_BOOLEAN);
                $idbooking = $this->request->getPost('idbooking'); // Add support for editing
                
                // Set timezone ke Waktu Indonesia Barat (WIB)
                date_default_timezone_set('Asia/Jakarta');
                
                // Debug semua parameter yang diterima
                log_message('debug', "================ DEBUGGING AVAILABLE SLOT =================");
                log_message('debug', "findAvailableSlot called with parameters:");
                log_message('debug', "idjadwal: " . ($idjadwal ? $idjadwal : 'null'));
                log_message('debug', "tanggal: " . ($tanggal ? $tanggal : 'null')); 
                log_message('debug', "idjenis: " . ($idjenis ? $idjenis : 'null'));
                log_message('debug', "is_walk_in: " . ($is_walk_in ? 'true' : 'false'));
                log_message('debug', "idbooking: " . ($idbooking ?? 'null'));
                
                // Validasi input
                if (!$idjadwal || !$tanggal || !$idjenis) {
                    log_message('error', "Parameter tidak lengkap");
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Parameter tidak lengkap. Mohon isi semua field yang diperlukan.'
                    ]);
                }
                
                // Dapatkan jadwal dokter
                $db = db_connect();
                $jadwal = $db->table('jadwal')
                          ->where('idjadwal', $idjadwal)
                          ->get()
                          ->getRowArray();
                           
                if (!$jadwal) {
                    log_message('error', "Jadwal tidak ditemukan: $idjadwal");
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Jadwal dokter tidak ditemukan'
                    ]);
                }
                
                log_message('debug', "Jadwal ditemukan: " . json_encode($jadwal));
                
                // Validasi apakah tanggal sesuai dengan hari jadwal dokter
                $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
                $dayName = $dayNames[$dayOfWeek];
                
                log_message('debug', "Validasi hari: $dayName vs {$jadwal['hari']}");
                
                if ($dayName !== $jadwal['hari']) {
                    log_message('error', "Hari tidak sesuai: $dayName != {$jadwal['hari']}");
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
                    ]);
                }
                
                // Validasi apakah waktu jadwal untuk hari ini sudah lewat
                $today = date('Y-m-d');
                if ($tanggal == $today) {
                    $currentTime = date('H:i:s');
                    log_message('debug', "Tanggal hari ini. Waktu saat ini: $currentTime vs jadwal: {$jadwal['waktu_mulai']} - {$jadwal['waktu_selesai']}");
                    
                    // Jika waktu saat ini sudah lewat dari waktu awal jadwal
                    if ($currentTime > $jadwal['waktu_mulai']) {
                        log_message('debug', "Waktu saat ini sudah lewat dari awal jadwal. is_walk_in: " . ($is_walk_in ? 'true' : 'false'));
                        
                        // Untuk booking langsung (walk-in), tetap perbolehkan jika masih dalam rentang jadwal
                        if ($is_walk_in && $currentTime < $jadwal['waktu_selesai']) {
                            log_message('debug', "Walk-in diizinkan karena masih dalam rentang jadwal");
                            // Lanjutkan proses booking
                        } else {
                            // Jika waktu saat ini sudah melewati jadwal ditambah buffer 30 menit untuk online booking
                            $timeBuffer = date('H:i:s', strtotime($currentTime) + (30 * 60));
                            
                            $timeBufferTimestamp = strtotime("2000-01-01 $timeBuffer");
                            $jadwalEndTimestamp = strtotime("2000-01-01 {$jadwal['waktu_selesai']}");
                            
                            log_message('debug', "Buffer time: $timeBuffer vs jadwal selesai: {$jadwal['waktu_selesai']}");
                            
                            if ($timeBufferTimestamp >= $jadwalEndTimestamp) {
                                log_message('error', "Waktu buffer melebihi waktu selesai jadwal");
                                return $this->response->setJSON([
                                    'success' => false,
                                    'message' => "Jadwal dokter untuk hari ini pada pukul " . substr($jadwal['waktu_mulai'], 0, 5) . " sudah lewat. Silakan pilih tanggal lain."
                                ]);
                            }
                        }
                    }
                }
                
                // Dapatkan durasi dari jenis perawatan
                $jenis = $db->table('jenis_perawatan')
                         ->where('idjenis', $idjenis)
                         ->get()
                         ->getRowArray();
                         
                if (!$jenis) {
                    log_message('error', "Jenis perawatan tidak ditemukan: $idjenis");
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Jenis perawatan tidak ditemukan'
                    ]);
                }
                
                $durasi_menit = $jenis['estimasi']; // Asumsi estimasi dalam menit
                log_message('debug', "Jenis perawatan: {$jenis['namajenis']}, durasi: $durasi_menit menit");
                
                // Gunakan model Booking dengan namespace yang benar
                // ModelsBooking adalah alias untuk App\Models\Booking yang sudah di-use
                $bookingModel = new ModelsBooking();
                
                // Jika ini untuk edit booking, berikan ID booking yang akan dikecualikan
                $availableSlot = $bookingModel->findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit, $is_walk_in, $idbooking);
                
                log_message('debug', "Hasil pencarian slot: " . ($availableSlot ? json_encode($availableSlot) : 'null'));
                
                if ($availableSlot) {
                    return $this->response->setJSON([
                        'success' => true,
                        'slot' => $availableSlot,
                        'jadwal' => [
                            'hari' => $jadwal['hari'],
                            'waktu_mulai' => substr($jadwal['waktu_mulai'], 0, 5),
                            'waktu_selesai' => substr($jadwal['waktu_selesai'], 0, 5)
                        ],
                        'perawatan' => [
                            'nama' => $jenis['namajenis'],
                            'durasi' => $durasi_menit,
                            'harga' => $jenis['harga']
                        ],
                        'warning' => isset($availableSlot['warning']) ? $availableSlot['warning'] : null
                    ]);
                } else {
                    log_message('error', "Tidak ada slot tersedia untuk jadwal: $idjadwal, tanggal: $tanggal, jenis: $idjenis");
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Tidak ada slot waktu tersedia pada jadwal yang dipilih'
                    ]);
                }
            } catch (\Exception $e) {
                log_message('error', "Exception saat mencari slot: " . $e->getMessage());
                log_message('error', "Stack trace: " . $e->getTraceAsString());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        } else {
            log_message('error', "Bukan request AJAX");
            return $this->response->setStatusCode(403, 'Forbidden: Request harus melalui AJAX');
        }
    }
    
    public function getPasien()
    {

        return view('booking/getPasien');
    }

    public function viewGetPasien()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pasien = $db->table('pasien')
                ->select('id_pasien, nama,jenkel,tgllahir,nohp');
            return DataTable::of($pasien)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpasien" data-id_pasien="' . $row->id_pasien . '" data-nama_pasien="' . esc($row->nama) . '">Pilih</button>';
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
    
    public function viewGetJadwal()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Ambil data jadwal yang aktif beserta nama dokter
            $jadwal = $db->table('jadwal')
                ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter, jadwal.is_active')
                ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                ->where('jadwal.is_active', 1);
            
            // Array nama hari untuk validasi tanggal
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            
            // Hari ini 
            $today = date('Y-m-d');
            $currentDay = date('w', strtotime($today)); // 0 (Minggu) sampai 6 (Sabtu)
            $currentDayName = $dayNames[$currentDay];
            $currentTime = date('H:i:s');
            
            return DataTable::of($jadwal)
                ->addNumbering('no')
                ->add('waktu', function($row) {
                    return substr($row->waktu_mulai, 0, 5) . ' - ' . substr($row->waktu_selesai, 0, 5);
                })
                ->add('status', function($row) use ($currentDayName, $currentTime) {
                    $is_today = ($row->hari == $currentDayName);
                    $is_available_today = true;
                    
                    if ($is_today) {
                        $is_available_today = ($currentTime < $row->waktu_selesai);
                    }
                    
                    if ($row->is_active == 1) {
                        if ($is_today && !$is_available_today) {
                            return '<span class="badge badge-warning">Sudah Lewat</span>';
                        } else {
                            return '<span class="badge badge-success">Tersedia</span>';
                        }
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->add('action', function($row) use ($currentDayName, $currentTime) {
                    $is_today = ($row->hari == $currentDayName);
                    $is_available_today = true;
                    
                    if ($is_today) {
                        $is_available_today = ($currentTime < $row->waktu_selesai);
                    }
                    
                    if ($row->is_active == 1 && (!$is_today || $is_available_today)) {
                        return '<button type="button" class="btn btn-primary btn-pilihjadwal" ' .
                               'data-idjadwal="' . $row->idjadwal . '" ' .
                               'data-nama_dokter="' . $row->nama_dokter . '" ' .
                               'data-hari="' . $row->hari . '" ' .
                               'data-waktu="' . substr($row->waktu_mulai, 0, 5) . ' - ' . substr($row->waktu_selesai, 0, 5) . '">' .
                               '<i class="fas fa-check-circle"></i> Pilih</button>';
                    } else {
                        return '<button type="button" class="btn btn-secondary" disabled>' .
                               '<i class="fas fa-ban"></i> Tidak Tersedia</button>';
                    }
                })
                ->edit('hari', function($row) use ($currentDayName) {
                    if ($row->hari == $currentDayName) {
                        return $row->hari . ' <span class="badge badge-success">Hari ini</span>';
                    }
                    return $row->hari;
                })
                ->toJson();
        }
    }

    public function getJadwal()
    {
        try {
            // Ambil data jadwal yang aktif
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                        ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter, jadwal.is_active')
                        ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                        ->where('jadwal.is_active', 1)
                        ->get()->getResultArray();

            return view('booking/getJadwal', ['jadwal' => $jadwal]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getJadwal: '.$e->getMessage());
            return 'Error loading jadwal: ' . $e->getMessage();
        }
    }
    
    /**
     * Memeriksa kesesuaian hari dengan tanggal yang dipilih
     */
    public function checkDayMatch()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $tanggal = $this->request->getPost('tanggal');
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Dapatkan jadwal
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                        ->where('idjadwal', $idjadwal)
                        ->get()
                        ->getRowArray();
                        
            if (!$jadwal) {
                return $this->response->setJSON([
                    'match' => false,
                    'message' => 'Jadwal tidak ditemukan'
                ]);
            }
            
            // Dapatkan hari dari tanggal yang dipilih
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
            $dayName = $dayNames[$dayOfWeek];
            
            $match = ($dayName === $jadwal['hari']);
            
            return $this->response->setJSON([
                'match' => $match,
                'message' => $match ? 'Tanggal sesuai dengan hari jadwal' : 
                    "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
            ]);
        }
    }

    public function checkin($idbooking = null)
    {
        if ($idbooking) {
            // If idbooking is provided, show the specific booking for checkin
            $db = db_connect();
            $booking = $db->table('booking')
                ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, jenis_perawatan.namajenis')
                ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
                ->where('booking.idbooking', $idbooking)
                ->get()
                ->getRowArray();
                
            if (!$booking) {
                return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
            }
            
            return view('booking/checkin_detail', ['booking' => $booking]);
        }
        
        // If no ID provided, show the QR scanner page
        return view('booking/checkin_scanner');
    }

    public function processCheckin()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            
            // Validate booking exists and is in 'diterima' status
            $bookingModel = new ModelsBooking();
            $booking = $bookingModel->find($idbooking);
            
            if (!$booking) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Booking tidak ditemukan'
                ]);
            }
            
            if ($booking['status'] != 'diterima') {
                $statusMessage = '';
                switch($booking['status']) {
                    case 'pending':
                        $statusMessage = 'Booking masih dalam status pending. Harap dikonfirmasi terlebih dahulu.';
                        break;
                    case 'diperiksa':
                        $statusMessage = 'Pasien sudah check-in dan sedang diperiksa.';
                        break;
                    case 'ditolak':
                        $statusMessage = 'Booking ini telah ditolak.';
                        break;
                    default:
                        $statusMessage = 'Status booking tidak valid untuk check-in.';
                }
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $statusMessage,
                    'status' => $booking['status']
                ]);
            }
            
            // Update status to 'diperiksa'
            $bookingModel->update($idbooking, ['status' => 'diperiksa']);
            
            // Create a new perawatan record
            $db = db_connect();
            
            // Generate perawatan ID
            $query = $db->query("SELECT CONCAT('PRW', LPAD(IFNULL(MAX(SUBSTRING(idperawatan, 4)) + 1, 1), 4, '0')) AS next_number FROM perawatan");
            $row = $query->getRow();
            $idperawatan = $row->next_number;
            
            // Create perawatan record
            $perawatanModel = new Perawatan();
            $perawatanModel->insert([
                'idperawatan' => $idperawatan,
                'tanggal' => date('Y-m-d'),
                'idbooking' => $idbooking,
                'resep' => '',
                'total_bayar' => 0
            ]);
            
            // Fetch updated booking data with related information
            $updatedBooking = $db->table('booking')
                ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, jenis_perawatan.namajenis')
                ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
                ->where('booking.idbooking', $idbooking)
                ->get()
                ->getRowArray();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'booking' => $updatedBooking,
                'idperawatan' => $idperawatan
            ]);
        }
        
        return $this->response->setStatusCode(405, 'Method Not Allowed');
    }

    /**
     * Update status booking dari halaman bukti.php (readonly, hanya status yang bisa diubah)
     */

         
     public function getBuktiBooking($idbooking)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, pasien.nama as pasien_nama, pasien.alamat, pasien.nohp, pasien.jenkel, pasien.tgllahir, booking.bukti_bayar,jadwal.hari,jadwal.waktu_mulai,jadwal.waktu_selesai,dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->where('idbooking', $idbooking)
            ->get()
            ->getRowArray();
        $data = [
            'booking' => $booking,
        ];

        if (!$booking) {
            return redirect()->to('/booking')->with('error', 'Data Booking tidak ditemukan');
        }

        
        return view('booking/bukti', $data);
    }

    /**
     * Halaman upload bukti pembayaran oleh pasien
     */
    public function uploadBukti($idbooking)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, pasien.nama as pasien_nama, pasien.alamat, pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.harga, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $idbooking)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->to('/online')->with('error', 'Data Booking tidak ditemukan');
        }
        
        $data = [
            'booking' => $booking,
        ];
        
        return view('online/upload_bukti', $data);
    }
    
    /**
     * Proses upload bukti pembayaran
     */
    public function prosesUploadBukti()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $bukti_bayar = $this->request->getFile('bukti_bayar');
            
            $rules = [
                'bukti_bayar' => [
                    'label' => 'Bukti Pembayaran',
                    'rules' => 'uploaded[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_bayar,2048]',
                    'errors' => [
                        'uploaded' => 'Bukti pembayaran wajib diunggah',
                        'mime_in' => 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF',
                        'max_size' => 'Ukuran file maksimal 2MB',
                    ]
                ]
            ];
            
            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    if ($this->validator->hasError($field)) {
                        $errors["error_$field"] = $this->validator->getError($field);
                    }
                }
                
                return $this->response->setJSON([
                    'error' => $errors
                ]);
            }
            
            $model = new \App\Models\Booking();
            $booking = $model->find($idbooking);
            
            if (!$booking) {
                return $this->response->setJSON([
                    'error' => [
                        'error_global' => 'Data Booking tidak ditemukan'
                    ]
                ]);
            }
            
            // Hapus file bukti lama jika ada
            if (!empty($booking['bukti_bayar']) && file_exists('uploads/bukti_bayar/' . $booking['bukti_bayar'])) {
                unlink('uploads/bukti_bayar/' . $booking['bukti_bayar']);
            }
            
            // Proses upload file baru
            $newName = 'bukti-' . date('Ymd') . '-' . $idbooking . '.' . $bukti_bayar->getClientExtension();
            $bukti_bayar->move('uploads/bukti_bayar', $newName);
            
            // Update status menjadi 'diproses', simpan bukti, dan set online menjadi 1
            $model->update($idbooking, [
                'bukti_bayar' => $newName,
                'status' => 'diproses',
                'online' => 1
            ]);
            
            return $this->response->setJSON([
                'success' => 'Bukti pembayaran berhasil diunggah. Mohon Bersabar Menunggu Konfirmasi Dari Admin'
            ]);
        }
        
        return $this->response->setStatusCode(405, 'Method Not Allowed');
    }
    
    /**
     * Tampilkan faktur pembayaran
     */
    public function faktur($idbooking)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, pasien.nama as pasien_nama, pasien.alamat, pasien.nohp, 
                      pasien.jenkel, pasien.tgllahir, jenis_perawatan.namajenis, 
                      jenis_perawatan.harga, jadwal.hari, dokter.nama as nama_dokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $idbooking)
            ->get()
            ->getRowArray();
            
        if (!$booking) {
            return redirect()->to('/booking')->with('error', 'Data Booking tidak ditemukan');
        }
        
        // Hanya tampilkan faktur jika status diterima
        if ($booking['status'] != 'diterima') {
            return redirect()->to('/booking/bukti/'.$idbooking)->with('error', 'Faktur hanya tersedia untuk pembayaran yang telah diterima');
        }
        
        $data = [
            'booking' => $booking,
            'faktur_id' => 'INV-'.date('Ymd').'-'.$idbooking,
            'tanggal_faktur' => date('Y-m-d')
        ];
        
        return view('online/faktur', $data);
    }

    public function updateStatusBukti($idbooking)
    {
        if ($this->request->isAJAX()) {
            $status = $this->request->getPost('status');
            $allowed = ['pending', 'diproses', 'diterima', 'diperiksa', 'ditolak'];
            $errors = [];
            if (!$status || !in_array($status, $allowed)) {
                $errors['error_status'] = 'Status tidak valid.';
            }
            if (!empty($errors)) {
                return $this->response->setJSON(['error' => $errors]);
            }
            $model = new ModelsBooking();
            $updated = $model->update($idbooking, ['status' => $status]);
            if ($updated) {
                return $this->response->setJSON(['sukses' => 'Status booking berhasil diupdate']);
            } else {
                return $this->response->setJSON(['error' => ['error_status' => 'Gagal update status']]);
            }
        }
    }

    public function booking()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu untuk melakukan booking.');
            return redirect()->to('auth');
        }
        
        // Cek apakah user sudah memiliki data pasien
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        // Jika belum ada data pasien, tampilkan form untuk melengkapi data pasien
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        // Jika sudah ada data pasien, lanjutkan booking
        $jadwalModel = new \App\Models\Jadwal();
        $dokterModel = new \App\Models\Dokter();
        $jenisModel = new \App\Models\Jenis();

        $data = [
            'jadwal' => $jadwalModel->findAll(),
            'dokter' => $dokterModel->findAll(),
            'jenis' => $jenisModel->findAll(),
            'pasien' => $pasien
        ];

        return view('online/booking', $data);
    }

    public function simpanbooking()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu untuk melakukan booking.');
            return redirect()->to('auth');
        }
        
        // Cek apakah user sudah memiliki data pasien
        $userId = session()->get('id');
        $db = db_connect();
        $pasien = $db->table('pasien')->where('iduser', $userId)->get()->getRowArray();
        
        // Jika belum ada data pasien, redirect ke halaman lengkapi data
        if (!$pasien) {
            return redirect()->to('online/lengkapi_data');
        }
        
        $bookingModel = new \App\Models\Booking();
        
        // Validasi input
        $rules = [
            'tanggal_booking' => 'required|valid_date',
            'idjadwal' => 'required',
            'idjenis' => 'required',
            'keluhan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Cek ketersediaan jadwal
        $isAvailable = $bookingModel->isSlotAvailable(
            $this->request->getPost('idjadwal'),
            $this->request->getPost('tanggal_booking'),
            $this->request->getPost('waktu_mulai'),
            $this->request->getPost('waktu_selesai')
        );

        if (!$isAvailable) {
            return redirect()->back()->withInput()->with('error', 'Jadwal sudah terisi pada waktu tersebut. Silakan pilih waktu lain.');
        }
        
        // Generate ID Booking
        $tanggal = date('Ymd');
        $query = $db->query("SELECT CONCAT('BK', LPAD(IFNULL(MAX(SUBSTRING(idbooking, 3)) + 1, 1), 4, '0')) AS next_number FROM booking");
        $row = $query->getRow();
        $idBooking = $row->next_number;
        
        // Data booking
        $data = [
            'idbooking' => $idBooking,
            'id_pasien' => $pasien['id_pasien'],
            'tanggal' => $this->request->getPost('tanggal_booking'),
            'idjadwal' => $this->request->getPost('idjadwal'),
            'idjenis' => $this->request->getPost('idjenis'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'keluhan' => $this->request->getPost('keluhan'),
            'status' => 'diproses',
            'online' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        // Simpan data booking
        $bookingModel->insert($data);
        
        // Simpan data untuk bukti booking
        $jadwalModel = new \App\Models\Jadwal();
        $dokterModel = new \App\Models\Dokter();
        $jenisModel = new \App\Models\Jenis();
        $pasienModel = new \App\Models\Pasien();
        
        // Ambil data jadwal dan dokter
        $jadwal = $jadwalModel->find($data['idjadwal']);
        $jenis = $jenisModel->find($data['idjenis']);
        
        // Get dokter from jadwal
        $dokter = null;
        if ($jadwal) {
            $dokter = $dokterModel->find($jadwal['iddokter']);
        }
        
        $data['jadwal'] = $jadwal;
        $data['dokter'] = $dokter;
        $data['jenis'] = $jenis;
        $data['pasien'] = $pasien;
        
        session()->set('booking_data', $data);
        
        return redirect()->to('online/bukti');
    }

    public function lengkapi_data()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('auth');
        }
        
        return view('online/lengkapi_data_pasien');
    }

    public function simpan_data_pasien()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('auth');
        }
        
        // Validasi input
        $rules = [
            'nama' => 'required',
            'jenkel' => 'required',
            'tgllahir' => 'required|valid_date',
            'nohp' => 'required',
            'alamat' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Generate ID Pasien
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PS', LPAD(IFNULL(MAX(SUBSTRING(id_pasien, 3)) + 1, 1), 4, '0')) AS next_number FROM pasien");
        $row = $query->getRow();
        $idPasien = $row->next_number;
        
        $userId = session()->get('id');
        
        // Data pasien
        $data = [
            'id_pasien' => $idPasien,
            'iduser' => $userId,
            'nama' => $this->request->getPost('nama'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'nohp' => $this->request->getPost('nohp'),
            'alamat' => $this->request->getPost('alamat'),
        ];
        
        // Simpan data pasien
        $pasienModel = new \App\Models\Pasien();
        $pasienModel->insert($data);
        
        session()->setFlashdata('success', 'Data pasien berhasil disimpan. Silakan lanjutkan booking.');
        return redirect()->to('online/booking');
    }

    public function bukti()
    {
        $bookingData = session()->get('booking_data');
        
        if (!$bookingData) {
            return redirect()->to('online/booking');
        }
        $data = [
            'booking' => $bookingData
        ];
        
        return view('online/bukti', $data);
    }
}
