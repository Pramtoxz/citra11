 <aside class="main-sidebar sidebar-dark-maroon elevation-4">
     <!-- Brand Logo -->
     <a href="<?= base_url('/') ?>" class="brand-link bg-maroon">
         <img src="<?= base_url() ?>/assets/img/citra11.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
         <span style="display: block; text-align: center;">Wisma Citra Sabaleh</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>


         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                 <li class="nav-item">
                     <a href="<?php base_url() ?>/admin" class="nav-link <?= (current_url() == base_url('admin')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-header">Master</li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/tamu" class="nav-link <?= (current_url() == base_url('tamu')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-user-friends "></i>
                         <p>
                             Tamu
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/kamar" class="nav-link <?= (current_url() == base_url('kamar')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-bed"></i>
                         <p>
                             Kamar
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/pengeluaran" class="nav-link <?= (current_url() == base_url('pengeluaran')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-money-bill-wave"></i>
                         <p>
                             Pengeluaran
                         </p>
                     </a>
                 </li>

                 <li class="nav-header">Transaksi</li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/reservasi" class="nav-link <?= (current_url() == base_url('reservasi')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-calendar-week"></i>
                         <p>
                             Reservasi
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/checkin" class="nav-link <?= (current_url() == base_url('checkin')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-hotel"></i>
                         <p>
                             Check-In
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?php base_url() ?>/checkout" class="nav-link <?= (current_url() == base_url('checkout')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-suitcase"></i>
                         <p>
                             Check-Out
                         </p>
                     </a>
                 </li>


                 <li class="nav-header">Laporan</li>

                 <li class="nav-item">
                     <a href="<?= base_url('laporan-users/pasien') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/pasien')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Tamu
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('laporan-users/dokter') ?>" class="nav-link <?= (current_url() == base_url('laporan-users/dokter')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Dokter
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('laporan-jadwal') ?>" class="nav-link <?= (current_url() == base_url('laporan-jadwal')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Jadwal Dokter
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('laporan-jenis') ?>" class="nav-link <?= (current_url() == base_url('laporan-jenis')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Jenis Perawatan
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('laporan-obat') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat') || current_url() == base_url('laporan-obat/view')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Obat
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="<?= base_url('laporan-obat/masuk') ?>" class="nav-link <?= (current_url() == base_url('laporan-obat/masuk')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Obat Masuk
                         </p>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a href="<?= base_url('laporan-transaksi/booking') ?>" class="nav-link <?= (current_url() == base_url('laporan-transaksi/booking')) ? 'active' : '' ?>">
                         <i class="nav-icon fas fa-paperclip"></i>
                         <p>
                             Laporan Booking
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>