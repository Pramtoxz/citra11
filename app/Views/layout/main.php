<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin <?= $title ?? 'LTE' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php base_url() ?>/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/toastr/toastr.min.css">
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/assets/img/logors.jpg">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?php base_url() ?>/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="<?php base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?= base_url() ?>/assets/img/logo.png" alt="AdminLTELogo"
                height="120" width="400">
        </div> -->
        <!-- Navbar -->
        <?= $this->include('layout/navbar') ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= $this->include('layout/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <?= $this->renderSection('content') ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?= $this->include('layout/footer') ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?php base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?php base_url() ?>/assets/dist/js/demo.js"></script> -->
    <!-- DataTables  & Plugins -->
    <script src="<?php base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php base_url() ?>/assets/plugins/toastr/toastr.min.js"></script>
    <script src="<?php base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Select2 -->
    <script src="<?php base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>


    <!-- Script -->
    <?= $this->renderSection('script') ?>

    <script>
    // $(document).ready(function() {
    //     var url = window.location.href;
    //     var str = url.split('/');

    //     $('a.nav-link').filter(function() {
    //         return this.href == '<?= base_url() ?>' + str[3];
    //     }).addClass('active');
    // });

    $(document).on('click', '.btnLogout', function() {
        Swal.fire({
            title: "Apakah anda yakin ingin keluar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                setTimeout(function() {
                    window.location.href = '<?= site_url('/logout') ?>';
                }, 1000);
            }
        });
    });


    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    </script>
</body>

</html>