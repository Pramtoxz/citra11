<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Wisma Citra Sabaleh</title>
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
                        'bounce-slow': 'bounce 2s infinite',
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
        .otp-input {
            width: 55px;
            height: 65px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .otp-input:focus {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(236, 72, 153, 0.4);
        }
        .otp-input.filled {
            background: linear-gradient(135deg, #ec4899, #be185d);
            color: white;
            border-color: #ec4899;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-24 h-24 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 left-20 w-20 h-20 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-white/5 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
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
                        <i class="fas fa-mobile-alt text-3xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Citra Sabaleh</h1>
                    <p class="text-pink-100 text-sm">Verifikasi kode OTP</p>
                </div>
            </div>

            <!-- OTP Verification Form -->
            <div class="p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Masukkan Kode Verifikasi 🔒</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Kami telah mengirimkan kode verifikasi 6 digit ke email 
                        <span class="font-semibold text-primary-600"><?= $email ?></span>
                    </p>
                </div>

                <form id="formOTP" action="<?= site_url($action) ?>" method="POST">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <input type="hidden" name="type" value="<?= $type ?>">
                    <?php if (isset($formData) && !empty($formData)): ?>
                        <?php foreach($formData as $key => $value): ?>
                            <input type="hidden" name="form_data[<?= $key ?>]" value="<?= $value ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <p><?= session()->getFlashdata('error'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div id="alert-message" class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 hidden animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span id="alert-text"></span>
                        </div>
                    </div>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 animate-fade-in" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <p><?= session()->getFlashdata('message'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- OTP Input Fields -->
                    <div class="flex justify-center gap-3 mb-6">
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="0" autofocus>
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="1">
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="2">
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="3">
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="4">
                        <input type="text" class="otp-input" maxlength="1" name="otp[]" data-index="5">
                    </div>
                    
                    <!-- Timer -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center bg-orange-50 border border-orange-200 rounded-xl px-4 py-2">
                            <i class="fas fa-clock text-orange-500 mr-2"></i>
                            <span class="text-orange-800 text-sm">
                                Kode berlaku selama: <span id="countdown" class="font-bold">10:00</span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="mb-6">
                        <button
                            type="submit"
                            id="verify-btn"
                            class="w-full bg-gradient-to-r from-primary-500 to-purple-600 text-white py-3 px-6 rounded-xl font-bold text-lg hover:from-primary-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-primary-300 transform hover:scale-105 transition duration-300 shadow-lg animate-pulse-glow disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                        >
                            <i class="fas fa-shield-check mr-2"></i>
                            <span id="verify-text">Verifikasi</span>
                        </button>
                    </div>
                </form>
                
                <!-- Resend OTP -->
                <div class="text-center mb-6">
                    <p class="text-gray-600 mb-3">Tidak menerima kode?</p>
                    <button 
                        id="resendOTP" 
                        class="inline-flex items-center font-semibold text-primary-600 hover:text-primary-500 transition duration-300 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-xl disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                    >
                        <i class="fas fa-redo mr-2"></i>
                        <span id="resend-text">Kirim Ulang</span>
                    </button>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div class="text-blue-800 text-sm">
                            <p class="font-semibold mb-1">Tips verifikasi:</p>
                            <ul class="space-y-1 text-xs">
                                <li>• Periksa folder spam jika kode tidak diterima</li>
                                <li>• Pastikan koneksi internet stabil</li>
                                <li>• Kode hanya berlaku sekali pakai</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="<?= site_url('auth') ?>" class="text-gray-500 hover:text-primary-500 transition duration-300 text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let duration = 10 * 60; // 10 minutes in seconds
            let timer = duration;
            let countdownInterval;

            // OTP Input Management
            $('.otp-input').on('keyup', function(e) {
                const index = parseInt($(this).data('index'));
                const value = $(this).val();
                
                // Only allow numbers
                if (!/^\d$/.test(value) && value !== '') {
                    $(this).val('');
                    return;
                }
                
                // Update visual state
                if (value) {
                    $(this).addClass('filled');
                    // Move to next input
                    if (index < 5) {
                        $('.otp-input[data-index="' + (index + 1) + '"]').focus();
                    }
                } else {
                    $(this).removeClass('filled');
                }
                
                // Handle backspace
                if (e.keyCode === 8 && index > 0 && value === '') {
                    $('.otp-input[data-index="' + (index - 1) + '"]').focus();
                }
                
                // Check if all inputs are filled
                checkOTPComplete();
            });
            
            // Allow only numbers
            $('.otp-input').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value) {
                    $(this).addClass('filled');
                } else {
                    $(this).removeClass('filled');
                }
                checkOTPComplete();
            });

            // Check if OTP is complete
            function checkOTPComplete() {
                let isComplete = true;
                $('.otp-input').each(function() {
                    if ($(this).val() === '') {
                        isComplete = false;
                        return false;
                    }
                });
                
                $('#verify-btn').prop('disabled', !isComplete);
            }
            
            // Countdown timer
            function updateCountdown() {
                const minutes = Math.floor(timer / 60);
                let seconds = timer % 60;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                $('#countdown').text(minutes + ":" + seconds);
                
                if (timer === 0) {
                    clearInterval(countdownInterval);
                    $('#resendOTP').prop('disabled', false);
                    $('.otp-input').prop('disabled', true).removeClass('filled');
                    $('#verify-btn').prop('disabled', true);
                    $('#alert-text').text('Kode OTP telah kedaluarsa. Silakan kirim ulang kode.');
                    $('#alert-message').removeClass('hidden');
                } else {
                    timer--;
                }
            }
            
            // Start countdown
            countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
            
            // Handle resend OTP
            $('#resendOTP').on('click', function(e) {
                e.preventDefault();
                
                const $button = $(this);
                const $text = $('#resend-text');
                
                $button.prop('disabled', true);
                $text.html('<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...');
                
                $.ajax({
                    url: '<?= site_url('auth/resend-otp') ?>',
                    type: 'POST',
                    data: {
                        email: '<?= $email ?>',
                        type: '<?= $type ?>'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Reset timer
                            timer = duration;
                            clearInterval(countdownInterval);
                            countdownInterval = setInterval(updateCountdown, 1000);
                            
                            // Clear inputs & enable them
                            $('.otp-input').val('').prop('disabled', false).removeClass('filled');
                            $('.otp-input[data-index="0"]').focus();
                            
                            // Hide error message
                            $('#alert-message').addClass('hidden');
                            
                            // Show success feedback
                            Swal.fire({
                                title: 'Kode Baru Terkirim!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#ec4899',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            $text.html('<i class="fas fa-redo mr-2"></i>Kirim Ulang');
                        } else {
                            $('#alert-text').text(response.message);
                            $('#alert-message').removeClass('hidden');
                            $button.prop('disabled', false);
                            $text.html('<i class="fas fa-redo mr-2"></i>Kirim Ulang');
                        }
                    },
                    error: function() {
                        $('#alert-text').text('Terjadi kesalahan. Silakan coba lagi.');
                        $('#alert-message').removeClass('hidden');
                        $button.prop('disabled', false);
                        $text.html('<i class="fas fa-redo mr-2"></i>Kirim Ulang');
                    }
                });
            });

            // Form submission
            $('#formOTP').on('submit', function(e) {
                const $verifyBtn = $('#verify-btn');
                const $verifyText = $('#verify-text');
                
                // Show loading state
                $verifyBtn.prop('disabled', true);
                $verifyText.html('<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...');
                
                // Let form submit naturally but provide feedback
                setTimeout(() => {
                    $verifyText.html('<i class="fas fa-check mr-2"></i>Berhasil!');
                }, 1000);
            });

            // Add focus effects
            $('.otp-input').on('focus', function() {
                $(this).parent().addClass('transform scale-105 transition duration-300');
            }).on('blur', function() {
                $(this).parent().removeClass('transform scale-105 transition duration-300');
            });

            // Auto-paste OTP from clipboard
            $(document).on('paste', '.otp-input', function(e) {
                e.preventDefault();
                const paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
                const otpRegex = /^\d{6}$/;
                
                if (otpRegex.test(paste)) {
                    const digits = paste.split('');
                    $('.otp-input').each(function(index) {
                        $(this).val(digits[index]).addClass('filled');
                    });
                    checkOTPComplete();
                    $('.otp-input').last().focus();
                }
            });
        });
    </script>
</body>
</html> 