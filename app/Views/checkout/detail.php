<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Check-out</h5>
                </div>
                <div class="card-body">
                    <!-- Informasi Check-out -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-sign-out-alt"></i> Informasi Check-out</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">ID Check-out</th>
                                            <td><?= $checkout['idcheckout'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>ID Check-in</th>
                                            <td><?= $checkout['idcheckin'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>ID Reservasi</th>
                                            <td><?= $reservasi['idbooking'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Check-out</th>
                                            <td><?= date('d-m-Y H:i', strtotime($checkout['tglcheckout'])) ?> WIB</td>
                                        </tr>
                                        <tr>
                                            <th>Potongan</th>
                                            <td class="text-danger">Rp <?= number_format($checkout['potongan'], 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kembalian</th>
                                            <td class="text-success"><strong>Rp <?= number_format($checkin['deposit'] - $checkout['potongan'], 0, ',', '.') ?></strong></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge badge-success">Selesai</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-user"></i> Informasi Tamu</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Nama</th>
                                            <td><?= $tamu['nama'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td><?= $tamu['nik'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>No HP</th>
                                            <td><?= $tamu['nohp'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td><?= $tamu['alamat'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $tamu['email'] ?: 'Belum Memiliki Akun' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Kamar dan Pembayaran -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card card-outline card-warning">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-bed"></i> Informasi Kamar & Rincian Check-out</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="50%">Nama Kamar</th>
                                                    <td><?= $kamar['nama'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga per Malam</th>
                                                    <td>Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Check-in</th>
                                                    <td><?= date('d-m-Y', strtotime($reservasi['tglcheckin'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Check-out Rencana</th>
                                                    <td><?= date('d-m-Y', strtotime($reservasi['tglcheckout'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lama Menginap</th>
                                                    <td>
                                                        <?php
                                                        $checkinDate = new DateTime($reservasi['tglcheckin']);
                                                        $checkoutDate = new DateTime($reservasi['tglcheckout']);
                                                        $interval = $checkinDate->diff($checkoutDate);
                                                        $lamaMenginap = $interval->days;
                                                        echo $lamaMenginap . ' malam';
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="50%">Total Biaya</th>
                                                    <td>Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Sisa Bayar (Check-in)</th>
                                                    <td>Rp <?= number_format($checkin['sisabayar'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deposit Dibayar</th>
                                                    <td class="text-info">Rp <?= number_format($checkin['deposit'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Potongan Check-out</th>
                                                    <td class="text-warning">Rp <?= number_format($checkout['potongan'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th><strong>Kembalian</strong></th>
                                                    <td class="text-success"><strong>Rp <?= number_format($checkin['deposit'] - $checkout['potongan'], 0, ',', '.') ?></strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header text-center">
                                    <h5 class="m-0">Foto Kamar</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="<?= base_url('assets/img/kamar/' . (!empty($kamar['cover']) ? $kamar['cover'] : 'kamar.png')) ?>" alt="Foto Kamar" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keterangan Check-out -->
                    <?php if (!empty($checkout['keterangan'])): ?>
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-sticky-note"></i> Keterangan Check-out</h3>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?= $checkout['keterangan'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('checkout') ?>" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                                
                                <a href="<?= base_url('checkout/faktur/' . $checkout['idcheckout']) ?>" class="btn btn-warning">
                                    <i class="fas fa-file-invoice"></i> Cetak Faktur Check-out
                                </a>
                                
                                <a href="<?= base_url('checkin/detail/' . $checkout['idcheckin']) ?>" class="btn btn-info">
                                    <i class="fas fa-eye"></i> Lihat Detail Check-in
                                </a>
                                
                                <a href="<?= base_url('reservasi/detail/' . $reservasi['idbooking']) ?>" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Detail Reservasi
                                </a>
                                
                                <a href="<?= base_url('checkout/formedit/' . $checkout['idcheckout']) ?>" class="btn btn-success">
                                    <i class="fas fa-edit"></i> Edit Check-out
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Catatan -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <h5><i class="fas fa-check-circle"></i> Check-out Selesai!</h5>
                                <ul class="mb-0">
                                    <li>Kembalian deposit sebesar Rp <?= number_format($checkin['deposit'] - $checkout['potongan'], 0, ',', '.') ?> telah diberikan</li>
                                    <li>Kamar <?= $kamar['nama'] ?> telah tersedia untuk tamu berikutnya</li>
                                    <li>Terima kasih telah menginap di Wisma Citra Sabaleh</li>
                                    <li>Untuk cetak faktur check-out, klik tombol "Cetak Faktur Check-out"</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?> 