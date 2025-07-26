<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'gradient': 'gradient 15s ease infinite',
                    'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'bounce-slow': 'bounce 3s infinite',
                    'shimmer': 'shimmer 2s linear infinite',
                }
            }
        }
    }
</script>

<!-- Custom Styles -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes gradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    .gradient-bg {
        background: linear-gradient(-45deg, #D81B60, #C2185B, #E91E63, #AD1457, #D81B60);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .card-hover:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .shimmer-effect {
        position: relative;
        overflow: hidden;
    }
    .shimmer-effect::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
        animation: shimmer 2s infinite;
    }
</style>

<!-- Animated Background -->
<div class="fixed inset-0 gradient-bg"></div>
<div class="fixed inset-0 bg-black bg-opacity-20"></div>

<!-- Floating Particles -->
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-white bg-opacity-20 rounded-full animate-float"></div>
    <div class="absolute top-1/3 right-1/4 w-6 h-6 bg-pink-200 bg-opacity-30 rounded-full animate-float" style="animation-delay: -2s;"></div>
    <div class="absolute bottom-1/4 left-1/3 w-3 h-3 bg-white bg-opacity-15 rounded-full animate-float" style="animation-delay: -4s;"></div>
    <div class="absolute top-1/2 right-1/3 w-5 h-5 bg-pink-300 bg-opacity-25 rounded-full animate-float" style="animation-delay: -1s;"></div>
</div>

<!-- Main Content Container -->
<div class="relative z-10 min-h-screen p-4 lg:p-8">
    
    <!-- Header Section -->
    <div class="mb-8">
        <div class="glass-effect rounded-3xl p-6 mb-6 shimmer-effect">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white mb-2 bg-gradient-to-r from-white to-pink-200 bg-clip-text text-transparent">
                        ✨ Dashboard Wisma Citra Sabaleh
                    </h1>
                    <p class="text-pink-100 text-lg opacity-90">Selamat datang, <?= session()->get('role') === 'admin' ? 'Administrator' : 'Pimpinan' ?> 👋</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <div class="glass-effect rounded-2xl px-6 py-3">
                        <p class="text-white font-semibold"><?= date('l, d F Y') ?></p>
                        <p class="text-pink-200 text-sm" id="currentTime"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Kamar Card -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500 shimmer-effect group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white"><?= number_format($total_kamar) ?></p>
                    <p class="text-blue-200 text-sm font-medium">Total Kamar</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-green-300 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    100% Aktif
                </span>
                <a href="<?= base_url('kamar') ?>" class="text-white hover:text-blue-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Kamar Tersedia Card -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500 shimmer-effect group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white"><?= number_format($kamar_tersedia) ?></p>
                    <p class="text-emerald-200 text-sm font-medium">Kamar Tersedia</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                                 <span class="text-pink-300 text-sm flex items-center">
                     <div class="w-2 h-2 bg-pink-400 rounded-full mr-2 animate-pulse"></div>
                     <?= round(($kamar_tersedia / $total_kamar) * 100, 1) ?>% Available
                 </span>
                 <a href="<?= base_url('kamar') ?>" class="text-white hover:text-pink-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Total Tamu Card -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500 shimmer-effect group">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-white"><?= number_format($total_tamu) ?></p>
                    <p class="text-purple-200 text-sm font-medium">Total Tamu</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-purple-300 text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Terdaftar
                </span>
                <a href="<?= base_url('tamu') ?>" class="text-white hover:text-purple-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

                 <!-- Reservasi Bulan Ini Card -->
         <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500 shimmer-effect group">
             <div class="flex items-center justify-between mb-4">
                 <div class="bg-gradient-to-br from-pink-400 to-pink-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300" style="background: linear-gradient(135deg, #D81B60, #C2185B);">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                     </svg>
                 </div>
                 <div class="text-right">
                     <p class="text-3xl font-bold text-white"><?= number_format($reservasi_bulan_ini) ?></p>
                     <p class="text-pink-200 text-sm font-medium">Reservasi Bulan Ini</p>
                 </div>
             </div>
             <div class="flex items-center justify-between">
                 <span class="text-pink-300 text-sm flex items-center">
                     <div class="w-2 h-2 bg-pink-400 rounded-full mr-2 animate-bounce"></div>
                     <?= date('F Y') ?>
                 </span>
                 <a href="<?= base_url('reservasi') ?>" class="text-white hover:text-pink-200 transition-colors">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                     </svg>
                 </a>
             </div>
         </div>
    </div>

    <!-- Financial Stats (Admin Only) -->
    <?php if ($user_role === 'admin'): ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pendapatan Card -->
        <div class="glass-effect rounded-3xl p-8 card-hover transition-all duration-500 shimmer-effect group">
            <div class="flex items-center justify-between mb-6">
                <div class="bg-gradient-to-br from-green-400 to-green-600 p-6 rounded-3xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-white mb-2">Rp <?= number_format($pendapatan_bulan_ini, 0, ',', '.') ?></p>
                    <p class="text-green-200 text-lg font-medium">💰 Pendapatan Bulan Ini</p>
                </div>
            </div>
                         <a href="<?= base_url('laporan-wisma/pendapatan') ?>" class="flex items-center justify-center text-white px-6 py-3 rounded-2xl transition-all duration-300 transform hover:scale-105" style="background: linear-gradient(135deg, #D81B60, #C2185B); hover:background: linear-gradient(135deg, #C2185B, #AD1457);">
                <span class="mr-2">📊 Lihat Laporan Detail</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Pengeluaran Card -->
        <div class="glass-effect rounded-3xl p-8 card-hover transition-all duration-500 shimmer-effect group">
            <div class="flex items-center justify-between mb-6">
                <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-6 rounded-3xl group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-4xl font-bold text-white mb-2">Rp <?= number_format($pengeluaran_bulan_ini, 0, ',', '.') ?></p>
                    <p class="text-orange-200 text-lg font-medium">💳 Pengeluaran Bulan Ini</p>
                </div>
            </div>
                         <a href="<?= base_url('laporan-wisma/pengeluaran') ?>" class="flex items-center justify-center text-white px-6 py-3 rounded-2xl transition-all duration-300 transform hover:scale-105" style="background: linear-gradient(135deg, #E91E63, #D81B60); hover:background: linear-gradient(135deg, #D81B60, #C2185B);">
                <span class="mr-2">📈 Lihat Laporan Detail</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 <?= $user_role === 'admin' ? 'lg:grid-cols-2' : '' ?> gap-6 mb-8">
        <!-- Reservasi Chart -->
        <div class="glass-effect rounded-3xl p-8 card-hover transition-all duration-500">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 p-4 rounded-2xl mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">📈 Trend Reservasi</h3>
                    <p class="text-indigo-200">6 Bulan Terakhir</p>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 rounded-2xl p-4">
                <canvas id="reservasiChart" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- Financial Chart (Admin Only) -->
        <?php if ($user_role === 'admin'): ?>
        <div class="glass-effect rounded-3xl p-8 card-hover transition-all duration-500">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 p-4 rounded-2xl mr-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">💹 Analisis Keuangan</h3>
                    <p class="text-emerald-200">Pendapatan vs Pengeluaran</p>
                </div>
            </div>
            <div class="bg-white bg-opacity-10 rounded-2xl p-4">
                <canvas id="keuanganChart" class="w-full h-64"></canvas>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Activity Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Check-in Today -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-cyan-400 to-cyan-600 p-3 rounded-xl mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">🏨 Check-in Hari Ini</h3>
                    <p class="text-cyan-200 text-sm"><?= count($checkin_hari_ini) ?> Tamu</p>
                </div>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                <?php if (!empty($checkin_hari_ini)): ?>
                    <?php foreach ($checkin_hari_ini as $checkin): ?>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 hover:bg-opacity-20 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white font-semibold text-sm"><?= esc($checkin['nama_tamu']) ?></p>
                                <p class="text-cyan-200 text-xs"><?= esc($checkin['nama_kamar']) ?></p>
                            </div>
                            <span class="text-xs bg-cyan-500 text-white px-2 py-1 rounded-full">
                                <?= date('H:i', strtotime($checkin['tglcheckin'])) ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="text-6xl mb-4">🏨</div>
                        <p class="text-white opacity-70">Belum ada check-in hari ini</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                                 <a href="<?= base_url('checkin') ?>" class="w-full flex items-center justify-center text-white px-4 py-2 rounded-xl transition-all duration-300" style="background: linear-gradient(135deg, #D81B60, #C2185B);">
                    Lihat Semua
                </a>
            </div>
        </div>

        <!-- Check-out Today -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-amber-400 to-amber-600 p-3 rounded-xl mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">🎒 Check-out Hari Ini</h3>
                    <p class="text-amber-200 text-sm"><?= count($checkout_hari_ini) ?> Tamu</p>
                </div>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                <?php if (!empty($checkout_hari_ini)): ?>
                    <?php foreach ($checkout_hari_ini as $checkout): ?>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 hover:bg-opacity-20 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white font-semibold text-sm"><?= esc($checkout['nama_tamu']) ?></p>
                                <p class="text-amber-200 text-xs"><?= esc($checkout['nama_kamar']) ?></p>
                            </div>
                            <span class="text-xs bg-amber-500 text-white px-2 py-1 rounded-full">
                                <?= date('H:i', strtotime($checkout['tglcheckout'])) ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="text-6xl mb-4">🎒</div>
                        <p class="text-white opacity-70">Belum ada check-out hari ini</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                                 <a href="<?= base_url('checkout') ?>" class="w-full flex items-center justify-center text-white px-4 py-2 rounded-xl transition-all duration-300" style="background: linear-gradient(135deg, #E91E63, #D81B60);">
                    Lihat Semua
                </a>
            </div>
        </div>

        <!-- Recent Reservations -->
        <div class="glass-effect rounded-3xl p-6 card-hover transition-all duration-500">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-pink-400 to-pink-600 p-3 rounded-xl mr-3">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">📋 Reservasi Terbaru</h3>
                    <p class="text-pink-200 text-sm"><?= count($reservasi_terbaru) ?> Booking</p>
                </div>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                <?php if (!empty($reservasi_terbaru)): ?>
                    <?php foreach ($reservasi_terbaru as $reservasi): ?>
                    <div class="bg-white bg-opacity-10 rounded-xl p-4 hover:bg-opacity-20 transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-white font-semibold text-sm"><?= esc($reservasi['nama_tamu']) ?></p>
                                <p class="text-pink-200 text-xs"><?= esc($reservasi['nama_kamar']) ?></p>
                            </div>
                                                         <span class="text-xs px-2 py-1 rounded-full <?php 
                                 switch($reservasi['status']) {
                                     case 'diproses': echo 'bg-yellow-500'; break;
                                     case 'diterima': echo 'bg-green-500'; break;
                                     case 'ditolak': echo 'bg-red-500'; break;
                                     case 'checkin': echo 'text-white'; break;
                                     case 'selesai': echo 'text-white'; break;
                                     default: echo 'bg-gray-500';
                                 }
                             ?> text-white" style="<?php 
                                 switch($reservasi['status']) {
                                     case 'checkin': echo 'background: #D81B60;'; break;
                                     case 'selesai': echo 'background: #E91E63;'; break;
                                 }
                             ?>">
                                <?= ucfirst($reservasi['status']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8">
                        <div class="text-6xl mb-4">📋</div>
                        <p class="text-white opacity-70">Belum ada reservasi</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                                 <a href="<?= base_url('reservasi') ?>" class="w-full flex items-center justify-center text-white px-4 py-2 rounded-xl transition-all duration-300" style="background: linear-gradient(135deg, #D81B60, #AD1457);">
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Room Status Overview -->
    <div class="glass-effect rounded-3xl p-8 card-hover transition-all duration-500 mb-8">
        <div class="flex items-center mb-8">
            <div class="bg-gradient-to-br from-violet-400 to-violet-600 p-4 rounded-2xl mr-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-white">🏨 Status Kamar Real-time</h3>
                <p class="text-violet-200">Monitoring langsung ketersediaan kamar</p>
            </div>
        </div>

        <!-- Room Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <?php foreach ($status_kamar as $status): ?>
            <div class="<?= $status['status'] === 'Tersedia' ? 'bg-gradient-to-br from-green-400 to-green-600' : 'bg-gradient-to-br from-red-400 to-red-600' ?> rounded-2xl p-6 text-white card-hover transition-all duration-500 shimmer-effect">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-bold opacity-90"><?= $status['status'] ?></span>
                </div>
                <h4 class="text-xl font-bold mb-2"><?= esc($status['kamar']['nama']) ?></h4>
                <?php if ($status['tamu']): ?>
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 mt-3">
                        <p class="text-sm font-semibold opacity-90">👤 <?= esc($status['tamu']) ?></p>
                        <p class="text-xs opacity-75">Checkout: <?= date('d/m/Y', strtotime($status['checkout'])) ?></p>
                    </div>
                <?php else: ?>
                    <div class="bg-white bg-opacity-20 rounded-xl p-3 mt-3">
                        <p class="text-sm opacity-90">✨ Siap dihuni</p>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

                 <!-- Statistics Summary -->
         <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
             <div class="rounded-2xl p-6 text-white text-center" style="background: linear-gradient(135deg, #D81B60, #C2185B);">
                 <div class="text-3xl font-bold"><?= $kamar_tersedia ?></div>
                 <div class="text-sm opacity-90">Tersedia</div>
                 <div class="text-xs opacity-75"><?= round(($kamar_tersedia / $total_kamar) * 100, 1) ?>%</div>
             </div>
             <div class="rounded-2xl p-6 text-white text-center" style="background: linear-gradient(135deg, #E91E63, #D81B60);">
                 <div class="text-3xl font-bold"><?= $kamar_terisi ?></div>
                 <div class="text-sm opacity-90">Terisi</div>
                 <div class="text-xs opacity-75"><?= round(($kamar_terisi / $total_kamar) * 100, 1) ?>%</div>
             </div>
             <div class="rounded-2xl p-6 text-white text-center" style="background: linear-gradient(135deg, #AD1457, #880E4F);">
                 <div class="text-3xl font-bold"><?= $total_checkin ?></div>
                 <div class="text-sm opacity-90">Check-in</div>
                 <div class="text-xs opacity-75"><?= $total_reservasi > 0 ? round((($total_checkin) / $total_reservasi) * 100, 1) : 0 ?>%</div>
             </div>
             <div class="rounded-2xl p-6 text-white text-center" style="background: linear-gradient(135deg, #C2185B, #AD1457);">
                 <div class="text-3xl font-bold"><?= $total_kamar ?></div>
                 <div class="text-sm opacity-90">Total Kamar</div>
                 <div class="text-xs opacity-75">100%</div>
             </div>
         </div>
    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Update current time
function updateTime() {
    const now = new Date();
    document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID');
}
updateTime();
setInterval(updateTime, 1000);

document.addEventListener('DOMContentLoaded', function() {
    // Chart configuration with glassmorphism theme
    Chart.defaults.color = '#ffffff';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
    Chart.defaults.backgroundColor = 'rgba(255, 255, 255, 0.05)';

    // Reservasi Chart
    const reservasiData = <?= json_encode($chart_reservasi) ?>;
    const reservasiLabels = reservasiData.map(item => item.month);
    const reservasiCounts = reservasiData.map(item => item.count);

    const reservasiCtx = document.getElementById('reservasiChart').getContext('2d');
    new Chart(reservasiCtx, {
        type: 'line',
        data: {
            labels: reservasiLabels,
                         datasets: [{
                 label: 'Jumlah Reservasi',
                 data: reservasiCounts,
                 borderColor: '#D81B60',
                 backgroundColor: 'rgba(216, 27, 96, 0.1)',
                 borderWidth: 4,
                 fill: true,
                 tension: 0.5,
                 pointBackgroundColor: '#D81B60',
                 pointBorderColor: '#ffffff',
                 pointBorderWidth: 3,
                 pointRadius: 8,
                 pointHoverRadius: 12
             }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#ffffff',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        stepSize: 1,
                        color: '#ffffff'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                }
            }
        }
    });

    <?php if ($user_role === 'admin' && !empty($chart_keuangan)): ?>
    // Financial Chart
    const keuanganData = <?= json_encode($chart_keuangan) ?>;
    const keuanganLabels = keuanganData.map(item => item.month);
    const pendapatanData = keuanganData.map(item => item.pendapatan);
    const pengeluaranData = keuanganData.map(item => item.pengeluaran);

    const keuanganCtx = document.getElementById('keuanganChart').getContext('2d');
    new Chart(keuanganCtx, {
        type: 'bar',
        data: {
            labels: keuanganLabels,
                         datasets: [{
                 label: 'Pendapatan',
                 data: pendapatanData,
                 backgroundColor: 'rgba(216, 27, 96, 0.8)',
                 borderColor: '#D81B60',
                 borderWidth: 2,
                 borderRadius: 8,
                 borderSkipped: false,
             }, {
                 label: 'Pengeluaran',
                 data: pengeluaranData,
                 backgroundColor: 'rgba(233, 30, 99, 0.8)',
                 borderColor: '#E91E63',
                 borderWidth: 2,
                 borderRadius: 8,
                 borderSkipped: false,
             }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#ffffff',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        },
                        color: '#ffffff'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: '#ffffff'
                    }
                }
            }
        }
    });
    <?php endif; ?>

    // Auto refresh every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
});
</script>

<?= $this->endSection() ?>