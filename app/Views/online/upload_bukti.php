 
 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran - Klinik Gigi</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(120deg, #0d9488 0%, #2dd4bf 100%);
        }
        .preview-image {
            max-height: 300px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .preview-image:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }
        
        #upload-area {
            transition: all 0.3s ease;
        }
        
        #upload-area:hover {
            border-color: #0d9488;
            background-color: #f0fdfa;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        
        #submit-button {
            transition: all 0.3s ease;
        }
        
        #submit-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        }
        
        #submit-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .preview-image {
                max-height: 250px;
            }
            
            #upload-area {
                padding: 1rem !important;
            }
            
            header {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
            
            header h1 {
                font-size: 1.75rem;
            }
            
            .text-3xl {
                font-size: 1.5rem;
            }
            
            .text-2xl {
                font-size: 1.25rem;
            }
            
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Untuk highlight elemen yang wajib diisi */
        .required-field {
            position: relative;
        }
        
        .required-field::after {
            content: '*';
            color: #ef4444;
            position: absolute;
            right: -10px;
            top: 0;
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
    <header class="gradient-bg py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Upload Bukti Pembayaran</h1>
            <p class="text-white text-lg max-w-xl mx-auto opacity-90">Silakan unggah bukti pembayaran Anda untuk melanjutkan proses booking</p>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-10">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <!-- Booking Info -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-teal-800 mb-4">Detail Booking</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">ID Booking</p>
                                <p class="font-medium text-lg"><?= $booking['idbooking'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status</p>
                                <span class="inline-block bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full uppercase"><?= $booking['status'] ?></span>
                            </div>
                            <div>
                                <p class="text-gray-600">Pasien</p>
                                <p class="font-medium"><?= $booking['pasien_nama'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal</p>
                                <p class="font-medium"><?= date('d F Y', strtotime($booking['tanggal'])) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Dokter</p>
                                <p class="font-medium"><?= $booking['nama_dokter'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Waktu</p>
                                <p class="font-medium"><?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Information -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-teal-800 mb-4">Informasi Pembayaran</h3>
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700">Jenis Perawatan</p>
                                    <p class="font-medium"><?= $booking['namajenis'] ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-700">Biaya</p>
                                    <p class="font-bold text-xl text-teal-800">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-teal-200">
                                <div class="flex justify-between items-center">
                                    <p class="font-semibold">Total Pembayaran</p>
                                    <p class="font-bold text-xl text-teal-800">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upload Section -->
                    <div>
                        <h3 class="text-xl font-semibold text-teal-800 mb-4">Upload Bukti Pembayaran</h3>
                        
                        <?php if ($booking['status'] == 'ditolak' && !empty($booking['bukti_bayar'])): ?>
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start">
                                <div class="mr-3 text-red-500">
                                    <i class="fas fa-exclamation-circle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-red-700">Bukti Pembayaran Ditolak</h4>
                                    <p class="text-red-600 text-sm">Mohon upload ulang bukti pembayaran yang valid.</p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($booking['status'] == 'ditolak' || empty($booking['bukti_bayar'])): ?>
                        <form id="upload-form" enctype="multipart/form-data">
                            <input type="hidden" name="idbooking" value="<?= $booking['idbooking'] ?>">
                            
                            <div class="mb-6">
                                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center" id="upload-area">
                                    <div id="upload-prompt">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <h4 class="font-medium text-gray-700 mb-2 required-field">Unggah Bukti Pembayaran</h4>
                                        <p class="text-sm text-gray-500 mb-4">File gambar (JPG, PNG) atau PDF. Maks 2MB</p>
                                        <label for="bukti_bayar" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-md cursor-pointer transition-all hover:shadow-lg hover:shadow-teal-500/30 inline-block">
                                            <i class="fas fa-file-upload mr-2"></i>Pilih File
                                        </label>
                                        <input type="file" name="bukti_bayar" id="bukti_bayar" class="hidden" accept="image/jpeg,image/jpg,image/png,application/pdf" required>
                                        <p class="text-red-500 text-sm mt-2">* Bukti pembayaran wajib diupload</p>
                                    </div>
                                    
                                    <div id="preview-container" class="hidden">
                                        <div class="mb-4">
                                            <img id="image-preview" class="mx-auto preview-image hidden border border-gray-200 rounded-lg shadow-sm">
                                            <div id="pdf-preview" class="hidden">
                                                <i class="far fa-file-pdf text-red-500 text-5xl"></i>
                                                <p class="mt-2 font-medium" id="pdf-filename">filename.pdf</p>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" id="change-file" class="text-teal-600 hover:text-teal-800 underline text-sm">
                                                Ganti File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="error_bukti_bayar" class="text-red-500 text-sm mt-2 bg-red-50 p-2 rounded-md hidden"></div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" id="submit-button" class="gradient-bg text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition-all">
                                    <i class="fas fa-paper-plane mr-2"></i> Kirim Bukti Pembayaran
                                </button>
                            </div>
                        </form>
                        <?php elseif ($booking['status'] == 'diproses'): ?>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-start">
                                <div class="text-blue-500 mr-3">
                                    <i class="fas fa-info-circle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-blue-800">Bukti Pembayaran Sedang Diproses</h4>
                                    <p class="text-blue-700">Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin. Silakan periksa status secara berkala.</p>
                                </div>
                            </div>
                            
                            <?php if (!empty($booking['bukti_bayar'])): ?>
                            <div class="mt-4 pt-4 border-t border-blue-200">
                                <p class="font-medium text-blue-800 mb-2">Bukti yang telah diunggah:</p>
                                <?php 
                                    $ext = pathinfo($booking['bukti_bayar'], PATHINFO_EXTENSION);
                                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])):
                                ?>
                                <img src="<?= base_url('uploads/bukti_bayar/'.$booking['bukti_bayar']) ?>" alt="Bukti Pembayaran" class="max-w-xs mx-auto my-2 preview-image">
                                <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="far fa-file-pdf text-red-500 text-5xl"></i>
                                    <p class="mt-2">File PDF</p>
                                    <a href="<?= base_url('uploads/bukti_bayar/'.$booking['bukti_bayar']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                        Lihat File
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php elseif ($booking['status'] == 'diterima'): ?>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="flex items-start">
                                <div class="text-green-500 mr-3">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-green-800">Pembayaran Telah Diterima</h4>
                                    <p class="text-green-700">Pembayaran Anda telah dikonfirmasi. Silakan lihat faktur untuk detail lebih lanjut.</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="<?= base_url('booking/faktur/'.$booking['idbooking']) ?>" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    <i class="fas fa-file-invoice mr-2"></i> Lihat Faktur
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
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
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadForm = document.getElementById('upload-form');
            if (!uploadForm) return;
            
            const fileInput = document.getElementById('bukti_bayar');
            const uploadPrompt = document.getElementById('upload-prompt');
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            const pdfPreview = document.getElementById('pdf-preview');
            const pdfFilename = document.getElementById('pdf-filename');
            const changeFileBtn = document.getElementById('change-file');
            const submitButton = document.getElementById('submit-button');
            
            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                
                if (!file) {
                    return;
                }
                
                // Validate file type and size
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    const errorElement = document.getElementById('error_bukti_bayar');
                    errorElement.textContent = 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF';
                    errorElement.classList.remove('hidden');
                    fileInput.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    const errorElement = document.getElementById('error_bukti_bayar');
                    errorElement.textContent = 'Ukuran file maksimal 2MB';
                    errorElement.classList.remove('hidden');
                    fileInput.value = '';
                    return;
                }
                
                // Clear error message
                document.getElementById('error_bukti_bayar').textContent = '';
                document.getElementById('error_bukti_bayar').classList.add('hidden');
                
                // Preview the file
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        pdfPreview.classList.add('hidden');
                       
                        // Tambahkan animasi sederhana untuk preview
                        imagePreview.style.opacity = '0';
                        setTimeout(() => {
                            imagePreview.style.transition = 'opacity 0.5s ease';
                            imagePreview.style.opacity = '1';
                        }, 100);
                    }
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    imagePreview.classList.add('hidden');
                    pdfPreview.classList.remove('hidden');
                    pdfFilename.textContent = file.name;

                    // Tambahkan animasi sederhana untuk preview PDF
                    pdfPreview.style.opacity = '0';
                    setTimeout(() => {
                        pdfPreview.style.transition = 'opacity 0.5s ease';
                        pdfPreview.style.opacity = '1';
                    }, 100);
                }
                
                // Show preview container, hide upload prompt
                uploadPrompt.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            });
            
            // Change file button
            changeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                uploadPrompt.classList.remove('hidden');
                previewContainer.classList.add('hidden');
                document.getElementById('error_bukti_bayar').textContent = '';
                document.getElementById('error_bukti_bayar').classList.add('hidden');
            });
            
            // Handle form submission
            uploadForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Check if file is selected
                if (!fileInput.files.length) {
                    const errorElement = document.getElementById('error_bukti_bayar');
                    errorElement.textContent = 'Bukti pembayaran wajib diupload';
                    errorElement.classList.remove('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Bukti pembayaran wajib diupload'
                    });
                    return;
                }
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengunggah...';
                
                // Send form data via AJAX
                const formData = new FormData(uploadForm);
                
                fetch('<?= base_url('online/prosesUploadBukti') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Kirim Bukti Pembayaran';
                    
                    if (data.error) {
                        // Display validation errors
                        if (data.error.error_bukti_bayar) {
                            const errorElement = document.getElementById('error_bukti_bayar');
                            errorElement.textContent = data.error.error_bukti_bayar;
                            errorElement.classList.remove('hidden');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error.error_bukti_bayar
                            });
                        }
                        
                        if (data.error.error_global) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error.error_global
                            });
                        }
                    } else if (data.success) {
                        // Show success message and redirect
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.success,
                            timer: 2500,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Kirim Bukti Pembayaran';
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
                    });
                });
            });
        });
    </script>
</body>
</html> 