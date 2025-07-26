<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Tamu - Wisma Citra Sabaleh</title>
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
                <div class="text-white animate-fade-in">
                    <i class="fas fa-user mr-2"></i>
                    Hai, <?= session()->get('username') ?>!
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20 pb-10">
        <!-- Floating elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-40 left-20 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        </div>

        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto">
                <!-- Form Card -->
                <div class="glass-effect rounded-3xl p-8 lg:p-12 shadow-2xl border border-white/20 animate-slide-up">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-user-plus text-4xl text-white"></i>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                            Lengkapi Data Diri
                        </h1>
                        <p class="text-xl text-pink-100">
                            Untuk melanjutkan booking, silakan lengkapi data tamu terlebih dahulu
                        </p>
                    </div>

                    <!-- Form -->
                    <form id="tamuForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- NIK -->
                            <div class="md:col-span-2">
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-id-card mr-2 text-pink-300"></i>
                                    NIK (16 Digit)
                                </label>
                                <input type="text" 
                                       id="nik" 
                                       name="nik"
                                       maxlength="16"
                                       required
                                       placeholder="Masukkan NIK 16 digit"
                                       class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                                <div id="error-nik" class="text-pink-300 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-user mr-2 text-pink-300"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" 
                                       id="nama" 
                                       name="nama"
                                       required
                                       placeholder="Masukkan nama lengkap"
                                       class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                                <div id="error-nama" class="text-pink-300 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-pink-300"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea id="alamat" 
                                          name="alamat"
                                          rows="3"
                                          required
                                          placeholder="Masukkan alamat lengkap"
                                          class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm resize-none"></textarea>
                                <div id="error-alamat" class="text-pink-300 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- No HP -->
                            <div>
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-phone mr-2 text-pink-300"></i>
                                    Nomor HP
                                </label>
                                <input type="tel" 
                                       id="nohp" 
                                       name="nohp"
                                       required
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                                <div id="error-nohp" class="text-pink-300 text-sm mt-1 hidden"></div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-white font-semibold mb-2">
                                    <i class="fas fa-venus-mars mr-2 text-pink-300"></i>
                                    Jenis Kelamin
                                </label>
                                <select id="jk" 
                                        name="jk"
                                        required
                                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent backdrop-blur-sm">
                                    <option value="" class="text-gray-800">Pilih Jenis Kelamin</option>
                                    <option value="L" class="text-gray-800">Laki-laki</option>
                                    <option value="P" class="text-gray-800">Perempuan</option>
                                </select>
                                <div id="error-jk" class="text-pink-300 text-sm mt-1 hidden"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit" 
                                    id="submitBtn"
                                    class="w-full bg-white text-primary-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Data & Lanjutkan
                            </button>
                        </div>

                        <!-- Info -->
                        <div class="mt-6 text-center">
                            <p class="text-pink-100 text-sm">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Data Anda aman dan dienkripsi
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="<?= site_url('auth/logout') ?>" class="text-white hover:text-pink-300 transition duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Logout & Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('tamuForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            document.querySelectorAll('[id^="error-"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            
            // Get form data
            const formData = new FormData(this);
            
            // Validate NIK (16 digits, numeric)
            const nik = formData.get('nik');
            if (!/^\d{16}$/.test(nik)) {
                showError('nik', 'NIK harus 16 digit angka');
                return;
            }
            
            // Validate phone number
            const nohp = formData.get('nohp');
            if (!/^08\d{8,13}$/.test(nohp)) {
                showError('nohp', 'Nomor HP harus dimulai dengan 08 dan 10-15 digit');
                return;
            }
            
            // Show loading
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
            submitBtn.disabled = true;
            
            // Send AJAX request
            fetch('<?= site_url('online/simpan-data-tamu') ?>', {
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
                        confirmButtonText: 'Lanjutkan',
                        confirmButtonColor: '#ec4899'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field, data.errors[field]);
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonColor: '#ec4899'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            })
            .finally(() => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
        
        function showError(field, message) {
            const errorEl = document.getElementById('error-' + field);
            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
            }
        }
        
        // Format NIK input (only numbers)
        document.getElementById('nik').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
        
        // Format phone number
        document.getElementById('nohp').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
</body>
</html> 