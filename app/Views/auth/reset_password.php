<!doctype html>
<html lang="en" class="layout-wide customizer-hide" data-assets-path="<?= base_url() ?>/assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Reset Password - Application</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/demo.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendor/css/pages/page-auth.css" />
    <script src="<?= base_url() ?>/assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url() ?>/assets/js/config.js"></script>
  </head>

  <body>
    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <div class="card p-sm-7 p-2">
            <div class="app-brand justify-content-center mt-5">
              <a href="<?= base_url() ?>" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">
                  <span class="text-primary">
                    <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <!-- SVG Code -->
                    </svg>
                  </span>
                </span>
                <span class="app-brand-text demo text-heading fw-semibold">Materio</span>
              </a>
            </div>

            <div class="card-body mt-1">
              <h4 class="mb-1">Reset Password 🔒</h4>
              <p class="mb-5">Silahkan masukkan password baru untuk akun Anda</p>

              <form id="formResetPassword" class="mb-3" action="<?= site_url('auth/reset-password') ?>" method="POST">
                <input type="hidden" name="email" value="<?= $email ?>">
                
                <div class="mb-4">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="password" class="form-control" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                        <label for="password">Password Baru</label>
                      </div>
                      <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                    </div>
                    <?php if(isset($validation) && $validation->hasError('password')): ?>
                      <div class="invalid-feedback d-block"><?= $validation->getError('password') ?></div>
                    <?php endif; ?>
                  </div>
                </div>
                
                <div class="mb-4">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirm"/>
                        <label for="password_confirm">Konfirmasi Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                    </div>
                    <?php if(isset($validation) && $validation->hasError('password_confirm')): ?>
                      <div class="invalid-feedback d-block"><?= $validation->getError('password_confirm') ?></div>
                    <?php endif; ?>
                  </div>
                </div>
                
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">Set Password Baru</button>
                </div>
              </form>

              <?php if(session()->getFlashdata('error')): ?>
              <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error'); ?>
              </div>
              <?php endif; ?>
              
              <?php if(session()->getFlashdata('message')): ?>
              <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('message'); ?>
              </div>
              <?php endif; ?>

              <p class="text-center">
                <a href="<?= site_url('auth') ?>">
                  <i class="icon-base ri ri-arrow-left-s-line icon-18px me-1"></i>
                  Kembali ke Login
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="<?= base_url() ?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url() ?>/assets/vendor/js/menu.js"></script>
    <script src="<?= base_url() ?>/assets/js/main.js"></script>
    
    <script>
    $(document).ready(function() {
        $('.form-password-toggle .input-group-text').on('click', function() {
            const $input = $(this).closest('.input-group').find('input');
            const $icon = $(this).find('i');
            
            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
            } else {
                $input.attr('type', 'password');
                $icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
            }
        });
    });
    </script>
  </body>
</html> 