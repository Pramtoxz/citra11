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

    <title>Lupa Password - Application</title>

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
  </head>

  <body>
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Forgot Password -->
          <div class="card p-sm-7 p-2">
            <!-- Logo -->
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
            <!-- /Logo -->

            <div class="card-body mt-1">
              <h4 class="mb-1">Lupa Password? 🔒</h4>
              <p class="mb-5">
                Masukkan email Anda dan kami akan mengirimkan instruksi untuk reset password
              </p>

              <form id="formForgotPassword" class="mb-3" action="<?= site_url('auth/forgot-password') ?>" method="POST">
                <div class="form-floating form-floating-outline mb-4 form-control-validation">
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Masukkan email"
                    autofocus
                  />
                  <label for="email">Email</label>
                  <?php if(isset($validation) && $validation->hasError('email')): ?>
                    <div class="invalid-feedback d-block"><?= $validation->getError('email') ?></div>
                  <?php endif; ?>
                </div>
                
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">Kirim Link Reset</button>
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
                <a href="<?= site_url('auth/login') ?>">
                  <i class="icon-base ri ri-arrow-left-s-line icon-18px me-1"></i>
                  Kembali ke Login
                </a>
              </p>
            </div>
          </div>
          <!-- /Forgot Password -->
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
  </body>
</html> 