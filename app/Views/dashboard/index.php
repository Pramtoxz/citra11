<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Google Fonts: Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">

<div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 60vh;">
    <img src="<?= base_url() ?>/assets/img/citra11.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="width: 180px; height: 180px;">
    <h1 style="font-family: 'Poppins', sans-serif; color: #D81B60; margin-top: 32px; text-align: center;">
        Selamat Datang Di Sistem Informasi Wisma Citra Sabaleh Padang
    </h1>
</div>

<?= $this->endSection() ?>