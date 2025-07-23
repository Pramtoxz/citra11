<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Gigi Sehat Bersinar - Kesehatan Gigi Terbaik</title>
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        .gradient-bg {
            background: linear-gradient(120deg, #0d9488 0%, #2dd4bf 100%);
        }
        .hero-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .hero-wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 80px;
        }
        .hero-wave .shape-fill {
            fill: #FFFFFF;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-tooth text-teal-600 text-3xl"></i>
                <span class="text-2xl font-bold text-teal-800">KlinikGigi</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#beranda" class="text-teal-800 hover:text-teal-600 font-medium">Beranda</a>
                <a href="#layanan" class="text-teal-800 hover:text-teal-600 font-medium">Layanan</a>
                <a href="#dokter" class="text-teal-800 hover:text-teal-600 font-medium">Dokter</a>
                <a href="#jadwal" class="text-teal-800 hover:text-teal-600 font-medium">Jadwal</a>
                <a href="#kontak" class="text-teal-800 hover:text-teal-600 font-medium">Kontak</a>
            </div>
            <div>
                <?php if (session()->get('logged_in')): ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 bg-gradient-to-r from-teal-500 to-teal-700 text-white px-4 py-2 rounded-full font-medium hover:shadow-lg transition duration-300">
                            <i class="fas fa-user-circle text-xl"></i>
                            <span><?= session()->get('nama') ? session()->get('nama') : 'Profil' ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-20 hidden group-hover:block">
                            <a href="<?= base_url('online/booking'); ?>" class="block px-4 py-2 text-teal-800 hover:bg-teal-50">
                                <i class="fas fa-calendar-plus mr-2"></i> Booking Baru
                            </a>
                            <a href="<?= base_url('pasien/histori'); ?>" class="block px-4 py-2 text-teal-800 hover:bg-teal-50">
                                <i class="fas fa-history mr-2"></i> Histori Booking
                            </a>
                            <a href="<?= base_url('pasien/edit-profil'); ?>" class="block px-4 py-2 text-teal-800 hover:bg-teal-50">
                                <i class="fas fa-user-edit mr-2"></i> Edit Profil
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="<?= base_url('auth/logout'); ?>" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth'); ?>" class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-full font-medium hover:shadow-lg transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative gradient-bg pt-28 pb-20 md:pb-32">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-white mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Senyum Sehat, Hidup Bahagia</h1>
                <p class="text-lg md:text-xl mb-8 opacity-90">Temukan perawatan gigi berkualitas tinggi dengan dokter gigi profesional kami. Jadwalkan kunjungan Anda sekarang!</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <?php if (session()->get('logged_in')): ?>
                        <a href="<?= base_url('online/booking'); ?>" class="bg-white text-teal-700 px-8 py-3 rounded-full font-semibold text-center hover:bg-teal-50 transition duration-300 shadow-lg">
                            <i class="fas fa-calendar-plus mr-2"></i>Booking Online
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('auth'); ?>" class="bg-white text-teal-700 px-8 py-3 rounded-full font-semibold text-center hover:bg-teal-50 transition duration-300 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Booking
                        </a>
                    <?php endif; ?>
                    <a href="#jadwal" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-full font-semibold text-center hover:bg-white hover:text-teal-700 transition duration-300">Lihat Jadwal</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="https://cdn.pixabay.com/photo/2017/07/23/10/44/dentist-2530990_1280.jpg" alt="Klinik Gigi" class="rounded-lg shadow-2xl max-w-full h-auto" style="max-height: 450px;">
            </div>
        </div>
        <div class="hero-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Layanan Section -->
    <section id="layanan" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800 mb-4">Layanan Perawatan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Kami menawarkan berbagai perawatan gigi berkualitas tinggi untuk menjaga kesehatan dan keindahan senyum Anda</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($jenis as $item): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="h-3 gradient-bg"></div>
                    <div class="p-6">
                        <div class="w-14 h-14 rounded-full gradient-bg flex items-center justify-center mb-6">
                            <i class="fas fa-tooth text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-teal-800 mb-3"><?= $item['namajenis'] ?></h3>
                        <p class="text-gray-600"><?= isset($item['keterangan']) ? $item['keterangan'] : 'Perawatan gigi profesional untuk menjaga kesehatan dan keindahan senyum Anda.' ?></p>
                        <div class="mt-5">
                            <a href="#" class="text-teal-600 font-medium hover:text-teal-800 inline-flex items-center">
                                Detail Layanan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Dokter Section -->
    <section id="dokter" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800 mb-4">Dokter Gigi Profesional</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Tim dokter gigi kami terdiri dari profesional berpengalaman yang siap memberikan perawatan terbaik</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php foreach ($dokter as $dr): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                    <div class="h-48 overflow-hidden">
                        <?php if (!empty($dr['foto']) && file_exists('assets/img/dokter/' . $dr['foto'])): ?>
                            <img src="<?= base_url('assets/img/dokter/' . $dr['foto']) ?>" alt="<?= $dr['nama'] ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <img src="<?= base_url('assets/img/dokter.png') ?>" alt="<?= $dr['nama'] ?>" class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-teal-800"><?= $dr['nama'] ?></h3>
                        <p class="text-teal-600 mb-4"><?= $dr['spesialis'] ?? 'Dokter Gigi' ?></p>
                        <div class="flex space-x-3">
                            <a href="#" class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 hover:bg-teal-600 hover:text-white transition-all">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 hover:bg-teal-600 hover:text-white transition-all">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 hover:bg-teal-600 hover:text-white transition-all">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Jadwal Section -->
    <section id="jadwal" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800 mb-4">Jadwal Praktik Dokter</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Silakan pilih waktu yang tepat untuk kunjungan Anda</p>
            </div>
            
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full">
                    <thead>
                        <tr class="gradient-bg text-white">
                            <th class="py-3 px-4 text-left">Nama Dokter</th>
                            <th class="py-3 px-4 text-left">Hari</th>
                            <th class="py-3 px-4 text-left">Jam Mulai</th>
                            <th class="py-3 px-4 text-left">Jam Selesai</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($jadwal as $jdwl): ?>
                            <?php
                            // Cari dokter yang sesuai dengan id dokter di jadwal
                            $dokterData = null;
                            foreach ($dokter as $dr) {
                                if ($dr['id_dokter'] == $jdwl['iddokter']) {
                                    $dokterData = $dr;
                                    break;
                                }
                            }
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4"><?= $dokterData ? $dokterData['nama'] : 'Dokter tidak ditemukan' ?></td>
                                <td class="py-3 px-4"><?= $jdwl['hari'] ?></td>
                                <td class="py-3 px-4"><?= $jdwl['waktu_mulai'] ?></td>
                                <td class="py-3 px-4"><?= $jdwl['waktu_selesai'] ?></td>
                                <td class="py-3 px-4">
                                    <?php if (session()->get('logged_in')): ?>
                                        <a href="<?= base_url('online/booking') ?>" class="bg-teal-600 text-white px-4 py-1 rounded hover:bg-teal-700 transition">
                                            <i class="fas fa-calendar-plus mr-1"></i> Booking
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('auth') ?>" class="bg-teal-600 text-white px-4 py-1 rounded hover:bg-teal-700 transition">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800 mb-4">Testimoni Pasien</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Apa kata mereka tentang pelayanan kami</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Pelayanan sangat memuaskan. Dokter dan staf ramah, peralatan modern dan bersih. Sakit gigi saya hilang dan hasil perawatan sangat bagus!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold text-teal-800">Budi Santoso</h4>
                            <p class="text-gray-500 text-sm">Pasien Tambal Gigi</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Saya sangat puas dengan hasil perawatan behel saya. Proses booking online sangat mudah dan dokternya sangat profesional. Terima kasih Klinik Gigi!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold text-teal-800">Siti Nurhayati</h4>
                            <p class="text-gray-500 text-sm">Pasien Pemasangan Behel</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6">"Anak saya yang biasanya takut ke dokter gigi jadi senang berkunjung ke klinik ini. Dokter sangat sabar dan ramah terhadap anak-anak. Tempat juga nyaman dan bersih."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                        <div>
                            <h4 class="font-semibold text-teal-800">Dian Purnama</h4>
                            <p class="text-gray-500 text-sm">Pasien Perawatan Anak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Jadwalkan Kunjungan Anda Sekarang!</h2>
            <p class="text-white opacity-90 max-w-2xl mx-auto mb-8 text-lg">Dapatkan senyum yang sehat dan indah dengan perawatan gigi profesional dari tim dokter kami</p>
            <?php if (session()->get('logged_in')): ?>
                <a href="<?= base_url('online/booking'); ?>" class="inline-block bg-white text-teal-700 px-8 py-3 rounded-full font-semibold text-lg hover:bg-teal-50 transition duration-300 shadow-lg">
                    <i class="fas fa-calendar-plus mr-2"></i>Booking Online
                </a>
            <?php else: ?>
                <a href="<?= base_url('auth'); ?>" class="inline-block bg-white text-teal-700 px-8 py-3 rounded-full font-semibold text-lg hover:bg-teal-50 transition duration-300 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Booking
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800 mb-4">Hubungi Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Ada pertanyaan? Jangan ragu untuk menghubungi kami</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-10">
                <div class="md:w-1/2 bg-gray-50 rounded-xl p-8 shadow-md">
                    <h3 class="text-2xl font-semibold text-teal-800 mb-6">Informasi Kontak</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full gradient-bg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-teal-800">Alamat</h4>
                                <p class="text-gray-600">Jl. Kesehatan No. 123, Surabaya, Jawa Timur, Indonesia</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full gradient-bg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-teal-800">Telepon</h4>
                                <p class="text-gray-600">+62 812-3456-7890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full gradient-bg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-teal-800">Email</h4>
                                <p class="text-gray-600">info@klinikgigi.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full gradient-bg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-teal-800">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Sabtu: 08:00 - 20:00 <br>Minggu: 09:00 - 15:00</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                        <h4 class="text-lg font-medium text-teal-800 mb-4">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white hover:opacity-90 transition-all">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white hover:opacity-90 transition-all">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white hover:opacity-90 transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white hover:opacity-90 transition-all">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-1/2 bg-white rounded-xl p-8 shadow-md">
                    <h3 class="text-2xl font-semibold text-teal-800 mb-6">Kirim Pesan</h3>
                    
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        
                        <div class="mb-6">
                            <label for="message" class="block text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <i class="fas fa-tooth text-teal-400 text-3xl"></i>
                        <span class="text-2xl font-bold text-white">KlinikGigi</span>
                    </div>
                    <p class="text-gray-400 mb-6">Kesehatan gigi dan mulut Anda adalah prioritas kami. Kami berkomitmen memberikan pelayanan terbaik dengan teknologi modern.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-teal-400">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-teal-400">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-teal-400">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-teal-400">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-6">Link Cepat</h3>
                    <ul class="space-y-3">
                        <li><a href="#beranda" class="text-gray-400 hover:text-teal-400">Beranda</a></li>
                        <li><a href="#layanan" class="text-gray-400 hover:text-teal-400">Layanan</a></li>
                        <li><a href="#dokter" class="text-gray-400 hover:text-teal-400">Dokter</a></li>
                        <li><a href="#jadwal" class="text-gray-400 hover:text-teal-400">Jadwal</a></li>
                        <li><a href="#kontak" class="text-gray-400 hover:text-teal-400">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-6">Layanan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Pemeriksaan Gigi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Pembersihan Karang Gigi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Perawatan Saluran Akar</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Pemasangan Behel</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-teal-400">Implan Gigi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-xl font-semibold mb-6">Hubungi Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">Jl. Kesehatan No. 123, Surabaya, Jawa Timur</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-teal-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">info@klinikgigi.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-6">
                <p class="text-center text-gray-500">© <?= date('Y') ?> Klinik Gigi. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Handle profile dropdown on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdown = document.querySelector('.group button');
            const dropdownMenu = document.querySelector('.group .absolute');
            
            if (profileDropdown && dropdownMenu) {
                // For mobile - toggle on click
                profileDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });
                
                // Close when clicking outside
                document.addEventListener('click', function(e) {
                    if (!profileDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
