<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Pasien - Klinik Gigi Sehat Bersinar</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        .gradient-bg {
            background: linear-gradient(120deg, #0d9488 0%, #2dd4bf 100%);
        }
        .form-input:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
        }
        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md w-full z-50">
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

    <!-- Header -->
    <header class="gradient-bg py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Lengkapi Data Pasien</h1>
            <p class="text-white text-lg max-w-xl mx-auto opacity-90">Sebelum melakukan booking, silakan lengkapi data diri Anda terlebih dahulu</p>
        </div>
    </header>

    <!-- Form Data Pasien -->
    <section class="py-10">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-semibold text-teal-800 mb-6">Data Pribadi</h2>
                    
                    <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('booking/simpan_data_pasien') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" required value="<?= old('nama') ?>">
                            </div>
                            
                            <div>
                                <label for="jenkel" class="block text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenkel" id="jenkel" class="w-full px-4 py-2 border border-gray-300 rounded-lg custom-select" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" <?= old('jenkel') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenkel') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="tgllahir" class="block text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="tgllahir" id="tgllahir" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input date-picker" placeholder="YYYY-MM-DD" required value="<?= old('tgllahir') ?>">
                            </div>
                            
                            <div>
                                <label for="nohp" class="block text-gray-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                                <input type="tel" name="nohp" id="nohp" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" required value="<?= old('nohp') ?>">
                            </div>
                            
                            <div>
                                <label for="alamat" class="block text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                                <textarea name="alamat" id="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" required><?= old('alamat') ?></textarea>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all">
                                    Simpan Data & Lanjutkan Booking
                                </button>
                                <a href="<?= base_url() ?>" class="block text-center w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-all mt-3">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-10">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center items-center mb-4">
                <i class="fas fa-tooth text-teal-400 text-2xl"></i>
                <span class="text-xl font-bold ml-2">KlinikGigi</span>
            </div>
            <p class="text-gray-400">© <?= date('Y') ?> Klinik Gigi Sehat Bersinar. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

        // Untuk menampilkan error validasi dalam bentuk SweetAlert jika ada
        <?php if (session()->getFlashdata('errors')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Error',
                html: '<?= implode("<br>", session()->getFlashdata('errors')) ?>',
            });
        <?php endif; ?>

        // Initialize date pickers
        flatpickr(".date-picker", {
            dateFormat: "Y-m-d",
            maxDate: "today" // Tanggal lahir tidak boleh masa depan
        });
        
        // Form submission dengan konfirmasi SweetAlert
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi form sebelum submit
            const requiredFields = document.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap',
                    text: 'Mohon lengkapi semua field yang wajib diisi!'
                });
                return;
            }
            
            // Konfirmasi sebelum menyimpan
            Swal.fire({
                title: 'Simpan Data Pasien?',
                text: "Pastikan data yang Anda masukkan sudah benar",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
</body>
</html> 