<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Edit Profil' ?> - Klinik Gigi</title>
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
                    <a href="<?= base_url('pasien/histori') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-history text-teal-600"></i>
                        <span>Histori Booking</span>
                    </a>
                    <a href="<?= base_url('pasien/edit-profil') ?>" class="flex items-center space-x-3 px-6 py-3 text-gray-700 hover:bg-teal-50 active-nav-link">
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
                    <a href="<?= base_url('pasien/histori') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 hover:bg-teal-50">
                        <i class="fas fa-history text-teal-600"></i>
                        <span>Histori Booking</span>
                    </a>
                    <a href="<?= base_url('pasien/edit-profil') ?>" class="flex items-center space-x-3 px-4 py-2 rounded-md text-gray-700 bg-teal-50 border-l-4 border-teal-500">
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
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil</h1>

                <?php if(session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="font-medium">Terjadi kesalahan:</div>
                        <ul class="list-disc list-inside">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <form action="<?= base_url('pasien/update-profil') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-8 text-center">
                                <div class="mb-4 flex justify-center">
                                    <?php if (!empty($pasien['foto']) && file_exists('assets/img/pasien/' . $pasien['foto'])): ?>
                                        <img id="preview-foto" src="<?= base_url('assets/img/pasien/' . $pasien['foto']) ?>" alt="<?= $pasien['nama'] ?>" class="w-32 h-32 rounded-full object-cover border-4 border-teal-100">
                                    <?php else: ?>
                                        <div id="default-avatar" class="w-32 h-32 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                                            <i class="fas fa-user text-6xl"></i>
                                        </div>
                                        <img id="preview-foto" src="" alt="" class="w-32 h-32 rounded-full object-cover border-4 border-teal-100 hidden">
                                    <?php endif; ?>
                                </div>
                                <label for="foto" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md cursor-pointer inline-flex items-center transition-colors">
                                    <i class="fas fa-camera mr-2"></i> Ubah Foto
                                </label>
                                <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                                <p class="text-xs text-gray-500 mt-2">Upload foto dengan ukuran maksimal 2MB</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama" id="nama" value="<?= $pasien['nama'] ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="jenkel" value="L" <?= $pasien['jenkel'] == 'L' ? 'checked' : '' ?> class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2">Laki-laki</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="jenkel" value="P" <?= $pasien['jenkel'] == 'P' ? 'checked' : '' ?> class="text-teal-600 focus:ring-teal-500">
                                            <span class="ml-2">Perempuan</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="tgllahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                    <input type="date" name="tgllahir" id="tgllahir" value="<?= $pasien['tgllahir'] ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                
                                <div>
                                    <label for="nohp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                                    <input type="tel" name="nohp" id="nohp" value="<?= $pasien['nohp'] ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                                    <textarea name="alamat" id="alamat" rows="3" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"><?= $pasien['alamat'] ?></textarea>
                                </div>
                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <a href="<?= base_url('pasien/dashboard') ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md mr-2">Batal</a>
                                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                            </div>
                        </form>
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
        
        // Preview foto yang diupload
        const inputFoto = document.getElementById('foto');
        const previewFoto = document.getElementById('preview-foto');
        const defaultAvatar = document.getElementById('default-avatar');
        
        inputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                    previewFoto.classList.remove('hidden');
                    if (defaultAvatar) {
                        defaultAvatar.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html> 