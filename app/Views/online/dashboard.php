<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wisma Citra Sabaleh</title>
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
        .text-gradient {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
                    <div class="relative">
                        <button id="userDropdownBtn" class="flex items-center bg-white/20 text-white px-4 py-2 rounded-full hover:bg-white/30 transition duration-300 cursor-pointer">
                            <i class="fas fa-user mr-2"></i>
                            <?= session()->get('name') ?? session()->get('username') ?>
                            <i class="fas fa-chevron-down ml-2 text-sm"></i>
                        </button>
                        
                        <!-- Dropdown Content -->
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-50">
                            <a href="#" onclick="editProfile()" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 transition duration-200">
                                <i class="fas fa-user-edit mr-3 text-primary-500"></i>
                                Edit Profile
                            </a>
                            <a href="<?= site_url('online/booking/history') ?>" class="block px-4 py-3 text-gray-800 hover:bg-gray-100 transition duration-200">
                                <i class="fas fa-history mr-3 text-primary-500"></i>
                                History Booking
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-3 text-gray-800 hover:bg-red-50 transition duration-200">
                                <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 pb-10">
        <!-- Floating elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-40 left-20 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        </div>

        <div class="container mx-auto px-6">
            <!-- Welcome Section -->
            <div class="text-center mb-12 animate-slide-up">
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">
                    Selamat Datang,
                    <span class="text-gradient"><?= $tamu['nama'] ?? session()->get('username') ?></span>
                </h1>
                <p class="text-xl text-pink-100 mb-8">
                    Kelola booking dan nikmati pengalaman menginap terbaik
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 animate-slide-up">
                <!-- Total Kamar -->
                <div class="glass-effect rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bed text-3xl text-blue-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= $total_kamar ?></h3>
                    <p class="text-gray-600">Total Kamar Tersedia</p>
                </div>

                <!-- My Bookings -->
                <div class="glass-effect rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-check text-3xl text-green-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= count($reservasi_user) ?></h3>
                    <p class="text-gray-600">Total Booking Saya</p>
                </div>

                <!-- Rating -->
                <div class="glass-effect rounded-2xl p-6 text-center">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-3xl text-yellow-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">4.9</h3>
                    <p class="text-gray-600">Rating Hotel</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- Book New Room -->
                <div class="glass-effect rounded-3xl p-8 animate-slide-up">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-primary-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-plus-circle text-4xl text-primary-300"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Booking Baru</h3>
                        <p class="text-gray-600 mb-6">
                            Cari dan booking kamar sesuai kebutuhan Anda
                        </p>
                        <a href="<?= site_url('online/booking') ?>" class="inline-block bg-white text-primary-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                            <i class="fas fa-search mr-2"></i>
                            Cari Kamar
                        </a>
                    </div>
                </div>

                <!-- My Profile -->
                <div class="glass-effect rounded-3xl p-8 animate-slide-up">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-circle text-4xl text-purple-300"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">Profil Saya</h3>
                        <p class="text-gray-600 mb-6">
                            Kelola informasi pribadi dan preferensi
                        </p>
                        <button onclick="editProfile()" class="bg-white text-primary-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profil
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div id="history" class="glass-effect rounded-3xl p-8 mb-12 animate-slide-up">
                <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-history mr-2"></i>
                    Riwayat Booking Terbaru
                </h3>
                
                <?php if (!empty($reservasi_user)): ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <?php foreach ($reservasi_user as $booking): ?>
                            <div class="bg-white/10 rounded-2xl p-6 border border-white/20">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-800 mb-2">
                                            <?= esc($booking['nama_kamar'] ?? 'Kamar') ?>
                                        </h4>
                                        <p class="text-gray-600 text-sm">
                                            Booking ID: #<?= $booking['idbooking'] ?>
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-sm font-bold
                                        <?php 
                                        switch($booking['status']) {
                                            case 'diproses': 
                                                echo !empty($booking['buktibayar']) ? 'bg-blue-500 text-white' : 'bg-orange-500 text-white'; 
                                                break;
                                            case 'diterima': echo 'bg-green-500 text-white'; break;
                                            case 'ditolak': echo 'bg-red-500 text-white'; break;
                                            case 'limit': echo 'bg-gray-600 text-white'; break;
                                            case 'checkin': echo 'bg-blue-500 text-white'; break;
                                            case 'selesai': echo 'bg-purple-500 text-white'; break;
                                            case 'cancel': echo 'bg-gray-500 text-white'; break;
                                            default: echo 'bg-gray-400 text-white';
                                        }
                                        ?>">
                                        <?php
                                        switch($booking['status']) {
                                            case 'diproses': 
                                                echo !empty($booking['buktibayar']) ? 'Menunggu Verifikasi' : 'Perlu Upload'; 
                                                break;
                                            case 'diterima': echo 'Diterima'; break;
                                            case 'ditolak': echo 'Ditolak'; break;
                                            case 'limit': echo 'Waktu Habis'; break;
                                            case 'checkin': echo 'Check-in'; break;
                                            case 'selesai': echo 'Selesai'; break;
                                            case 'cancel': echo 'Dibatalkan'; break;
                                            default: echo ucfirst($booking['status']);
                                        }
                                        ?>
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-gray-700">
                                    <p><i class="fas fa-calendar mr-2"></i>
                                        <?= date('d M Y', strtotime($booking['tglcheckin'])) ?> - 
                                        <?= date('d M Y', strtotime($booking['tglcheckout'])) ?>
                                    </p>
                                    <p><i class="fas fa-credit-card mr-2"></i>
                                        <?= ucfirst($booking['tipe'] ?? 'lunas') ?> 
                                        <?php if (($booking['tipe'] ?? '') === 'dp'): ?>
                                            <span class="text-yellow-600">(DP)</span>
                                        <?php endif; ?>
                                    </p>
                                    <p><i class="fas fa-money-bill mr-2"></i>
                                        Rp <?= number_format($booking['totalbayar'], 0, ',', '.') ?>
                                    </p>
                                </div>
                                
                                <div class="mt-4 flex gap-2">
                                    <a href="<?= site_url('online/booking/detail/' . $booking['idbooking']) ?>" 
                                       class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-600 transition duration-300 text-center">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                    
                                    <?php if ($booking['status'] == 'diproses'): ?>
                                        <?php if (empty($booking['buktibayar'])): ?>
                                            <!-- Belum upload bukti bayar -->
                                            <?php if (!empty($booking['batas_waktu'])): ?>
                                                <?php 
                                                $batasWaktu = strtotime($booking['batas_waktu']);
                                                $sekarang = time();
                                                $sisaWaktu = $batasWaktu - $sekarang;
                                                ?>
                                                <?php if ($sisaWaktu > 0): ?>
                                                    <a href="<?= site_url('online/booking/payment/' . $booking['idbooking']) ?>" 
                                                       class="flex-1 bg-orange-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-orange-600 transition duration-300 text-center animate-pulse">
                                                        <i class="fas fa-upload mr-1"></i>Upload
                                                        <span class="text-xs block">⏰ <?= ceil($sisaWaktu / 60) ?> menit</span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <!-- Sudah upload, menunggu verifikasi -->
                                            <div class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-center">
                                                <i class="fas fa-clock mr-1"></i>Verifikasi
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif ($booking['status'] == 'ditolak'): ?>
                                        <a href="<?= site_url('online/booking/payment/' . $booking['idbooking']) ?>" 
                                           class="flex-1 bg-red-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-red-600 transition duration-300 text-center">
                                            <i class="fas fa-redo mr-1"></i>Upload Ulang
                                        </a>
                                    <?php elseif ($booking['status'] == 'diterima'): ?>
                                        <a href="<?= site_url('online/booking/faktur/' . $booking['idbooking']) ?>" 
                                           class="flex-1 bg-green-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-600 transition duration-300 text-center">
                                            <i class="fas fa-file-invoice mr-1"></i>Faktur
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-calendar-times text-6xl text-pink-300 mb-4"></i>
                        <h4 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Booking</h4>
                        <p class="text-gray-600 mb-6">Mulai petualangan Anda dengan booking kamar pertama!</p>
                        <a href="<?= site_url('online/booking') ?>" class="inline-block bg-white text-primary-600 px-8 py-3 rounded-xl font-bold hover:bg-pink-50 transition duration-300">
                            <i class="fas fa-plus mr-2"></i>Booking Sekarang
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // User dropdown toggle
        document.getElementById('userDropdownBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('userDropdownMenu');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdownMenu');
            const button = document.getElementById('userDropdownBtn');
            
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Scroll to history section
        function scrollToHistory() {
            document.getElementById('userDropdownMenu').classList.add('hidden');
            document.getElementById('history').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Show booking form
        function showBookingForm() {
            window.location.href = '<?= site_url('online/booking') ?>';
        }

        // Edit profile function dengan SweetAlert2 modal
        function editProfile() {
            document.getElementById('userDropdownMenu').classList.add('hidden');
            
            // Show loading
            Swal.fire({
                title: 'Memuat Data Profile...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch profile data
            fetch('<?= site_url('online/profile/get-data') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showEditProfileModal(data.data);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Gagal memuat data profile',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        }

        // Show edit profile modal
        function showEditProfileModal(profileData) {
            const { tamu, user } = profileData;
            
            Swal.fire({
                title: 'Edit Profile',
                html: `
                    <div class="text-left">
                        <form id="editProfileForm" class="space-y-4">
                            <!-- Data Tamu -->
                            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                <h4 class="font-bold text-blue-800 mb-3">
                                    <i class="fas fa-user mr-2"></i>Data Pribadi
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                        <input type="text" value="${tamu.nik}" disabled 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                                        <small class="text-gray-500">NIK tidak dapat diubah</small>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                                        <input type="text" id="edit_nama" value="${tamu.nama}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat *</label>
                                    <textarea id="edit_alamat" required rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">${tamu.alamat}</textarea>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No. HP *</label>
                                        <input type="tel" id="edit_nohp" value="${tamu.nohp}" required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin *</label>
                                        <select id="edit_jk" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                            <option value="L" ${tamu.jk === 'L' ? 'selected' : ''}>Laki-laki</option>
                                            <option value="P" ${tamu.jk === 'P' ? 'selected' : ''}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Data Akun -->
                            <div class="bg-green-50 rounded-lg p-4 mb-4">
                                <h4 class="font-bold text-green-800 mb-3">
                                    <i class="fas fa-key mr-2"></i>Data Akun
                                </h4>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                    <input type="text" value="${user.username}" disabled 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                                    <small class="text-gray-500">Username tidak dapat diubah</small>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" id="edit_email" value="${user.email}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                        <input type="password" id="edit_password" placeholder="Kosongkan jika tidak ingin mengubah"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                        <small class="text-gray-500">Minimal 6 karakter</small>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                        <input type="password" id="edit_confirm_password" placeholder="Konfirmasi password baru"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                <p class="text-yellow-800 text-sm">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Catatan:</strong> Field bertanda (*) wajib diisi. Password baru opsional.
                                </p>
                            </div>
                        </form>
                    </div>
                `,
                width: '600px',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-save mr-2"></i>Simpan Perubahan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'text-left'
                },
                preConfirm: () => {
                    return saveProfileChanges();
                }
            });
        }

        // Save profile changes
        function saveProfileChanges() {
            const nama = document.getElementById('edit_nama').value.trim();
            const alamat = document.getElementById('edit_alamat').value.trim();
            const nohp = document.getElementById('edit_nohp').value.trim();
            const jk = document.getElementById('edit_jk').value;
            const email = document.getElementById('edit_email').value.trim();
            const password = document.getElementById('edit_password').value;
            const confirmPassword = document.getElementById('edit_confirm_password').value;

            // Validasi client-side
            if (!nama || !alamat || !nohp || !jk || !email) {
                Swal.showValidationMessage('Harap lengkapi semua field yang wajib diisi');
                return false;
            }

            if (nama.length < 3) {
                Swal.showValidationMessage('Nama minimal 3 karakter');
                return false;
            }

            if (alamat.length < 10) {
                Swal.showValidationMessage('Alamat minimal 10 karakter');
                return false;
            }

            if (nohp.length < 10) {
                Swal.showValidationMessage('Nomor HP minimal 10 digit');
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.showValidationMessage('Format email tidak valid');
                return false;
            }

            if (password && password.length < 6) {
                Swal.showValidationMessage('Password minimal 6 karakter');
                return false;
            }

            if (password && password !== confirmPassword) {
                Swal.showValidationMessage('Konfirmasi password tidak cocok');
                return false;
            }

            // Prepare data
            const formData = new FormData();
            formData.append('nama', nama);
            formData.append('alamat', alamat);
            formData.append('nohp', nohp);
            formData.append('jk', jk);
            formData.append('email', email);
            if (password) {
                formData.append('password', password);
                formData.append('confirm_password', confirmPassword);
            }

            // Send update request
            return fetch('<?= site_url('online/profile/update-complete') ?>', {
                method: 'POST',
                body: formData,
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
                        // Reload page untuk update data
                        window.location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'Gagal menyimpan perubahan';
                    if (data.errors) {
                        errorMessage += '\\n\\n' + Object.values(data.errors).join('\\n');
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        }
        
    </script>
</body>
</html> 