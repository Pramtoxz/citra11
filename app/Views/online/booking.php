<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Online - Klinik Gigi Sehat Bersinar</title>
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
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Booking Kunjungan Online</h1>
            <p class="text-white text-lg max-w-xl mx-auto opacity-90">Isi form di bawah ini untuk menjadwalkan perawatan gigi Anda dengan dokter pilihan</p>
        </div>
    </header>

    <!-- Booking Form -->
    <section class="py-10">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="md:flex">
                    <div class="p-8 md:p-12 md:w-2/5 gradient-bg text-white">
                        <h2 class="text-2xl font-semibold mb-6">Informasi Booking</h2>
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Jadwal Fleksibel</h3>
                                    <p class="text-sm opacity-80">Pilih jadwal yang sesuai dengan kebutuhan Anda</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                    <i class="fas fa-user-md text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Dokter Profesional</h3>
                                    <p class="text-sm opacity-80">Pilih dokter gigi sesuai dengan preferensi Anda</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Pilihan Perawatan</h3>
                                    <p class="text-sm opacity-80">Berbagai layanan perawatan gigi tersedia</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-4">
                                    <i class="fas fa-credit-card text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">Pembayaran Mudah</h3>
                                    <p class="text-sm opacity-80">Bayar setelah konsultasi atau perawatan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-10 pt-8 border-t border-white/20">
                            <h4 class="font-medium mb-2">Butuh bantuan?</h4>
                            <p class="text-sm opacity-80 mb-4">Hubungi kami untuk informasi lebih lanjut</p>
                            <div class="flex items-center">
                                <i class="fas fa-phone-alt mr-2"></i>
                                <span>+62 812-3456-7890</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 md:p-12 md:w-3/5 bg-white">
                        <h2 class="text-2xl font-semibold text-teal-800 mb-6">Data Booking</h2>
                        <form action="<?= base_url('online/simpanbooking') ?>" method="post" id="booking-form">
                            <?= csrf_field() ?>
                            
                            <!-- Step 1: Data Pasien -->
                            <div class="step" id="step-1">
                                <h3 class="text-lg font-medium text-teal-700 mb-4">Data Pribadi</h3>
                                
                                <div class="space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-gray-600">Nama Lengkap</p>
                                                <p class="font-medium"><?= $pasien['nama'] ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600">Jenis Kelamin</p>
                                                <p class="font-medium"><?= $pasien['jenkel'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600">Tanggal Lahir</p>
                                                <p class="font-medium"><?= date('d F Y', strtotime($pasien['tgllahir'])) ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-600">Nomor HP</p>
                                                <p class="font-medium"><?= $pasien['nohp'] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-600">Alamat</p>
                                            <p class="font-medium"><?= $pasien['alamat'] ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <button type="button" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all" onclick="nextStep(1, 2)">Lanjutkan</button>
                                </div>
                            </div>
                            
                            <!-- Step 2: Jadwal dan Dokter -->
                            <div class="step hidden" id="step-2">
                                <h3 class="text-lg font-medium text-teal-700 mb-4">Jadwal & Dokter</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="jadwal" class="block text-gray-700 mb-1">Pilih Jadwal Praktik <span class="text-red-500">*</span></label>
                                        <select name="idjadwal" id="jadwal" class="w-full px-4 py-2 border border-gray-300 rounded-lg custom-select" required>
                                            <option value="">-- Pilih Jadwal Praktik --</option>
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
                                                <option value="<?= $jdwl['idjadwal'] ?>" data-dokter="<?= $jdwl['iddokter'] ?>" data-hari="<?= $jdwl['hari'] ?>" data-waktu-mulai="<?= $jdwl['waktu_mulai'] ?>" data-waktu-selesai="<?= $jdwl['waktu_selesai'] ?>">
                                                    <?= $dokterData ? $dokterData['nama'] : 'Dokter tidak ditemukan' ?> - 
                                                    <?= $jdwl['hari'] ?>, 
                                                    <?= substr($jdwl['waktu_mulai'], 0, 5) ?> - <?= substr($jdwl['waktu_selesai'], 0, 5) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="text-sm text-teal-600 mt-1">Pilih jadwal praktik dokter terlebih dahulu</div>
                                    </div>
                                    
                                    <div>
                                        <label for="tanggal_booking" class="block text-gray-700 mb-1">Tanggal Booking <span class="text-red-500">*</span></label>
                                        <input type="text" name="tanggal_booking" id="tanggal_booking" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input date-picker" placeholder="YYYY-MM-DD" required readonly>
                                        <input type="hidden" id="hari_jadwal" name="hari_jadwal">
                                        <p id="info-hari" class="text-sm text-teal-600 mt-1">Pilih jadwal dokter terlebih dahulu</p>
                                    </div>
                                    
                                    <div>
                                        <label for="id_jenis" class="block text-gray-700 mb-1">Jenis Perawatan <span class="text-red-500">*</span></label>
                                        <select name="idjenis" id="id_jenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg custom-select" required>
                                            <option value="">-- Pilih Jenis Perawatan --</option>
                                            <?php foreach ($jenis as $item): ?>
                                            <option value="<?= $item['idjenis'] ?>" data-durasi="<?= $item['estimasi'] ?>"><?= $item['namajenis'] ?> (Est. <?= $item['estimasi'] ?> menit)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 mb-1">Cek Ketersediaan <span class="text-red-500">*</span></label>
                                        <button type="button" id="cekSlotButton" class="w-full px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all">
                                            <i class="fas fa-search mr-2"></i>Cek Ketersediaan
                                        </button>
                                        <div id="slotInfo" class="mt-2 p-3 rounded-lg hidden"></div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="waktu_mulai" class="block text-gray-700 mb-1">Waktu Mulai <span class="text-red-500">*</span></label>
                                            <input type="text" name="waktu_mulai" id="waktu_mulai" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" readonly required>
                                        </div>
                                        <div>
                                            <label for="waktu_selesai" class="block text-gray-700 mb-1">Waktu Selesai <span class="text-red-500">*</span></label>
                                            <input type="text" name="waktu_selesai" id="waktu_selesai" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" readonly required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex space-x-4">
                                    <button type="button" class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-all" onclick="prevStep(2, 1)">Kembali</button>
                                    <button type="button" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all" onclick="nextStep(2, 3)">Lanjutkan</button>
                                </div>
                            </div>
                            
                            <!-- Step 3: Keluhan -->
                            <div class="step hidden" id="step-3">
                                <h3 class="text-lg font-medium text-teal-700 mb-4">Keluhan & Konfirmasi</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="keluhan" class="block text-gray-700 mb-1">Keluhan <span class="text-red-500">*</span></label>
                                        <textarea name="keluhan" id="keluhan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg form-input" required placeholder="Jelaskan keluhan yang Anda alami"></textarea>
                                    </div>
                                    
                                    <div class="bg-teal-50 p-4 rounded-lg border border-teal-200">
                                        <h4 class="font-medium text-teal-800 mb-2">Catatan Penting:</h4>
                                        <ul class="text-sm text-teal-700 space-y-1 list-disc list-inside">
                                            <li>Datang 15 menit sebelum jadwal yang ditentukan</li>
                                            <li>Booking berlaku untuk 1 orang pasien</li>
                                            <li>Mohon membawa kartu identitas (KTP/SIM)</li>
                                            <li>Hubungi kami jika ada perubahan jadwal</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="flex items-start">
                                        <input type="checkbox" name="agree" id="agree" class="mt-1" required>
                                        <label for="agree" class="ml-2 text-sm text-gray-700">Saya menyetujui syarat dan ketentuan yang berlaku di Klinik Gigi</label>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex space-x-4">
                                    <button type="button" class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition-all" onclick="prevStep(3, 2)">Kembali</button>
                                    <button type="submit" class="w-full gradient-bg text-white py-3 rounded-lg font-medium hover:opacity-90 transition-all">Kirim Booking</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
            <p class="text-gray-400">© <?= date('Y') ?> Klinik Gigi. Hak Cipta Dilindungi.</p>
            <div class="mt-4">
                <a href="<?= base_url() ?>" class="text-gray-400 hover:text-teal-400">Kembali ke Beranda</a>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
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
    
        // Variables untuk menyimpan data aplikasi
        let datePicker = null;
        let selectedDay = null;
        
        // Mapping hari ke angka untuk filter tanggal
        const dayMap = {
            'Minggu': 0,
            'Senin': 1, 
            'Selasa': 2,
            'Rabu': 3,
            'Kamis': 4,
            'Jumat': 5,
            'Sabtu': 6
        };
        
        // Multi-step form navigation
        function nextStep(currentStep, nextStep) {
            // Validate current step
            let isValid = validateStep(currentStep);
            
            if (isValid) {
                document.getElementById('step-' + currentStep).classList.add('hidden');
                document.getElementById('step-' + nextStep).classList.remove('hidden');
            }
        }
        
        function prevStep(currentStep, prevStep) {
            document.getElementById('step-' + currentStep).classList.add('hidden');
            document.getElementById('step-' + prevStep).classList.remove('hidden');
        }
        
        function validateStep(step) {
            let isValid = true;
            const currentStep = document.getElementById('step-' + step);
            
            // Get all required fields in current step
            const requiredFields = currentStep.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                // Ganti alert standar dengan SweetAlert
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                });
            }
            
            return isValid;
        }
        
        // Inisialisasi form dan event listeners setelah dokumen dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const jadwalSelect = document.getElementById('jadwal');
            const tanggalInput = document.getElementById('tanggal_booking');
            const hariJadwalInput = document.getElementById('hari_jadwal');
            const infoHariText = document.getElementById('info-hari');
            
            // Inisialisasi tahap awal - tanggal tidak bisa dipilih
            tanggalInput.disabled = true;
            
            // Event listener untuk perubahan jadwal
            jadwalSelect.addEventListener('change', function() {
                const jadwalId = this.value;
                
                // Reset waktu dan info slot
                document.getElementById('waktu_mulai').value = '';
                document.getElementById('waktu_selesai').value = '';
                document.getElementById('slotInfo').classList.add('hidden');
                
                if (!jadwalId) {
                    // Jadwal belum dipilih
                    tanggalInput.disabled = true;
                    tanggalInput.value = '';
                    infoHariText.textContent = 'Pilih jadwal dokter terlebih dahulu';
                    return;
                }
                
                // Ambil data dari opsi jadwal terpilih
                const selectedOption = this.options[this.selectedIndex];
                const hariJadwal = selectedOption.getAttribute('data-hari');
                selectedDay = hariJadwal;
                hariJadwalInput.value = hariJadwal;
                
                // Update info hari untuk user
                infoHariText.textContent = `Pilih tanggal yang jatuh pada hari ${hariJadwal}`;
                
                // Aktifkan input tanggal
                tanggalInput.disabled = false;
                tanggalInput.value = '';
                
                // Inisialisasi date picker dengan filter hari
                setupDatePicker(hariJadwal);
            });
            
            // Form submission validation
            document.getElementById('booking-form').addEventListener('submit', function(e) {
                const agreeCheckbox = document.getElementById('agree');
                if (!agreeCheckbox.checked) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Persetujuan Diperlukan',
                        text: 'Anda harus menyetujui syarat dan ketentuan untuk melanjutkan!',
                    });
                    return;
                }
                
                // Cek apakah slot waktu sudah dipilih
                const waktuMulai = document.getElementById('waktu_mulai');
                const waktuSelesai = document.getElementById('waktu_selesai');
                
                if (!waktuMulai.value || !waktuSelesai.value) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Belum Dipilih',
                        text: 'Mohon periksa ketersediaan slot waktu terlebih dahulu!',
                    });
                }
            });
            
            // Cek ketersediaan slot waktu
            document.getElementById('cekSlotButton').addEventListener('click', checkSlotAvailability);
        });
        
        // Fungsi untuk setup date picker dengan filter hari
        function setupDatePicker(hari) {
            console.log('Setting up date picker for:', hari);
            
            const tanggalInput = document.getElementById('tanggal_booking');
            const dayNum = dayMap[hari];
            
            if (typeof dayNum === 'undefined') {
                console.error('Hari tidak valid:', hari);
                return;
            }
            
            // Hapus instance sebelumnya jika ada
            if (datePicker) {
                datePicker.destroy();
            }
            
            // Fungsi untuk menghitung tanggal valid berikutnya
            function getNextValidDate() {
                let nextDate = new Date();
                const currentDay = nextDate.getDay();
                
                // Hitung berapa hari lagi untuk mencapai hari yang diinginkan
                let daysToAdd = (dayNum - currentDay + 7) % 7;
                
                // Jika hari ini adalah hari yang diinginkan, verifikasi waktunya
                if (daysToAdd === 0) {
                    const now = new Date();
                    const hours = now.getHours();
                    const minutes = now.getMinutes();
                    
                    // Ambil jadwal terpilih
                    const jadwalSelect = document.getElementById('jadwal');
                    const selectedOption = jadwalSelect.options[jadwalSelect.selectedIndex];
                    const waktuMulai = selectedOption.getAttribute('data-waktu-mulai');
                    
                    if (waktuMulai) {
                        const [waktuJam, waktuMenit] = waktuMulai.split(':').map(Number);
                        
                        // Jika waktu sekarang sudah melewati waktu mulai jadwal, pilih minggu depan
                        if (hours > waktuJam || (hours === waktuJam && minutes > waktuMenit)) {
                            daysToAdd = 7;
                        }
                    }
                }
                
                // Tambahkan hari yang diperlukan
                nextDate.setDate(nextDate.getDate() + daysToAdd);
                return nextDate;
            }
            
            // Buat instance date picker baru
            datePicker = flatpickr(tanggalInput, {
                dateFormat: "Y-m-d",
                minDate: "today",
                inline: false,
                disable: [
                    function(date) {
                        // Nonaktifkan tanggal yang bukan hari yang dipilih
                        return date.getDay() !== dayNum;
                    }
                ],
                onChange: function(selectedDates, dateStr) {
                    // Reset waktu ketika tanggal berubah
                    document.getElementById('waktu_mulai').value = '';
                    document.getElementById('waktu_selesai').value = '';
                    document.getElementById('slotInfo').classList.add('hidden');
                }
            });
            
            // Set tanggal default ke hari yang sesuai berikutnya
            const nextValidDate = getNextValidDate();
            datePicker.setDate(nextValidDate);
            
            // Fokus ke input setelah picker disetup
            setTimeout(() => {
                tanggalInput.focus();
                tanggalInput.click();
            }, 200);
        }
        
        // Fungsi untuk memeriksa ketersediaan slot
        function checkSlotAvailability() {
            const jadwalId = document.getElementById('jadwal').value;
            const tanggal = document.getElementById('tanggal_booking').value;
            const jenisId = document.getElementById('id_jenis').value;
            const button = document.getElementById('cekSlotButton');
            const slotInfo = document.getElementById('slotInfo');
            
            if (!jadwalId || !tanggal || !jenisId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Silakan pilih jadwal, tanggal, dan jenis perawatan terlebih dahulu',
                });
                return;
            }
            
            // Tampilkan logging untuk debugging
            console.log('Mengirim request dengan data:', {
                idjadwal: jadwalId,
                tanggal: tanggal,
                idjenis: jenisId,
                is_walk_in: false
            });
            
            // Tampilkan loading
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...';
            
            // Cari slot tersedia
            fetch('<?= base_url('booking/findAvailableSlot') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `idjadwal=${jadwalId}&tanggal=${tanggal}&idjenis=${jenisId}&is_walk_in=false`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response error: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Respons dari server:', data);
                
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-search mr-2"></i>Cek Ketersediaan';
                
                slotInfo.classList.remove('hidden', 'bg-green-100', 'bg-red-100');
                
                if (data.success) {
                    // Slot tersedia
                    slotInfo.classList.add('bg-green-100');
                    slotInfo.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            <span>Slot tersedia! Waktu: ${data.slot.waktu_mulai.substr(0, 5)} - ${data.slot.waktu_selesai.substr(0, 5)}</span>
                        </div>
                    `;
                    
                    // Tambahkan peringatan jika ada
                    if (data.warning) {
                        slotInfo.innerHTML += `
                            <div class="mt-2 text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                ${data.warning}
                            </div>
                        `;
                    }
                    
                    // Set nilai waktu
                    document.getElementById('waktu_mulai').value = data.slot.waktu_mulai.substr(0, 5);
                    document.getElementById('waktu_selesai').value = data.slot.waktu_selesai.substr(0, 5);
                } else {
                    // Slot tidak tersedia
                    slotInfo.classList.add('bg-red-100');
                    slotInfo.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            <span>${data.message || 'Slot tidak tersedia'}</span>
                        </div>
                    `;
                    
                    // Reset nilai waktu
                    document.getElementById('waktu_mulai').value = '';
                    document.getElementById('waktu_selesai').value = '';
                }
            })
            .catch(error => {
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-search mr-2"></i>Cek Ketersediaan';
                console.error('Error:', error);
                
                // Tampilkan pesan error
                slotInfo.classList.remove('hidden', 'bg-green-100');
                slotInfo.classList.add('bg-red-100');
                slotInfo.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span>Terjadi kesalahan saat mencari slot waktu tersedia.</span>
                    </div>
                    <div class="mt-2 text-sm text-red-800">
                        <pre>${error.toString()}</pre>
                    </div>
                `;
                
                // Tampilkan detail error di console
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memeriksa ketersediaan slot',
                    footer: 'Silakan buka console browser (F12) untuk detail error'
                });
            });
        }
    </script>
</body>
</html>
