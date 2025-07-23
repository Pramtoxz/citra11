<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-assets-path="<?= base_url() ?>/assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Verifikasi OTP - Application</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?= base_url() ?>/assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url() ?>/assets/js/config.js"></script>
    
    <style>
        .otp-inputs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .otp-inputs input {
            width: 50px;
            height: 60px;
            margin: 0 8px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 8px;
        }
        .timer {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
        }
    </style>
  </head>

  <body>
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Verification -->
          <div class="card p-sm-7 p-2">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="<?= base_url() ?>" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                    <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <!-- SVG logo code -->
                    </svg>
                  </span>
                </span>
                <span class="app-brand-text demo text-heading fw-semibold">Materio</span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">
              <h4 class="mb-1">Masukkan Kode Verifikasi 🔒</h4>
              <p class="mb-5">
                Kami telah mengirimkan kode verifikasi ke email <strong><?= $email ?></strong>. 
                <br>Silakan masukkan kode tersebut di bawah ini.
              </p>

              <form id="formOTP" action="<?= site_url($action) ?>" method="POST">
                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="type" value="<?= $type ?>">
                <?php if (isset($formData) && !empty($formData)): ?>
                    <?php foreach($formData as $key => $value): ?>
                        <input type="hidden" name="form_data[<?= $key ?>]" value="<?= $value ?>">
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="otp-inputs">
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="0" autofocus>
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="1">
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="2">
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="3">
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="4">
                    <input type="text" class="form-control otp-input" maxlength="1" name="otp[]" data-index="5">
                </div>
                
                <div class="timer">
                    <span>Kode berlaku selama: <span id="countdown">10:00</span></span>
                </div>
                
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">Verifikasi</button>
                </div>
              </form>
              
              <div class="text-center">
                <p>Tidak menerima kode? <a href="#" id="resendOTP">Kirim ulang</a></p>
              </div>

              <?php if(session()->getFlashdata('error')): ?>
              <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
              </div>
              <?php endif; ?>
              
              <div id="alert-message" class="alert alert-danger d-none" role="alert">
                <!-- Error message will be displayed here -->
              </div>
              
              <?php if(session()->getFlashdata('message')): ?>
              <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('message'); ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <!-- /Verification -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <script src="<?= base_url() ?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/js/menu.js"></script>
    <script src="<?= base_url() ?>/assets/js/main.js"></script>

    <script>
    $(document).ready(function() {
        // Handle OTP input
        $('.otp-input').on('keyup', function(e) {
            const index = parseInt($(this).data('index'));
            
            // If a digit is entered, focus the next input
            if ($(this).val().length === 1) {
                if (index < 5) {
                    $('.otp-input[data-index="' + (index + 1) + '"]').focus();
                }
            }
            
            // On backspace, focus the previous input
            if (e.keyCode === 8 && index > 0 && $(this).val().length === 0) {
                $('.otp-input[data-index="' + (index - 1) + '"]').focus();
            }
        });
        
        // Allow only numbers
        $('.otp-input').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Countdown timer
        let duration = 10 * 60; // 10 minutes in seconds
        let timer = duration;
        
        function updateCountdown() {
            const minutes = Math.floor(timer / 60);
            let seconds = timer % 60;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            $('#countdown').text(minutes + ":" + seconds);
            
            if (timer === 0) {
                clearInterval(countdownInterval);
                $('#resendOTP').removeClass('disabled');
                $('.otp-input').prop('disabled', true);
                $('#alert-message').removeClass('d-none').text('Kode OTP telah kedaluarsa. Silakan kirim ulang kode.');
            } else {
                timer--;
            }
        }
        
        let countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
        
        // Handle resend OTP
        $('#resendOTP').on('click', function(e) {
            e.preventDefault();
            
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
                        updateCountdown();
                        
                        // Clear inputs & enable them
                        $('.otp-input').val('').prop('disabled', false);
                        $('.otp-input[data-index="0"]').focus();
                        
                        // Hide error message if any
                        $('#alert-message').addClass('d-none');
                        
                        // Show success message
                        const alertHtml = `
                            <div class="alert alert-success alert-dismissible" role="alert">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        $('#formOTP').before(alertHtml);
                    } else {
                        $('#alert-message').removeClass('d-none').text(response.message);
                    }
                },
                error: function() {
                    $('#alert-message').removeClass('d-none').text('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
    </script>
  </body>
</html> 