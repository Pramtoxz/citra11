<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Pembayaran - Wisma Citra Sabaleh</title>
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
                        'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(50px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .timer-warning {
            animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .drag-drop-zone {
            border: 2px dashed #fff;
            transition: all 0.3s ease;
        }
        .drag-drop-zone:hover {
            border-color: #ec4899;
            background: rgba(236, 72, 153, 0.1);
        }
        .drag-drop-zone.dragover {
            border-color: #ec4899;
            background: rgba(236, 72, 153, 0.2);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white font-bold text-2xl animate-fade-in">
                    <i class="fas fa-hotel mr-2"></i>Citra Sabaleh
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('/') ?>" class="text-white hover:text-pink-300 transition duration-300">
                        <i class="fas fa-home mr-1"></i> Homepage
                    </a>
                    <a href="<?= site_url('online') ?>" class="text-white hover:text-pink-300 transition duration-300">
                        <i class="fas fa-dashboard mr-1"></i> Dashboard
                    </a>
                    <a href="<?= site_url('online/booking/history') ?>" class="text-white hover:text-pink-300 transition duration-300">
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
                    <i class="fas fa-credit-card mr-4"></i>
                    Upload Pembayaran
                </h1>
                <p class="text-xl text-pink-100 mb-6">
                    Upload bukti pembayaran Anda dalam waktu yang ditentukan
                </p>
                
                <!-- Countdown Timer -->
                <div id="countdown-container" class="glass-effect rounded-2xl p-6 max-w-md mx-auto">
                    <div class="text-center">
                        <i class="fas fa-clock text-4xl text-yellow-300 mb-4 animate-pulse-slow"></i>
                        <p class="text-white font-semibold mb-2">Waktu Tersisa:</p>
                        <div id="countdown" class="text-3xl font-bold text-yellow-300"></div>
                        <p class="text-pink-200 text-sm mt-2">Booking akan dibatalkan otomatis jika waktu habis</p>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="glass-effect rounded-3xl p-8 animate-slide-up">
                    <h2 class="text-3xl font-bold text-white mb-6 text-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Detail Booking
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Booking Info -->
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">Informasi Booking</h3>
                            <div class="space-y-3 text-pink-100">
                                <p><i class="fas fa-ticket-alt mr-3 text-pink-300"></i><strong>ID Booking:</strong> <?= $reservasi['idbooking'] ?></p>
                                <p><i class="fas fa-bed mr-3 text-pink-300"></i><strong>Kamar:</strong> <?= $reservasi['nama_kamar'] ?></p>
                                <p><i class="fas fa-calendar mr-3 text-pink-300"></i><strong>Check-in:</strong> <?= date('d M Y', strtotime($reservasi['tglcheckin'])) ?></p>
                                <p><i class="fas fa-calendar mr-3 text-pink-300"></i><strong>Check-out:</strong> <?= date('d M Y', strtotime($reservasi['tglcheckout'])) ?></p>
                                <p><i class="fas fa-money-bill mr-3 text-pink-300"></i><strong>Total Bayar:</strong> Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                        
                        <!-- Payment Instructions -->
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4">Instruksi Pembayaran</h3>
                            <div class="bg-white/10 rounded-xl p-4 border border-white/20">
                                <div class="space-y-3 text-pink-100 text-sm">
                                    <p><strong class="text-white">Transfer ke rekening:</strong></p>
                                    <p><i class="fas fa-university mr-2 text-pink-300"></i>Bank BCA: 1234567890</p>
                                    <p><i class="fas fa-user mr-2 text-pink-300"></i>A.n. Wisma Citra Sabaleh</p>
                                    <div class="border-t border-white/20 pt-3 mt-3">
                                        <p><strong class="text-white">Nominal:</strong></p>
                                        <p class="text-2xl font-bold text-yellow-300">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="max-w-2xl mx-auto">
                <div class="glass-effect rounded-3xl p-8 animate-slide-up">
                    <h2 class="text-3xl font-bold text-white mb-6 text-center">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>
                        Upload Bukti Pembayaran
                    </h2>

                    <form id="uploadForm" enctype="multipart/form-data">
                        <!-- Drag & Drop Area -->
                        <div id="dropZone" class="drag-drop-zone rounded-2xl p-12 text-center cursor-pointer mb-6">
                            <div id="dropContent">
                                <i class="fas fa-cloud-upload-alt text-6xl text-white/70 mb-4"></i>
                                <p class="text-white text-lg font-semibold mb-2">Drag & Drop file atau klik untuk memilih</p>
                                <p class="text-pink-200 text-sm">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            </div>
                            
                            <!-- Preview Area -->
                            <div id="imagePreview" class="hidden">
                                <img id="previewImg" src="" alt="Preview" class="max-w-full max-h-64 mx-auto rounded-lg">
                                <p id="fileName" class="text-white mt-4 font-semibold"></p>
                                <button type="button" id="removeImage" class="mt-2 text-red-300 hover:text-red-100 transition duration-300">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Hidden File Input -->
                        <input type="file" id="fileInput" name="bukti_bayar" accept="image/*" class="hidden">

                        <!-- Upload Button -->
                        <div class="text-center">
                            <button type="submit" id="uploadBtn" 
                                    class="bg-white text-primary-600 px-12 py-4 rounded-xl font-bold text-xl hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                <i class="fas fa-upload mr-2"></i>
                                Upload Bukti Pembayaran
                            </button>
                            
                            <div class="mt-4">
                                <a href="<?= site_url('online/booking/history') ?>" 
                                   class="text-white hover:text-pink-300 transition duration-300">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke History
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Countdown Timer
        const batasWaktu = new Date('<?= $reservasi['batas_waktu'] ?>').getTime();
        
        function updateCountdown() {
            const sekarang = new Date().getTime();
            const sisaWaktu = batasWaktu - sekarang;
            
            if (sisaWaktu > 0) {
                const menit = Math.floor((sisaWaktu % (1000 * 60 * 60)) / (1000 * 60));
                const detik = Math.floor((sisaWaktu % (1000 * 60)) / 1000);
                
                document.getElementById('countdown').textContent = 
                    `${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;
                
                // Warning jika kurang dari 5 menit
                if (sisaWaktu < 5 * 60 * 1000) {
                    document.getElementById('countdown').classList.add('timer-warning', 'text-red-400');
                    document.getElementById('countdown-container').classList.add('border-red-400');
                }
            } else {
                // Waktu habis
                document.getElementById('countdown').textContent = '00:00';
                document.getElementById('countdown').classList.add('text-red-500');
                
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Waktu upload pembayaran telah habis. Booking akan dibatalkan.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = '<?= site_url('online/booking/history') ?>';
                });
            }
        }
        
        // Update countdown setiap detik
        setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call

        // File Upload Handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const dropContent = document.getElementById('dropContent');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('fileName');
        const removeImage = document.getElementById('removeImage');
        const uploadBtn = document.getElementById('uploadBtn');

        // Click to select file
        dropZone.addEventListener('click', () => {
            if (!imagePreview.classList.contains('hidden')) return;
            fileInput.click();
        });

        // Drag and drop events
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelect(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        // Handle file selection
        function handleFileSelect(file) {
            // Validasi file
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    title: 'File Tidak Valid!',
                    text: 'Silakan pilih file gambar (JPG, PNG, GIF)',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) { // 2MB
                Swal.fire({
                    title: 'File Terlalu Besar!',
                    text: 'Ukuran file maksimal 2MB',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                fileName.textContent = file.name;
                dropContent.classList.add('hidden');
                imagePreview.classList.remove('hidden');
                uploadBtn.disabled = false;
            };
            reader.readAsDataURL(file);
        }

        // Remove image
        removeImage.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.value = '';
            dropContent.classList.remove('hidden');
            imagePreview.classList.add('hidden');
            uploadBtn.disabled = true;
        });

        // Form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!fileInput.files.length) {
                Swal.fire({
                    title: 'Pilih File!',
                    text: 'Silakan pilih file bukti pembayaran terlebih dahulu',
                    icon: 'warning',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Mengupload...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Create FormData
            const formData = new FormData();
            formData.append('bukti_bayar', fileInput.files[0]);

            // Upload file
            fetch('<?= site_url('online/booking/payment/save/' . $reservasi['idbooking']) ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Upload Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#ec4899'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    Swal.fire({
                        title: 'Upload Gagal!',
                        text: data.message || 'Terjadi kesalahan saat mengupload file',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        });
    </script>
</body>
</html> 