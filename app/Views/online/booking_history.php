<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Booking - Wisma Citra Sabaleh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                            950: '#500724',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(50px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 25%, #9333ea  50%, #7c3aed 75%, #6b21a8 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .status-diproses {
            background: linear-gradient(135deg, #f97316, #ea580c);
        }
        .status-menunggu {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        .status-diterima {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .status-ditolak {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        .status-dibatalkan {
            background: linear-gradient(135deg, #6b7280, #4b5563);
        }
        .status-selesai {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        .status-limit {
            background: linear-gradient(135deg, #991b1b, #7f1d1d);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 25%, #9333ea 50%, #7c3aed 75%, #6b21a8 100%); backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white font-bold text-2xl animate-fade-in">
                    <i class="fas fa-hotel mr-2"></i>Citra Sabaleh
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('/') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-home mr-1"></i> Homepage
                    </a>
                    <a href="<?= site_url('online') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-dashboard mr-1"></i> Dashboard
                    </a>
                    <a href="<?= site_url('online/booking') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-plus mr-1"></i> Booking Baru
                    </a>
                    <div class="text-white">
                        <i class="fas fa-user mr-2"></i>
                        <?= $tamu['nama'] ?? session()->get('username') ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 pb-10">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-12 animate-slide-up">
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">
                    <i class="fas fa-history mr-4"></i>
                    History Booking
                </h1>
                <p class="text-xl text-pink-100">
                    Kelola dan pantau semua booking Anda
                </p>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <?php 
                $totalBookings = count($reservasi_list);
                $statusCounts = [
                    'diproses' => 0,
                    'menunggu' => 0,
                    'diterima' => 0,
                    'ditolak' => 0,
                    'dibatalkan' => 0,
                    'selesai' => 0,
                    'limit' => 0
                ];
                
                foreach ($reservasi_list as $reservasi) {
                    if (isset($statusCounts[$reservasi['status']])) {
                        $statusCounts[$reservasi['status']]++;
                    }
                }
                ?>
                
                <!-- Total Booking -->
                <div class="glass-effect rounded-2xl p-6 text-center animate-slide-up">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-list text-3xl text-blue-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $totalBookings ?></h3>
                    <p class="text-gray-600">Total Booking</p>
                </div>

                <!-- Pending Upload -->
                <div class="glass-effect rounded-2xl p-6 text-center animate-slide-up">
                    <div class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-upload text-3xl text-orange-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $statusCounts['diproses'] + $statusCounts['ditolak'] ?></h3>
                    <p class="text-gray-600">Perlu Upload</p>
                </div>

                <!-- Pending Verification -->
                <div class="glass-effect rounded-2xl p-6 text-center animate-slide-up">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-3xl text-yellow-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $statusCounts['menunggu'] ?></h3>
                    <p class="text-gray-600">Verifikasi</p>
                </div>

                <!-- Approved -->
                <div class="glass-effect rounded-2xl p-6 text-center animate-slide-up">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $statusCounts['diterima'] + $statusCounts['selesai'] ?></h3>
                    <p class="text-gray-600">Disetujui</p>
                </div>
            </div>

            <!-- Booking List -->
            <div class="glass-effect rounded-3xl p-8 animate-slide-up">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Daftar Booking
                    </h2>
                    <a href="<?= site_url('online/booking') ?>" class="bg-white text-primary-600 px-6 py-3 rounded-xl font-bold hover:bg-pink-50 transition duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Booking Baru
                    </a>
                </div>

                <?php if (empty($reservasi_list)): ?>
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-calendar-times text-6xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Booking</h3>
                        <p class="text-gray-600 mb-8">
                            Anda belum memiliki booking. Mulai booking kamar sekarang!
                        </p>
                        <a href="<?= site_url('online/booking') ?>" class="bg-white text-primary-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                            <i class="fas fa-plus mr-2"></i>
                            Booking Sekarang
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Booking Cards -->
                    <div class="space-y-6">
                        <?php foreach ($reservasi_list as $reservasi): ?>
                            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 hover:bg-gray-100 transition duration-300">
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-center">
                                    <!-- Room Info -->
                                    <div class="lg:col-span-2">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-20 h-20 bg-gray-200 rounded-xl flex items-center justify-center">
                                                <i class="fas fa-bed text-2xl text-gray-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-xl font-bold text-gray-800 mb-1"><?= $reservasi['nama_kamar'] ?></h3>
                                                <p class="text-gray-600 mb-2">
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    <?= date('d M Y', strtotime($reservasi['tglcheckin'])) ?> - 
                                                    <?= date('d M Y', strtotime($reservasi['tglcheckout'])) ?>
                                                </p>
                                                <p class="text-gray-600">
                                                    <i class="fas fa-money-bill mr-1"></i>
                                                    Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="text-center">
                                        <?php 
                                        $statusClass = 'status-' . $reservasi['status'];
                                        $statusText = ucfirst($reservasi['status']);
                                        $statusIcon = '';
                                        
                                        switch ($reservasi['status']) {
                                            case 'diproses':
                                                if (!empty($reservasi['buktibayar'])) {
                                                    $statusIcon = 'fas fa-clock';
                                                    $statusText = 'Menunggu Verifikasi';
                                                } else {
                                                    $statusIcon = 'fas fa-spinner';
                                                    $statusText = 'Perlu Upload';
                                                }
                                                break;
                                            case 'diterima':
                                                $statusIcon = 'fas fa-check-circle';
                                                $statusText = 'Diterima';
                                                break;
                                            case 'ditolak':
                                                $statusIcon = 'fas fa-times-circle';
                                                $statusText = 'Ditolak';
                                                break;
                                            case 'limit':
                                                $statusIcon = 'fas fa-exclamation-triangle';
                                                $statusText = 'Waktu Habis';
                                                break;
                                            case 'cancel':
                                                $statusIcon = 'fas fa-ban';
                                                $statusText = 'Dibatalkan';
                                                break;
                                            case 'selesai':
                                                $statusIcon = 'fas fa-star';
                                                $statusText = 'Selesai';
                                                break;
                                            case 'checkin':
                                                $statusIcon = 'fas fa-door-open';
                                                $statusText = 'Check-in';
                                                break;
                                            default:
                                                $statusIcon = 'fas fa-question';
                                                $statusText = ucfirst($reservasi['status']);
                                        }
                                        ?>
                                        <div class="<?= $statusClass ?> text-white px-4 py-2 rounded-full font-bold">
                                            <i class="<?= $statusIcon ?> mr-2"></i>
                                            <?= $statusText ?>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="text-center space-y-2">
                                        <a href="<?= site_url('online/booking/detail/' . $reservasi['idbooking']) ?>" 
                                           class="block w-full bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-600 transition duration-300">
                                            <i class="fas fa-eye mr-2"></i>
                                            Detail
                                        </a>
                                        
                                        <?php if ($reservasi['status'] === 'diproses'): ?>
                                            <?php if (empty($reservasi['buktibayar'])): ?>
                                                <!-- Belum upload bukti bayar -->
                                                <?php if (!empty($reservasi['batas_waktu'])): ?>
                                                    <?php 
                                                    $batasWaktu = strtotime($reservasi['batas_waktu']);
                                                    $sekarang = time();
                                                    $sisaWaktu = $batasWaktu - $sekarang;
                                                    ?>
                                                    <?php if ($sisaWaktu > 0): ?>
                                                        <a href="<?= site_url('online/booking/payment/' . $reservasi['idbooking']) ?>"
                                                           class="block w-full bg-orange-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-orange-600 transition duration-300 animate-pulse">
                                                            <i class="fas fa-upload mr-2"></i>
                                                            Upload Bayar
                                                        </a>
                                                        <p class="text-xs text-yellow-600">
                                                            ⏰ <?= ceil($sisaWaktu / 60) ?> menit tersisa
                                                        </p>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <!-- Sudah upload, menunggu verifikasi -->
                                                <div class="w-full bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold">
                                                    <i class="fas fa-clock mr-2"></i>
                                                    Menunggu Verifikasi
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif ($reservasi['status'] === 'ditolak'): ?>
                                            <a href="<?= site_url('online/booking/payment/' . $reservasi['idbooking']) ?>"
                                               class="block w-full bg-red-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-600 transition duration-300">
                                                <i class="fas fa-redo mr-2"></i>
                                                Upload Ulang
                                            </a>
                                        <?php elseif ($reservasi['status'] === 'diterima'): ?>
                                            <a href="<?= site_url('online/booking/faktur/' . $reservasi['idbooking']) ?>"
                                               class="block w-full bg-green-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-600 transition duration-300">
                                                <i class="fas fa-file-invoice mr-2"></i>
                                                Lihat Faktur
                                            </a>
                                        <?php elseif ($reservasi['status'] === 'limit'): ?>
                                            <div class="w-full bg-gray-500 text-white px-4 py-2 rounded-xl font-semibold">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                Waktu Habis
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Cancel booking function
        function cancelBooking(bookingId) {
            Swal.fire({
                title: 'Batalkan Booking?',
                text: 'Apakah Anda yakin ingin membatalkan booking ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    processCancelBooking(bookingId);
                }
            });
        }

        // Process cancel booking
        function processCancelBooking(bookingId) {
            fetch(`<?= site_url('online/booking/cancel/') ?>${bookingId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#ec4899'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat membatalkan booking',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        }
    </script>
</body>
</html> 