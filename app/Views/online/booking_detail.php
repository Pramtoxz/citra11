<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking - Wisma Citra Sabaleh</title>
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
        .status-limit {
            background: linear-gradient(135deg, #991b1b, #7f1d1d);
        }
        .status-selesai {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
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
                    <a href="<?= site_url('online/booking/history') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-history mr-1"></i> History
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
                    <i class="fas fa-file-invoice mr-4"></i>
                    Detail Booking
                </h1>
                <p class="text-xl text-pink-100">
                    Informasi lengkap reservasi Anda
                </p>
            </div>

            <!-- Detail Booking -->
            <div class="max-w-4xl mx-auto">
                <!-- Status Card -->
                <div class="glass-effect rounded-3xl p-8 mb-8 animate-slide-up">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">
                            Booking ID: <?= $reservasi['idbooking'] ?>
                        </h2>
                        <?php 
                        $statusClass = 'status-' . $reservasi['status'];
                        $statusText = ucfirst($reservasi['status']);
                        $statusIcon = '';
                        
                        switch ($reservasi['status']) {
                            case 'diproses':
                                if (!empty($reservasi['buktibayar'])) {
                                    $statusIcon = 'fas fa-clock';
                                    $statusText = 'Menunggu Verifikasi Admin';
                                } else {
                                    $statusIcon = 'fas fa-spinner fa-spin';
                                    $statusText = 'Perlu Upload Bukti Bayar';
                                }
                                break;
                            case 'diterima':
                                $statusIcon = 'fas fa-check-circle';
                                $statusText = 'Booking Diterima';
                                break;
                            case 'ditolak':
                                $statusIcon = 'fas fa-times-circle';
                                $statusText = 'Bukti Bayar Ditolak';
                                break;
                            case 'limit':
                                $statusIcon = 'fas fa-exclamation-triangle';
                                $statusText = 'Waktu Upload Habis';
                                break;
                            case 'selesai':
                                $statusIcon = 'fas fa-star';
                                $statusText = 'Selesai';
                                break;
                            case 'checkin':
                                $statusIcon = 'fas fa-door-open';
                                $statusText = 'Sudah Check-in';
                                break;
                            case 'cancel':
                                $statusIcon = 'fas fa-ban';
                                $statusText = 'Dibatalkan';
                                break;
                            default:
                                $statusIcon = 'fas fa-question';
                                $statusText = ucfirst($reservasi['status']);
                        }
                        ?>
                        <div class="<?= $statusClass ?> text-white px-8 py-4 rounded-full font-bold text-xl inline-block">
                            <i class="<?= $statusIcon ?> mr-3"></i>
                            <?= $statusText ?>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Guest Info -->
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-user mr-2 text-primary-500"></i>
                                Informasi Tamu
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-600">Nama:</label>
                                    <p class="font-semibold text-gray-800"><?= $tamu['nama'] ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">NIK:</label>
                                    <p class="font-semibold text-gray-800"><?= $tamu['nik'] ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">No. HP:</label>
                                    <p class="font-semibold text-gray-800"><?= $tamu['nohp'] ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Alamat:</label>
                                    <p class="font-semibold text-gray-800"><?= $tamu['alamat'] ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Room Info -->
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-bed mr-2 text-primary-500"></i>
                                Informasi Kamar
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-gray-600">Nama Kamar:</label>
                                    <p class="font-semibold text-gray-800"><?= $reservasi['nama_kamar'] ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Check-in:</label>
                                    <p class="font-semibold text-gray-800"><?= date('d F Y', strtotime($reservasi['tglcheckin'])) ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Check-out:</label>
                                    <p class="font-semibold text-gray-800"><?= date('d F Y', strtotime($reservasi['tglcheckout'])) ?></p>
                                </div>
                                <div>
                                    <label class="text-sm text-gray-600">Lama Menginap:</label>
                                    <?php 
                                    $checkin = new DateTime($reservasi['tglcheckin']);
                                    $checkout = new DateTime($reservasi['tglcheckout']);
                                    $interval = $checkin->diff($checkout);
                                    $lamaMenginap = $interval->days;
                                    ?>
                                    <p class="font-semibold text-gray-800"><?= $lamaMenginap ?> malam</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="mt-8 bg-blue-50 rounded-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-credit-card mr-2 text-primary-500"></i>
                            Informasi Pembayaran
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Tipe Pembayaran</p>
                                <p class="font-bold text-xl text-gray-800"><?= ucfirst($reservasi['tipe']) ?></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Total yang Dibayar</p>
                                <p class="font-bold text-xl text-green-600">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Total Kamar</p>
                                <p class="font-bold text-xl text-blue-600">Rp <?= number_format($lamaMenginap * $reservasi['harga'], 0, ',', '.') ?></p>
                            </div>
                        </div>

                        <?php if ($reservasi['tipe'] === 'dp'): ?>
                            <?php $sisaBayar = ($lamaMenginap * $reservasi['harga']) - $reservasi['totalbayar']; ?>
                            <div class="mt-4 p-4 bg-yellow-100 rounded-xl border border-yellow-300">
                                <div class="text-center">
                                    <p class="text-sm text-yellow-700">Sisa Pembayaran saat Check-in</p>
                                    <p class="font-bold text-2xl text-yellow-800">Rp <?= number_format($sisaBayar, 0, ',', '.') ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Bukti Bayar -->
                    <?php if (!empty($reservasi['buktibayar'])): ?>
                        <div class="mt-8 bg-green-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-receipt mr-2 text-green-500"></i>
                                Bukti Pembayaran
                            </h3>
                            <div class="text-center">
                                <div class="inline-block border-4 border-green-200 rounded-xl overflow-hidden shadow-lg">
                                    <img src="<?= base_url('assets/img/bukti_bayar/' . $reservasi['buktibayar']) ?>" 
                                         alt="Bukti Pembayaran" 
                                         class="max-w-md w-full h-auto cursor-pointer hover:scale-105 transition duration-300"
                                         onclick="showImageModal('<?= base_url('assets/img/bukti_bayar/' . $reservasi['buktibayar']) ?>')">
                                </div>
                                <p class="mt-3 text-sm text-gray-600">
                                    <i class="fas fa-search-plus mr-1"></i>
                                    Klik gambar untuk memperbesar
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Upload: <?= date('d F Y H:i', strtotime($reservasi['updated_at'])) ?> WIB
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mt-8 text-center space-y-4">
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
                                        <div class="bg-orange-100 border border-orange-300 rounded-xl p-4 mb-4">
                                            <p class="text-orange-800 font-semibold">
                                                <i class="fas fa-clock mr-2"></i>
                                                Sisa waktu upload: <?= ceil($sisaWaktu / 60) ?> menit
                                            </p>
                                        </div>
                                        <a href="<?= site_url('online/booking/payment/' . $reservasi['idbooking']) ?>" 
                                           class="bg-orange-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-600 transition duration-300 inline-block animate-pulse">
                                            <i class="fas fa-upload mr-2"></i>
                                            Upload Bukti Pembayaran
                                        </a>
                                    <?php else: ?>
                                        <div class="bg-red-100 border border-red-300 rounded-xl p-4">
                                            <p class="text-red-800 font-semibold">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                Waktu upload telah habis
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- Sudah upload, menunggu verifikasi -->
                                <div class="bg-blue-100 border border-blue-300 rounded-xl p-4">
                                    <p class="text-blue-800 font-semibold">
                                        <i class="fas fa-clock mr-2"></i>
                                        Bukti pembayaran sudah diupload. Menunggu verifikasi admin.
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php elseif ($reservasi['status'] === 'ditolak'): ?>
                            <a href="<?= site_url('online/booking/payment/' . $reservasi['idbooking']) ?>" 
                               class="bg-red-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-red-600 transition duration-300 inline-block">
                                <i class="fas fa-redo mr-2"></i>
                                Upload Ulang Bukti Pembayaran
                            </a>
                        <?php elseif ($reservasi['status'] === 'diterima'): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="<?= site_url('online/booking/faktur/' . $reservasi['idbooking']) ?>" 
                                   class="bg-green-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-green-600 transition duration-300 inline-block">
                                    <i class="fas fa-file-invoice mr-2"></i>
                                    Lihat Faktur
                                </a>
                                <div class="bg-green-100 border border-green-300 rounded-xl p-4">
                                    <p class="text-green-800 font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Booking Anda telah dikonfirmasi!
                                    </p>
                                </div>
                            </div>
                        <?php elseif ($reservasi['status'] === 'limit'): ?>
                            <div class="bg-red-100 border border-red-300 rounded-xl p-4">
                                <p class="text-red-800 font-semibold">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Waktu upload pembayaran telah habis. Booking tidak dapat dilanjutkan.
                                </p>
                            </div>
                        <?php elseif ($reservasi['status'] === 'cancel'): ?>
                            <div class="bg-gray-100 border border-gray-300 rounded-xl p-4">
                                <p class="text-gray-800 font-semibold">
                                    <i class="fas fa-ban mr-2"></i>
                                    Booking telah dibatalkan.
                                </p>
                            </div>
                        <?php elseif ($reservasi['status'] === 'checkin'): ?>
                            <div class="bg-green-100 border border-green-300 rounded-xl p-4">
                                <p class="text-green-800 font-semibold">
                                    <i class="fas fa-door-open mr-2"></i>
                                    Anda sudah check-in. Selamat menikmati menginap!
                                </p>
                            </div>
                        <?php elseif ($reservasi['status'] === 'selesai'): ?>
                            <div class="bg-blue-100 border border-blue-300 rounded-xl p-4">
                                <p class="text-blue-800 font-semibold">
                                    <i class="fas fa-star mr-2"></i>
                                    Booking telah selesai. Terima kasih telah menginap!
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- Back Button -->
                        <div class="pt-4">
                            <a href="<?= site_url('online/booking/history') ?>" 
                               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-600 transition duration-300 inline-block">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="Bukti Pembayaran" class="w-full h-auto max-h-screen object-contain rounded-lg">
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function showImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</body>
</html> 