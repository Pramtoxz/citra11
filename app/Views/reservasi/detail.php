<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Reservasi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('reservasi') ?>">Reservasi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle mr-1"></i>
                Detail Reservasi <?= $reservasi['idbooking'] ?>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <a href="<?= base_url('reservasi') ?>" class="btn btn-tool">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Informasi Reservasi -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-calendar-check mr-1"></i> Informasi Reservasi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th style="width: 40%">ID Booking</th>
                                        <td><?= $reservasi['idbooking'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Check-in</th>
                                        <td><?= date('d F Y', strtotime($reservasi['tglcheckin'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Check-out</th>
                                        <td><?= date('d F Y', strtotime($reservasi['tglcheckout'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lama Menginap</th>
                                        <td><?= $reservasi['lama'] ?> malam</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <?php
                                            $badgeClass = 'badge-secondary';
                                            switch ($reservasi['status']) {
                                                case 'diterima':
                                                    $badgeClass = 'badge-success';
                                                    break;
                                                case 'ditolak':
                                                    $badgeClass = 'badge-danger';
                                                    break;
                                                case 'cancel':
                                                    $badgeClass = 'badge-warning';
                                                    break;
                                                case 'selesai':
                                                    $badgeClass = 'badge-info';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($reservasi['status']) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipe Reservasi</th>
                                        <td>
                                            <?php if ($reservasi['online'] == 1): ?>
                                                <span class="badge badge-primary">Online</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Offline</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Informasi Tamu -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success">
                            <h3 class="card-title">
                                <i class="fas fa-user mr-1"></i> Informasi Tamu
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th style="width: 40%">NIK</th>
                                        <td><?= $tamu['nik'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Tamu</th>
                                        <td><?= $tamu['nama'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td><?= $tamu['alamat'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td><?= $tamu['telp'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $tamu['email'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <!-- Informasi Kamar -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                <i class="fas fa-bed mr-1"></i> Informasi Kamar
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th style="width: 40%">ID Kamar</th>
                                                <td><?= $kamar['id_kamar'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Kamar</th>
                                                <td><?= $kamar['nama'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Harga per Malam</th>
                                                <td>Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <th>DP</th>
                                                <td>Rp <?= number_format($kamar['dp'], 0, ',', '.') ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <?php $cover = !empty($kamar['cover']) ? $kamar['cover'] : 'kamar.png'; ?>
                                            <img src="<?= base_url('assets/img/kamar/' . $cover) ?>" alt="Foto Kamar" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($kamar['deskripsi'])): ?>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Deskripsi Kamar</h3>
                                        </div>
                                        <div class="card-body">
                                            <?= $kamar['deskripsi'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Informasi Pembayaran -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-warning">
                            <h3 class="card-title">
                                <i class="fas fa-money-bill mr-1"></i> Informasi Pembayaran
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th style="width: 40%">Tipe Pembayaran</th>
                                        <td><?= $reservasi['tipebayar'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Harga per Malam</th>
                                        <td>Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lama Menginap</th>
                                        <td><?= $reservasi['lama'] ?> malam</td>
                                    </tr>
                                    <tr class="bg-light">
                                        <th>Total Harga</th>
                                        <td class="font-weight-bold">Rp <?= number_format($reservasi['lama'] * $kamar['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                    <?php if (session()->has('reservasi_' . $reservasi['idbooking'] . '_dp')): ?>
                                    <tr>
                                        <th>DP</th>
                                        <td>Rp <?= number_format(session('reservasi_' . $reservasi['idbooking'] . '_dp'), 0, ',', '.') ?></td>
                                    </tr>
                                    <tr class="bg-light">
                                        <th>Sisa Bayar</th>
                                        <td class="font-weight-bold">Rp <?= number_format(session('reservasi_' . $reservasi['idbooking'] . '_sisabayar'), 0, ',', '.') ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr class="table-success">
                                        <th>Total Dibayar</th>
                                        <td class="font-weight-bold">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></td>
                                    </tr>
                                </table>
                            </div>
                            
                            <?php if ($reservasi['online'] == 1 && !empty($reservasi['buktibayar'])): ?>
                            <div class="mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Bukti Pembayaran</h3>
                                    </div>
                                    <div class="card-body p-0 text-center">
                                        <img src="<?= base_url('uploads/buktibayar/' . $reservasi['buktibayar']) ?>" alt="Bukti Pembayaran" class="img-fluid" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4 d-print-none">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Cetak Detail Reservasi
                    </button>
                    <a href="<?= base_url('reservasi') ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Reservasi
                    </a>
                    <?php if ($reservasi['status'] == 'diterima'): ?>
                    <a href="<?= base_url('reservasi/cekin/' . $reservasi['idbooking']) ?>" class="btn btn-success ml-2">
                        <i class="fas fa-check-circle mr-1"></i> Check In
                    </a>
                    <?php endif; ?>
                    <?php if ($reservasi['status'] == 'diterima' || $reservasi['status'] == 'checkout'): ?>
                    <button type="button" class="btn btn-danger ml-2" id="btnCancel" data-id="<?= $reservasi['idbooking'] ?>">
                        <i class="fas fa-times-circle mr-1"></i> Batalkan Reservasi
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .d-print-none {
        display: none !important;
    }
    .card-outline {
        border-top: none !important;
    }
    body {
        margin: 0;
        padding: 0;
    }
    .container-fluid {
        width: 100%;
        padding: 0;
        margin: 0;
    }
}
</style>

<script>
$(document).ready(function() {
    $('#btnCancel').on('click', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Batalkan Reservasi?',
            text: "Reservasi akan dibatalkan dan status kamar akan diperbarui!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url() ?>/reservasi/cancel/' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Dibatalkan!',
                                'Reservasi telah dibatalkan.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'Gagal membatalkan reservasi',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>