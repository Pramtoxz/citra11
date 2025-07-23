<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Booking - Klinik Gigi Sehat Bersinar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(120deg, #0d9488 0%, #2dd4bf 100%);
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-area {
                box-shadow: none !important;
                border: 1px solid #ddd;
            }
            .gradient-bg {
                background: #0d9488 !important;
                -webkit-print-color-adjust: exact;
            }
            body {
                padding: 0;
                margin: 0;
                background: white;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md w-full z-50 no-print">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="<?= base_url() ?>" class="flex items-center space-x-2">
                    <i class="fas fa-tooth text-teal-600 text-3xl"></i>
                    <span class="text-2xl font-bold text-teal-800">KlinikGigi</span>
                </a>
            </div>
            <div>
                <a href="<?= base_url() ?>" class="text-teal-800 hover:text-teal-600 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 print-area">
                <div class="gradient-bg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold">BUKTI BOOKING KLINIK GIGI</h1>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-tooth text-white text-2xl"></i>
                            <span class="text-xl font-semibold">KlinikGigi</span>
                        </div>
                    </div>
                    <p class="opacity-80 mt-1">Simpan bukti booking ini dan tunjukkan saat kunjungan Anda.</p>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">ID Booking: <span class="text-teal-600"><?= $booking['idbooking'] ?></span></h2>
                            <p class="text-gray-600">Tanggal Booking: <?= date('d F Y', strtotime($booking['tanggal'])) ?></p>
                        </div>
                        <div class="text-center">
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full uppercase"><?= $booking['status'] ?></span>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-teal-800 mb-2">Data Pasien</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama</span>
                                        <span class="font-medium"><?= $booking['pasien']['nama'] ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">No. HP</span>
                                        <span class="font-medium"><?= $booking['pasien']['nohp'] ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Lahir</span>
                                        <span class="font-medium"><?= date('d F Y', strtotime($booking['pasien']['tgllahir'])) ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Alamat</span>
                                        <span class="font-medium text-right"><?= $booking['pasien']['alamat'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-teal-800 mb-2">Detail Perawatan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jenis Perawatan</span>
                                        <span class="font-medium"><?= $booking['jenis']['namajenis'] ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama Dokter</span>
                                        <span class="font-medium"><?= $booking['dokter']['nama'] ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Jadwal</span>
                                        <span class="font-medium"><?= $booking['jadwal']['hari'] ?>, <?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-teal-800 mb-2">Keluhan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800"><?= $booking['keluhan'] ?></p>
                        </div>
                    </div>
                    
                    <div class="mt-8 bg-teal-50 p-4 rounded-lg border border-teal-200">
                        <h4 class="font-medium text-teal-800 mb-1">Catatan Penting:</h4>
                        <ul class="text-sm text-teal-700 space-y-1 list-disc list-inside">
                            <li>Harap datang 15 menit sebelum jadwal yang ditentukan</li>
                            <li>Booking ini berlaku untuk 1 orang pasien</li>
                            <li>Mohon membawa kartu identitas (KTP/SIM)</li>
                            <li>Jika ada perubahan jadwal, silahkan hubungi nomor klinik</li>
                        </ul>
                    </div>
                    
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-gray-800">Klinik Gigi Sehat Bersinar</h4>
                                <p class="text-sm text-gray-600">Jl. Kesehatan No. 123, Surabaya</p>
                                <p class="text-sm text-gray-600">Telp: +62 812-3456-7890</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-1">Tanggal Dicetak</p>
                                    <p class="text-sm font-medium text-gray-700"><?= date('d F Y H:i') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center text-sm text-gray-500">
                        <p>Booking dibuat secara online pada <?= date('d F Y H:i', strtotime($booking['created_at'])) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center space-x-4 no-print">
                <button onclick="window.print()" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak Bukti
                </button>
                <a href="<?= base_url() ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>
            
            <!-- Tambahkan tombol untuk upload bukti pembayaran -->
            <div class="mt-8 mb-4 text-center no-print">
                <?php if (isset($booking['status'])): ?>
                    <?php if ($booking['status'] == 'ditolak' || empty($booking['bukti_bayar'])): ?>
                        <div class="mb-4">
                            <?php if ($booking['status'] == 'ditolak'): ?>
                                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        <p>Bukti pembayaran ditolak. Silakan upload ulang bukti pembayaran yang valid.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <a href="<?= base_url('online/uploadBukti/' . $booking['idbooking']) ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center font-medium transition-colors">
                                <i class="fas fa-upload mr-2"></i> Upload Bukti Pembayaran
                            </a>
                        </div>
                    <?php elseif ($booking['status'] == 'diproses'): ?>
                        <div class="bg-blue-100 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                <p>Bukti pembayaran Anda sedang diproses. Mohon tunggu konfirmasi dari admin.</p>
                            </div>
                        </div>
                    <?php elseif ($booking['status'] == 'diterima'): ?>
                        <div class="mb-4">
                            <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <p>Pembayaran Anda telah diterima. Terima kasih!</p>
                                </div>
                            </div>
                            <a href="<?= base_url('booking/faktur/' . $booking['idbooking']) ?>" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg inline-flex items-center font-medium transition-colors">
                                <i class="fas fa-file-invoice mr-2"></i> Lihat Faktur
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-10 no-print">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center items-center mb-4">
                <i class="fas fa-tooth text-teal-400 text-2xl"></i>
                <span class="text-xl font-bold ml-2">KlinikGigi</span>
            </div>
            <p class="text-gray-400">© <?= date('Y') ?> Klinik Gigi Sehat Bersinar. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tampilkan flash messages dengan SweetAlert jika ada
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
            });
        <?php endif; ?>
        
        // Cetak dengan konfirmasi
        document.querySelector('button[onclick="window.print()"]').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Cetak Bukti Booking',
                text: "Siapkan printer Anda",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Cetak Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.print();
                }
            });
        });
    </script>
</body>
</html> 