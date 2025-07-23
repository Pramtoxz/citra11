<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Histori Booking' ?> - Klinik Gigi</title>
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
        }
        .gradient-bg {
            background: linear-gradient(120deg, #0d9488 0%, #2dd4bf 100%);
        }
        .active-nav-link {
            background-color: rgba(45, 212, 191, 0.1);
            border-left: 4px solid #0d9488;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <div class="p-6 gradient-bg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-tooth text-white text-2xl"></i>
                    <span class="text-xl font-bold text-white">KlinikGigi</span>
                </div>
            </div>
            <div class="py-4">
                <div class="px-6 mb-6">
                    <div class="flex items-center space-x-3">
                        <?php if (!empty($pasien['foto']) && file_exists('assets/img/pasien/' . $pasien['foto'])): ?>
                            <img src="<?= base_url('assets/img/pasien/' . $pasien['foto']) ?>" alt="<?= $pasien['nama'] ?>" class="w-12 h-12 rounded-full object-cover border-2 border-teal-500">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="font-medium text-gray-800"><?= $pasien['nama'] ?></p>
                            <p class="text-sm text-gray-500">Pasien</p>
                        </div>
                    </div>
                </div>
                <nav>
                    <a href="<?= base_url('pasien/dashboard') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-tachometer-alt text-teal-600"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('pasien/histori') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50 active-nav-link">
                        <i class="fas fa-history text-teal-600"></i>
                        <span>Histori Booking</span>
                    </a>
                    <a href="<?= base_url('pasien/edit-profil') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-user-edit text-teal-600"></i>
                        <span>Edit Profil</span>
                    </a>
                    <a href="<?= base_url('online/booking') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-calendar-plus text-teal-600"></i>
                        <span>Booking Baru</span>
                    </a>
                    <hr class="my-3">
                    <a href="<?= base_url('auth/logout') ?>" class="flex items-center space-x-3 px-6 py-3 text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden">
            <!-- Mobile Header -->
            <header class="md:hidden bg-white p-4 shadow-md flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-tooth text-teal-600 text-2xl"></i>
                    <span class="text-xl font-bold text-teal-800">KlinikGigi</span>
                </div>
                <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </header>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden bg-white shadow-md p-4 hidden">
                <div class="flex items-center space-x-3 mb-4">
                    <?php if (!empty($pasien['foto']) && file_exists('assets/img/pasien/' . $pasien['foto'])): ?>
                        <img src="<?= base_url('assets/img/pasien/' . $pasien['foto']) ?>" alt="<?= $pasien['nama'] ?>" class="w-12 h-12 rounded-full object-cover border-2 border-teal-500">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="font-medium text-gray-800"><?= $pasien['nama'] ?></p>
                        <p class="text-sm text-gray-500">Pasien</p>
                    </div>
                </div>
                <nav class="flex flex-col space-y-2">
                    <a href="<?= base_url('pasien/dashboard') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-tachometer-alt text-teal-600"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?= base_url('pasien/histori') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 bg-teal-50 border-l-4 border-teal-500">
                        <i class="fas fa-history text-teal-600"></i>
                        <span>Histori Booking</span>
                    </a>
                    <a href="<?= base_url('pasien/edit-profil') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-user-edit text-teal-600"></i>
                        <span>Edit Profil</span>
                    </a>
                    <a href="<?= base_url('online/booking') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-calendar-plus text-teal-600"></i>
                        <span>Booking Baru</span>
                    </a>
                    <hr class="my-2">
                    <a href="<?= base_url('auth/logout') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>

            <!-- Content -->
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Histori Booking</h1>
                
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <!-- Filter dan Pencarian -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                    <form class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="diproses">Diproses</option>
                                <option value="diterima">Diterima</option>
                                <option value="ditolak">Ditolak</option>
                                <option value="diperiksa">Diperiksa</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <div class="relative">
                                <input type="text" id="search" placeholder="Cari berdasarkan ID booking..." class="w-full border border-gray-300 rounded-md px-3 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="self-end">
                            <button type="button" id="filter-button" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition-colors">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Tabel Histori -->
                <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Booking</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perawatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="booking-list">
                                <?php if(empty($bookings)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data booking</td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach($bookings as $booking): ?>
                                    <tr class="hover:bg-gray-50 booking-item" data-status="<?= $booking['status'] ?>" data-id="<?= $booking['idbooking'] ?>">
                                        <td class="px-6 py-4"><?= $booking['idbooking'] ?></td>
                                        <td class="px-6 py-4"><?= date('d-m-Y', strtotime($booking['tanggal'])) ?></td>
                                        <td class="px-6 py-4"><?= $booking['nama_dokter'] ?></td>
                                        <td class="px-6 py-4"><?= $booking['namajenis'] ?></td>
                                        <td class="px-6 py-4">
                                            <?php
                                                $statusClass = '';
                                                $statusText = ucfirst($booking['status']);
                                                
                                                switch($booking['status']) {
                                                    case 'pending':
                                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'diproses':
                                                        $statusClass = 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'diterima':
                                                        $statusClass = 'bg-green-100 text-green-800';
                                                        break;
                                                    case 'diperiksa':
                                                        $statusClass = 'bg-indigo-100 text-indigo-800';
                                                        break;
                                                    case 'ditolak':
                                                        $statusClass = 'bg-red-100 text-red-800';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-gray-100 text-gray-800';
                                                        break;
                                                }
                                            ?>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusClass ?>"><?= $statusText ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            Rp <?= number_format($booking['harga'], 0, ',', '.') ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="<?= base_url('pasien/booking/' . $booking['idbooking']) ?>" class="text-teal-600 hover:text-teal-800 mr-3">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <?php if($booking['status'] == 'diterima'): ?>
                                            <a href="<?= base_url('pasien/faktur/' . $booking['idbooking']) ?>" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-file-invoice"></i> Faktur
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                        <div>
                            <p class="text-sm text-gray-700">
                                <span id="total-items">Total <?= count($bookings) ?> booking</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        
        // Filter functionality
        document.getElementById('filter-button').addEventListener('click', function() {
            const statusFilter = document.getElementById('status').value;
            const searchText = document.getElementById('search').value.toLowerCase();
            const bookingItems = document.querySelectorAll('.booking-item');
            let visibleCount = 0;
            
            bookingItems.forEach(function(item) {
                const itemStatus = item.dataset.status;
                const itemId = item.dataset.id.toLowerCase();
                
                // Check if matches status filter and search text
                const matchesStatus = statusFilter === '' || itemStatus === statusFilter;
                const matchesSearch = searchText === '' || itemId.includes(searchText);
                
                if (matchesStatus && matchesSearch) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update total count
            document.getElementById('total-items').textContent = `Total ${visibleCount} booking`;
            
            // Show message if no results
            const noResultsRow = document.getElementById('no-results-row');
            if (visibleCount === 0 && !noResultsRow) {
                const tbody = document.getElementById('booking-list');
                const tr = document.createElement('tr');
                tr.id = 'no-results-row';
                tr.innerHTML = '<td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada booking yang sesuai dengan filter</td>';
                tbody.appendChild(tr);
            } else if (visibleCount > 0 && noResultsRow) {
                noResultsRow.remove();
            }
        });
        
        // Reset filter when status or search changes
        document.getElementById('status').addEventListener('change', function() {
            document.getElementById('filter-button').click();
        });
        
        document.getElementById('search').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filter-button').click();
            }
        });
    </script>
</body>
</html> 