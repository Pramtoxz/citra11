<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Wisma Citra Sabaleh</title>
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
                        'shake': 'shake 0.82s cubic-bezier(.36,.07,.19,.97) both',
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
                        },
                        shake: {
                            '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
                            '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
                            '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
                            '40%, 60%': { transform: 'translate3d(4px, 0, 0)' },
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
        <div class="absolute top-40 right-20 w-20 h-20 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 left-20 w-28 h-28 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-10 w-36 h-36 bg-white/5 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
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
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Citra Sabaleh</h1>
                    <p class="text-pink-100 text-sm">Buat password baru</p>
                </div>
            </div>

            <!-- Reset Password Form -->
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Reset Password 🔒</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Masukkan password baru untuk akun Anda. Pastikan password kuat dan mudah diingat.
                    </p>
                </div>

                <form id="formResetPassword" class="space-y-6" action="<?= site_url('auth/reset-password') ?>" method="POST">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-4 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p><?= session()->getFlashdata('error'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-4 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p><?= session()->getFlashdata('message'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Email Display -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-primary-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Reset password untuk:</p>
                                <p class="font-semibold text-gray-800"><?= $email ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-lock mr-2 text-primary-500"></i>Password Baru
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl bg-white/70 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-300 hover:bg-white/90"
                                placeholder="Minimal 6 karakter"
                                required
                                autofocus
                            />
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary-500 transition duration-300"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('password')): ?>
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <?= $validation->getError('password') ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-2">
                        <label for="password_confirm" class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-shield-alt mr-2 text-primary-500"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirm"
                                name="password_confirm"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl bg-white/70 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-300 hover:bg-white/90"
                                placeholder="Ulangi password baru"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-confirm-password" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary-500 transition duration-300"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if(isset($validation) && $validation->hasError('password_confirm')): ?>
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <?= $validation->getError('password_confirm') ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Kekuatan Password:</span>
                            <span id="strength-text" class="text-sm font-medium">-</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <p class="text-blue-800 text-sm font-semibold mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Persyaratan Password:
                        </p>
                        <ul class="text-blue-700 text-xs space-y-1">
                            <li id="req-length" class="flex items-center">
                                <i class="fas fa-circle text-gray-400 mr-2 text-xs"></i>
                                Minimal 6 karakter
                            </li>
                            <li id="req-match" class="flex items-center">
                                <i class="fas fa-circle text-gray-400 mr-2 text-xs"></i>
                                Password dan konfirmasi harus sama
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            id="submit-btn"
                            class="w-full bg-gradient-to-r from-primary-500 to-purple-600 text-white py-3 px-6 rounded-xl font-bold text-lg hover:from-primary-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-primary-300 transform hover:scale-105 transition duration-300 shadow-lg animate-pulse-glow disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            <i class="fas fa-save mr-2"></i>
                            <span id="submit-text">Set Password Baru</span>
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 mb-4">
                        Password sudah diingat?
                    </p>
                    <a href="<?= site_url('auth') ?>" class="inline-flex items-center font-semibold text-primary-600 hover:text-primary-500 transition duration-300 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-xl">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Login
                    </a>
                </div>

                <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="<?= site_url('/') ?>" class="text-gray-500 hover:text-primary-500 transition duration-300 text-sm">
                        <i class="fas fa-home mr-2"></i>
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

            $('#toggle-confirm-password').on('click', function() {
                const $input = $('#password_confirm');
                const $icon = $(this).find('i');
                
                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                if (password.length >= 6) strength += 25;
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                
                return strength;
            }

            function updateStrengthIndicator(strength) {
                const $strengthBar = $('#strength-bar');
                const $strengthText = $('#strength-text');
                
                if (strength < 25) {
                    $strengthBar.css('width', strength + '%').removeClass().addClass('h-2 rounded-full transition-all duration-300 bg-red-500');
                    $strengthText.text('Lemah').removeClass().addClass('text-sm font-medium text-red-600');
                } else if (strength < 50) {
                    $strengthBar.css('width', strength + '%').removeClass().addClass('h-2 rounded-full transition-all duration-300 bg-orange-500');
                    $strengthText.text('Sedang').removeClass().addClass('text-sm font-medium text-orange-600');
                } else if (strength < 75) {
                    $strengthBar.css('width', strength + '%').removeClass().addClass('h-2 rounded-full transition-all duration-300 bg-yellow-500');
                    $strengthText.text('Baik').removeClass().addClass('text-sm font-medium text-yellow-600');
                } else {
                    $strengthBar.css('width', strength + '%').removeClass().addClass('h-2 rounded-full transition-all duration-300 bg-green-500');
                    $strengthText.text('Kuat').removeClass().addClass('text-sm font-medium text-green-600');
                }
            }

            function validateForm() {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirm').val();
                const $submitBtn = $('#submit-btn');
                
                // Check length requirement
                if (password.length >= 6) {
                    $('#req-length i').removeClass('fa-circle text-gray-400').addClass('fa-check-circle text-green-500');
                } else {
                    $('#req-length i').removeClass('fa-check-circle text-green-500').addClass('fa-circle text-gray-400');
                }
                
                // Check password match
                if (password && confirmPassword && password === confirmPassword) {
                    $('#req-match i').removeClass('fa-circle text-gray-400').addClass('fa-check-circle text-green-500');
                } else {
                    $('#req-match i').removeClass('fa-check-circle text-green-500').addClass('fa-circle text-gray-400');
                }
                
                // Enable submit button if all requirements met
                if (password.length >= 6 && password === confirmPassword && password.length > 0) {
                    $submitBtn.prop('disabled', false);
                } else {
                    $submitBtn.prop('disabled', true);
                }
            }

            // Real-time validation
            $('#password').on('input', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                updateStrengthIndicator(strength);
                validateForm();
            });

            $('#password_confirm').on('input', function() {
                validateForm();
            });

            // Add focus effects
            $('input').on('focus', function() {
                $(this).parent().addClass('transform scale-105 transition duration-300');
            }).on('blur', function() {
                $(this).parent().removeClass('transform scale-105 transition duration-300');
            });

            // Enhanced form submission
            $('#formResetPassword').on('submit', function(e) {
                const password = $('#password').val();
                const confirmPassword = $('#password_confirm').val();
                const $submitBtn = $('#submit-btn');
                const $submitText = $('#submit-text');

                if (password !== confirmPassword) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Password Tidak Cocok',
                        text: 'Konfirmasi password harus sama dengan password',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                    return false;
                }

                // Show loading state
                $submitBtn.prop('disabled', true);
                $submitText.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...');

                // Let form submit naturally but provide feedback
                setTimeout(() => {
                    $submitText.html('<i class="fas fa-check mr-2"></i>Password Diubah!');
                }, 1000);
            });
        });
    </script>
</body>
</html> 