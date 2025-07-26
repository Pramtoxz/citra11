<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wisma Citra Sabaleh</title>
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
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
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
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(236, 72, 153, 0.3)' },
                            '50%': { boxShadow: '0 0 40px rgba(236, 72, 153, 0.6)' },
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
            background: linear-gradient(135deg, #ec4899 0%, #be185d 25%, #9333ea 50%, #7c3aed 75%, #6b21a8 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 left-20 w-40 h-40 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-10 w-20 h-20 bg-white/5 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
        <div class="absolute top-60 left-1/2 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Main Card -->
        <div class="glass-effect rounded-3xl overflow-hidden animate-slide-up shadow-2xl">
            <!-- Header with Hotel Branding -->
            <div class="bg-gradient-to-r from-primary-500 to-purple-600 p-8 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-white/10"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse-glow">
                        <i class="fas fa-hotel text-3xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Citra Sabaleh</h1>
                    <p class="text-pink-100 text-sm">Selamat datang kembali</p>
                </div>
            </div>

            <!-- Login Form -->
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk ke Akun Anda</h2>
                    <p class="text-gray-600">Silakan login untuk melanjutkan</p>
                </div>

                <form id="formAuthentication" class="space-y-6">
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-4 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p><?= session()->getFlashdata('error'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div id="alert-message" class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-4 hidden animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span id="alert-text"></span>
                        </div>
                    </div>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-4 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p><?= session()->getFlashdata('message'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Username/Email Field -->
                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user mr-2 text-primary-500"></i>Email atau Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white/70 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-300 hover:bg-white/90"
                            placeholder="Masukkan email atau username"
                            required
                            autofocus
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl bg-white/70 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-300 hover:bg-white/90"
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary-500 transition duration-300"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                            />
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="<?= site_url('auth/forgot-password') ?>" class="text-sm text-primary-600 hover:text-primary-500 font-medium transition duration-300">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button
                            type="submit"
                            id="login-btn"
                            class="w-full bg-gradient-to-r from-primary-500 to-purple-600 text-white py-3 px-6 rounded-xl font-bold text-lg hover:from-primary-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-primary-300 transform hover:scale-105 transition duration-300 shadow-lg animate-pulse-glow"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            <span id="login-text">Masuk</span>
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Belum memiliki akun?
                        <a href="<?= site_url('auth/register') ?>" class="font-semibold text-primary-600 hover:text-primary-500 transition duration-300">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="<?= site_url('/') ?>" class="text-gray-500 hover:text-primary-500 transition duration-300 text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#toggle-password').on('click', function() {
                const $input = $('#password');
                const $icon = $(this).find('i');
                
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form submission with enhanced UI feedback
            $('#formAuthentication').on('submit', function(e) {
                e.preventDefault();
                
                const username = $('#username').val();
                const password = $('#password').val();
                const remember = $('#remember').is(':checked') ? 'on' : 'off';
                const $loginBtn = $('#login-btn');
                const $loginText = $('#login-text');
                
                // Hide previous alert if exists
                $('#alert-message').addClass('hidden');
                
                // Show loading state
                $loginBtn.prop('disabled', true);
                $loginText.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');
                
                $.ajax({
                    url: '<?= site_url('auth/login') ?>',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password,
                        remember: remember
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $loginText.html('<i class="fas fa-check mr-2"></i>Berhasil!');
                            
                            Swal.fire({
                                title: 'Login Berhasil!',
                                text: 'Selamat datang kembali',
                                icon: 'success',
                                confirmButtonColor: '#ec4899',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            $loginBtn.prop('disabled', false);
                            $loginText.html('<i class="fas fa-sign-in-alt mr-2"></i>Masuk');
                            
                            $('#alert-text').text(response.message);
                            $('#alert-message').removeClass('hidden');
                            
                            // Shake animation for error
                            $('#formAuthentication').addClass('animate-pulse');
                            setTimeout(() => {
                                $('#formAuthentication').removeClass('animate-pulse');
                            }, 500);
                        }
                    },
                    error: function() {
                        $loginBtn.prop('disabled', false);
                        $loginText.html('<i class="fas fa-sign-in-alt mr-2"></i>Masuk');
                        
                        $('#alert-text').text('Terjadi kesalahan sistem. Silakan coba lagi.');
                        $('#alert-message').removeClass('hidden');
                    }
                });
            });

            // Add focus effects
            $('input').on('focus', function() {
                $(this).parent().addClass('transform scale-105 transition duration-300');
            }).on('blur', function() {
                $(this).parent().removeClass('transform scale-105 transition duration-300');
            });
        });
    </script>
</body>
</html> 