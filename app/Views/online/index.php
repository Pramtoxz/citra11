<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisma Citra Sabaleh - Hotel & Penginapan Terbaik</title>
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
                        },
                        secondary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7c3aed',
                            800: '#6b21a8',
                            900: '#581c87',
                            950: '#3b0764',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-gradient {
            background: linear-gradient(135deg, #ec4899, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
        <!-- <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #be123c 0%, #9f1239 25%, #881337 50%, #701a32 75%, #4a0326 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-gradient {
            background: linear-gradient(135deg, #be123c, #9f1239);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style> -->
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white font-bold text-2xl animate-fade-in">
                    <i class="fas fa-hotel mr-2"></i>Citra Sabaleh
                </div>
                <div class="hidden md:flex space-x-8 animate-fade-in">
                    <a href="#home" class="text-white hover:text-pink-300 transition duration-300">Beranda</a>
                    <a href="#rooms" class="text-white hover:text-pink-300 transition duration-300">Kamar</a>
                    <a href="#services" class="text-white hover:text-pink-300 transition duration-300">Layanan</a>
                    <a href="#contact" class="text-white hover:text-pink-300 transition duration-300">Kontak</a>
                </div>
                <div class="hidden md:flex space-x-4 animate-fade-in">
                    <?php if (session()->get('logged_in')): ?>
                        <!-- User Dropdown Menu -->
                        <div class="relative">
                            <button id="userDropdownBtn" class="flex items-center bg-white/20 text-white px-4 py-2 rounded-full hover:bg-white/30 transition duration-300 cursor-pointer">
                                <i class="fas fa-user mr-2"></i>
                                Hai, <?= session()->get('name') ?? session()->get('username') ?>!
                                <i class="fas fa-chevron-down ml-2 text-sm"></i>
                            </button>
                            
                            <!-- Dropdown Content -->
                            <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-56 glass-effect rounded-xl shadow-2xl border border-white/20 py-2 z-50">
                                                        <a href="<?= site_url('online/dashboard') ?>" class="block px-4 py-3 text-white hover:bg-white/10 transition duration-200">
                            <i class="fas fa-tachometer-alt mr-3 text-pink-300"></i>
                            Dashboard
                        </a>
                        <a href="<?= site_url('online/booking') ?>" class="block px-4 py-3 text-white hover:bg-white/10 transition duration-200">
                            <i class="fas fa-plus-circle mr-3 text-pink-300"></i>
                            Booking Baru
                        </a>
                        <a href="<?= site_url('online/booking/history') ?>" class="block px-4 py-3 text-white hover:bg-white/10 transition duration-200">
                            <i class="fas fa-history mr-3 text-pink-300"></i>
                            History Booking
                        </a>
                                <div class="border-t border-white/20 my-1"></div>
                                <a href="<?= site_url('auth/logout') ?>" class="block px-4 py-3 text-white hover:bg-red-500/20 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-300"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= site_url('auth') ?>" class="bg-white/20 text-white px-4 py-2 rounded-full hover:bg-white/30 transition duration-300">Login</a>
                        <a href="<?= site_url('auth/register') ?>" class="bg-white text-primary-600 px-4 py-2 rounded-full hover:bg-pink-50 transition duration-300">Register</a>
                    <?php endif; ?>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-white" id="mobile-menu-btn">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden hidden bg-white/10 backdrop-blur-md" id="mobile-menu">
            <div class="px-6 py-4 space-y-4">
                <a href="#home" class="block text-white hover:text-pink-300">Beranda</a>
                <a href="#rooms" class="block text-white hover:text-pink-300">Kamar</a>
                <a href="#services" class="block text-white hover:text-pink-300">Layanan</a>
                <a href="#contact" class="block text-white hover:text-pink-300">Kontak</a>
                
                <?php if (session()->get('logged_in')): ?>
                    <!-- Mobile User Menu -->
                    <div class="border-t border-white/20 pt-4">
                        <div class="text-white mb-3">
                            <i class="fas fa-user mr-2"></i>
                            <?= session()->get('name') ?? session()->get('username') ?>
                        </div>
                        <a href="<?= site_url('online') ?>" class="block bg-white/20 text-white px-4 py-2 rounded-lg mb-2">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="<?= site_url('online/booking') ?>" class="block bg-white/20 text-white px-4 py-2 rounded-lg mb-2">
                            <i class="fas fa-plus-circle mr-2"></i>Booking Baru
                        </a>
                        <a href="<?= site_url('online/booking/history') ?>" class="block bg-white/20 text-white px-4 py-2 rounded-lg mb-2">
                            <i class="fas fa-history mr-2"></i>History Booking
                        </a>
                        <a href="<?= site_url('auth/logout') ?>" class="block bg-red-500/20 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?= site_url('auth') ?>" class="block bg-white/20 text-white px-4 py-2 rounded-full text-center">Login</a>
                    <a href="<?= site_url('auth/register') ?>" class="block bg-white text-primary-600 px-4 py-2 rounded-full text-center">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center relative overflow-hidden">
        <!-- Floating elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-40 left-20 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="container mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-white animate-slide-up">
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6">
                    Selamat Datang di
                    <span class="text-yellow-300 block">Wisma Citra</span>
                    <span class="text-yellow-300">Sabaleh</span>
                </h1>
                <p class="text-xl lg:text-2xl mb-8 text-pink-100 leading-relaxed">
                    Nikmati pengalaman menginap yang tak terlupakan dengan fasilitas terbaik dan pelayanan premium di jantung kota.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <?php if (session()->get('logged_in')): ?>
                        <a href="<?= site_url('online/booking') ?>" class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-2xl text-center">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Booking Sekarang
                        </a>
                    <?php else: ?>
                        <button onclick="scrollToAvailability()" class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-2xl">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Cek Ketersediaan
                        </button>
                    <?php endif; ?>
                    <a href="#rooms" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-primary-600 transform hover:scale-105 transition duration-300 text-center">
                        <i class="fas fa-bed mr-2"></i>
                        Lihat Kamar
                    </a>
                </div>
            </div>
            
            <!-- Right Content - Hero Image -->
            <div class="relative animate-slide-up" style="animation-delay: 0.3s;">
                <div class="relative z-10">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&h=600" 
                         alt="Hotel Luxury" 
                         class="rounded-3xl shadow-2xl w-full h-[500px] object-cover">
                </div>
                <!-- Floating stats -->
                <div class="absolute -top-6 -right-6 glass-effect rounded-2xl p-6 text-white">
                    <div class="text-2xl font-bold"><?= $stats['rating'] ?? '4.9' ?></div>
                    <div class="text-sm">⭐⭐⭐⭐⭐</div>
                    <div class="text-xs opacity-80">Rating Tamu</div>
                </div>
                <div class="absolute -bottom-6 -left-6 glass-effect rounded-2xl p-6 text-white">
                    <div class="text-2xl font-bold"><?= $stats['tersedia'] ?? '0' ?></div>
                    <div class="text-sm">Kamar Tersedia</div>
                    <div class="text-xs opacity-80">dari <?= $stats['total_kamar'] ?? '0' ?> kamar</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Availability Check Section -->
    <section id="availability" class="py-20 relative">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <!-- Floating Card -->
                <div class="glass-effect rounded-3xl p-8 lg:p-12 shadow-2xl border border-white/20 animate-slide-up">
                    <div class="text-center mb-10">
                        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                            Cek Ketersediaan Kamar
                        </h2>
                        <p class="text-xl text-pink-100">
                            Temukan kamar impian Anda dengan mudah dan cepat
                        </p>
                    </div>
                    
                    <!-- Check Availability Form -->
                    <form id="availabilityForm" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Check-in Date -->
                        <div class="space-y-2">
                            <label class="block text-white font-semibold">
                                <i class="fas fa-calendar-plus mr-2 text-pink-300"></i>
                                Tanggal Check-in
                            </label>
                            <input type="date" 
                                   id="checkin_date" 
                                   name="checkin_date"
                                   required
                                   min="<?= date('Y-m-d') ?>"
                                   class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                        </div>
                        
                        <!-- Check-out Date -->
                        <div class="space-y-2">
                            <label class="block text-white font-semibold">
                                <i class="fas fa-calendar-minus mr-2 text-pink-300"></i>
                                Tanggal Check-out
                            </label>
                            <input type="date" 
                                   id="checkout_date" 
                                   name="checkout_date"
                                   required
                                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                   class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                        </div>
                        
                        <!-- Search Button -->
                        <div class="space-y-2">
                            <label class="block text-transparent font-semibold">Action</label>
                            <button type="submit" 
                                    class="w-full bg-white text-primary-600 px-6 py-3 rounded-xl font-bold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                                <i class="fas fa-search mr-2"></i>
                                Cari Kamar
                            </button>
                        </div>
                    </form>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 pt-8 border-t border-white/20">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                <i class="fas fa-bed text-pink-300 mr-2"></i>
                                15+
                            </div>
                            <div class="text-pink-100">Kamar Tersedia</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                <i class="fas fa-wifi text-pink-300 mr-2"></i>
                                100%
                            </div>
                            <div class="text-pink-100">WiFi Gratis</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">
                                <i class="fas fa-clock text-pink-300 mr-2"></i>
                                24/7
                            </div>
                            <div class="text-pink-100">Layanan Front Desk</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="rooms" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 animate-slide-up">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                    Kamar & Suite
                </h2>
                <p class="text-xl text-pink-100 max-w-3xl mx-auto">
                    Temukan kamar impian Anda dengan berbagai tipe dan fasilitas premium
                </p>
            </div>
            
            <!-- Available Rooms Display -->
            <div id="roomsDisplay" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 animate-slide-up">
                <?php if (!empty($kamar_list)): ?>
                    <?php foreach ($kamar_list as $kamar): ?>
                        <div class="glass-effect rounded-2xl overflow-hidden hover:scale-105 transform transition duration-300">
                            <div class="relative">
                                <?php 
                                $imagePath = !empty($kamar['cover']) ? 
                                    base_url('assets/img/kamar/' . $kamar['cover']) : 
                                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=500&h=300';
                                ?>
                                <img src="<?= $imagePath ?>" 
                                     alt="<?= esc($kamar['nama']) ?>" 
                                     class="w-full h-64 object-cover">
                                
                                <?php if ($kamar['available']): ?>
                                    <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        <i class="fas fa-check mr-1"></i>Available
                                    </div>
                                <?php else: ?>
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                        <i class="fas fa-times mr-1"></i>Booked
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-white mb-2"><?= esc($kamar['nama']) ?></h3>
                                
                                <!-- Fasilitas Kamar -->
                                <div class="mb-4">
                                    <p class="text-sm text-pink-200 mb-2">
                                        <i class="fas fa-check-circle mr-1"></i>Fasilitas:
                                    </p>
                                    <?php if (!empty($kamar['deskripsi'])): ?>
                                        <div class="text-pink-100 text-sm">
                                            <?php 
                                            $fasilitas = explode(',', $kamar['deskripsi']);
                                            foreach($fasilitas as $item): 
                                                $item = trim($item);
                                                if (!empty($item)):
                                            ?>
                                                <span class="inline-block bg-white/10 text-pink-100 px-2 py-1 rounded-full text-xs mr-1 mb-1">
                                                    <i class="fas fa-star mr-1"></i><?= esc($item) ?>
                                                </span>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-pink-100 text-sm">AC, WiFi, TV, Kamar Mandi Dalam</p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-white">
                                        <span class="text-2xl font-bold">Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></span>
                                        <span class="text-pink-200">/malam</span>
                                        <?php if (!empty($kamar['dp']) && $kamar['dp'] > 0): ?>
                                            <div class="text-sm text-yellow-300">
                                                <i class="fas fa-credit-card mr-1"></i>
                                                DP: Rp <?= number_format($kamar['dp'], 0, ',', '.') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <button class="block w-full bg-white text-primary-600 px-4 py-2 rounded-xl font-semibold hover:bg-pink-50 transition duration-300" 
                                                onclick="showRoomDetail('<?= $kamar['id_kamar'] ?>', '<?= esc($kamar['nama']) ?>', '<?= esc($kamar['deskripsi'] ?? '') ?>', <?= $kamar['harga'] ?>, <?= $kamar['dp'] ?? 0 ?>)">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </button>
                                        <?php if ($kamar['available'] && session()->get('logged_in')): ?>
                                            <button class="block w-full bg-green-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-green-600 transition duration-300" 
                                                    onclick="quickBook('<?= $kamar['id_kamar'] ?>')">
                                                <i class="fas fa-calendar-plus mr-1"></i>Book
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback jika tidak ada data kamar -->
                    <div class="col-span-full text-center text-white">
                        <div class="glass-effect rounded-2xl p-12">
                            <i class="fas fa-bed text-6xl text-pink-300 mb-4"></i>
                            <h3 class="text-2xl font-bold mb-2">Belum Ada Data Kamar</h3>
                            <p class="text-pink-100">Silakan hubungi admin untuk menambahkan kamar</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="services" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 animate-slide-up">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                    Fasilitas & Layanan Premium
                </h2>
                <p class="text-xl text-pink-100 max-w-3xl mx-auto">
                    Nikmati berbagai fasilitas terbaik yang kami sediakan untuk kenyamanan Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-wifi text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">WiFi Super Cepat</h3>
                    <p class="text-pink-100">Internet berkecepatan tinggi 24/7 untuk semua kebutuhan Anda</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-car text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Parkir Gratis</h3>
                    <p class="text-pink-100">Area parkir luas dan aman untuk kendaraan roda dua dan empat</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-concierge-bell text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Room Service</h3>
                    <p class="text-pink-100">Layanan kamar 24 jam dengan menu makanan dan minuman terbaik</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up" style="animation-delay: 0.3s;">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Keamanan 24/7</h3>
                    <p class="text-pink-100">Sistem keamanan terdepan dengan CCTV dan petugas keamanan</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up" style="animation-delay: 0.4s;">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-snowflake text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">AC Central</h3>
                    <p class="text-pink-100">Pendingin ruangan terkontrol untuk kenyamanan maksimal</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="glass-effect rounded-2xl p-8 text-center transform hover:scale-105 transition duration-300 animate-slide-up" style="animation-delay: 0.5s;">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-utensils text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Restoran</h3>
                    <p class="text-pink-100">Restoran dengan masakan lokal dan internasional terbaik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="container mx-auto px-6">
            <div class="glass-effect rounded-3xl p-12 text-center animate-slide-up">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                    Siap untuk Pengalaman Tak Terlupakan?
                </h2>
                <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
                    Booking sekarang dan nikmati promo spesial untuk tamu baru!
                </p>
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= site_url('online/booking') ?>" class="bg-white text-primary-600 px-12 py-4 rounded-full font-bold text-xl hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-2xl inline-block">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Book Now - Booking Langsung!
                    </a>
                <?php else: ?>
                    <button onclick="scrollToAvailability()" class="bg-white text-primary-600 px-12 py-4 rounded-full font-bold text-xl hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-2xl">
                        <i class="fas fa-rocket mr-2"></i>
                        Book Now - Dapatkan Promo!
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-4">
                        <i class="fas fa-hotel mr-2"></i>
                        Wisma Citra Sabaleh
                    </h3>
                    <p class="text-pink-100">
                        Hotel dan penginapan terbaik dengan fasilitas modern dan pelayanan prima.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Kontak</h4>
                    <div class="space-y-2 text-pink-100">
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Jl. Kp. Jawa Dalam IV Jl. Kp. Jawa Dalam No.21, Kec. Padang Barat, Kota Padang, Sumatera Barat 52112</p>
                        <p><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</p>
                        <p><i class="fas fa-envelope mr-2"></i> info@citrasabaleh.com</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Ikuti Kami</h4>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition duration-300">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 pt-8 border-t border-white/20">
                <p class="text-pink-100">
                    © 2025 Wisma Citra Sabaleh. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // User dropdown toggle (desktop)
        <?php if (session()->get('logged_in')): ?>
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

        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('userDropdownMenu').classList.add('hidden');
            }
        });
        <?php endif; ?>

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('glass-effect');
            } else {
                navbar.classList.remove('glass-effect');
            }
        });

        // Smooth scroll to availability section
        function scrollToAvailability() {
            document.getElementById('availability').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Update the form submission for availability check to work with real booking
        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const checkinDate = document.getElementById('checkin_date').value;
            const checkoutDate = document.getElementById('checkout_date').value;
            
            if (!checkinDate || !checkoutDate) {
                Swal.fire({
                    title: 'Lengkapi Form!',
                    text: 'Silakan pilih tanggal check-in dan check-out',
                    icon: 'warning',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }
            
            if (new Date(checkinDate) >= new Date(checkoutDate)) {
                Swal.fire({
                    title: 'Tanggal Tidak Valid!',
                    text: 'Tanggal check-out harus setelah tanggal check-in',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }
            
            <?php if (session()->get('logged_in')): ?>
                // Redirect to booking page with dates
                const bookingUrl = '<?= site_url('online/booking') ?>?checkin=' + checkinDate + '&checkout=' + checkoutDate;
                window.location.href = bookingUrl;
            <?php else: ?>
                // Show login prompt
                Swal.fire({
                    title: 'Login Diperlukan',
                    html: `<div class="text-center">
                        <i class="fas fa-user-lock text-4xl text-pink-500 mb-4"></i>
                        <p class="text-gray-600 mb-4">Anda perlu login untuk melakukan booking</p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                            <p class="text-blue-800 text-sm">
                                <strong>Tanggal pilihan:</strong><br>
                                Check-in: ${checkinDate}<br>
                                Check-out: ${checkoutDate}
                            </p>
                        </div>
                    </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ec4899',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Store dates in sessionStorage for after login
                        sessionStorage.setItem('booking_checkin', checkinDate);
                        sessionStorage.setItem('booking_checkout', checkoutDate);
                        window.location.href = '<?= site_url('auth') ?>';
                    }
                });
            <?php endif; ?>
        });

        // Set default dates
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            document.getElementById('checkin_date').value = today.toISOString().split('T')[0];
            document.getElementById('checkout_date').value = tomorrow.toISOString().split('T')[0];
        });
        
        // Function untuk show room detail
        function showRoomDetail(roomId, roomName, fasilitas, harga, dp) {
            // Parse fasilitas
            let fasilitasList = '';
            if (fasilitas && fasilitas.trim() !== '') {
                const fasilitasArray = fasilitas.split(',');
                fasilitasList = fasilitasArray.map(item => 
                    `<span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs mr-2 mb-2">
                        <i class="fas fa-check mr-1"></i>${item.trim()}
                    </span>`
                ).join('');
            } else {
                fasilitasList = `
                    <span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs mr-2 mb-2">
                        <i class="fas fa-check mr-1"></i>AC
                    </span>
                    <span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs mr-2 mb-2">
                        <i class="fas fa-check mr-1"></i>WiFi
                    </span>
                    <span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs mr-2 mb-2">
                        <i class="fas fa-check mr-1"></i>TV
                    </span>
                    <span class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs mr-2 mb-2">
                        <i class="fas fa-check mr-1"></i>Kamar Mandi Dalam
                    </span>
                `;
            }

            let dpInfo = '';
            if (dp && dp > 0) {
                dpInfo = `
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                        <p class="text-yellow-800 text-sm">
                            <i class="fas fa-credit-card mr-2"></i>
                            <strong>Tersedia pembayaran DP:</strong> Rp ${dp.toLocaleString()}
                        </p>
                    </div>
                `;
            }

            Swal.fire({
                title: roomName,
                html: `<div class="text-left">
                    <div class="mb-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">
                            <i class="fas fa-star text-pink-500 mr-2"></i>Fasilitas Kamar
                        </h4>
                        <div class="text-left">
                            ${fasilitasList}
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">
                            <i class="fas fa-money-bill text-green-500 mr-2"></i>Harga
                        </h4>
                        <p class="text-2xl font-bold text-green-600">Rp ${harga.toLocaleString()}</p>
                        <p class="text-gray-600 text-sm">per malam</p>
                    </div>
                    
                    ${dpInfo}
                    
                    <div class="text-center mt-6">
                        <?php if (session()->get('logged_in')): ?>
                            <button onclick="startBooking('${roomId}')" 
                                    class="bg-pink-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-pink-600 transition duration-300">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                Mulai Booking
                            </button>
                        <?php else: ?>
                            <p class="text-gray-600 mb-3">Silakan login untuk melakukan booking</p>
                            <a href="<?= site_url('auth') ?>" 
                               class="inline-block bg-pink-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-pink-600 transition duration-300">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login untuk Booking
                            </a>
                        <?php endif; ?>
                    </div>
                </div>`,
                showConfirmButton: false,
                showCloseButton: true,
                width: '600px',
                customClass: {
                    popup: 'text-left'
                }
            });
        }

        // Function untuk quick booking
        function quickBook(roomId) {
            <?php if (session()->get('logged_in')): ?>
                startBooking(roomId);
            <?php else: ?>
                Swal.fire({
                    title: 'Login Diperlukan',
                    html: `<div class="text-center">
                        <i class="fas fa-user-lock text-4xl text-pink-500 mb-4"></i>
                        <p class="text-gray-600 mb-4">Anda perlu login terlebih dahulu untuk melakukan booking</p>
                    </div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ec4899',
                    cancelButtonColor: '#6b7280'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= site_url('auth') ?>';
                    }
                });
            <?php endif; ?>
        }

        // Function untuk start booking
        function startBooking(roomId) {
            Swal.fire({
                title: 'Mulai Booking',
                html: `<div class="text-center">
                    <i class="fas fa-calendar-check text-4xl text-green-500 mb-4"></i>
                    <p class="text-gray-600 mb-4">Anda akan diarahkan ke halaman booking</p>
                </div>`,
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= site_url('online/booking') ?>?room=' + roomId;
                }
            });
        }
    </script>
</body>
</html>
