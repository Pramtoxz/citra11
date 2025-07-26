<!-- Konten bukti pembayaran untuk modal -->
<div data-status="<?= $reservasi['status'] ?>">
    <!-- Informasi Reservasi -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-calendar-alt"></i> Informasi Reservasi</h6>
                </div>
                <div class="card-body p-3">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th width="40%">ID Booking</th>
                            <td><?= $reservasi['idbooking'] ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Check-in</th>
                            <td><?= date('d-m-Y', strtotime($reservasi['tglcheckin'])) ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Check-out</th>
                            <td><?= date('d-m-Y', strtotime($reservasi['tglcheckout'])) ?></td>
                        </tr>
                        <tr>
                            <th>Lama Menginap</th>
                            <td>
                                <?php
                                $checkinDate = new DateTime($reservasi['tglcheckin']);
                                $checkoutDate = new DateTime($reservasi['tglcheckout']);
                                $interval = $checkinDate->diff($checkoutDate);
                                echo $interval->days . ' malam';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if ($reservasi['status'] == 'diproses'): ?>
                                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                                <?php elseif ($reservasi['status'] == 'diterima'): ?>
                                    <span class="badge badge-success">Diterima</span>
                                <?php elseif ($reservasi['status'] == 'ditolak'): ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-user"></i> Data Tamu</h6>
                </div>
                <div class="card-body p-3">
                    <table class="table table-sm table-borderless mb-0">
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
                            <th>Email</th>
                            <td><?= $tamu['email'] ?: 'Belum Memiliki Akun' ?></td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td><?= $tamu['alamat'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Kamar dan Pembayaran -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-bed"></i> Informasi Kamar</h6>
                </div>
                <div class="card-body p-3">
                    <div class="text-center mb-2">
                        <img src="<?= base_url('assets/img/kamar/' . (!empty($kamar['cover']) ? $kamar['cover'] : 'kamar.png')) ?>" 
                             alt="Foto Kamar" class="img-fluid rounded" style="max-height: 120px;">
                    </div>
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <th width="50%">Nama Kamar</th>
                            <td><?= $kamar['nama'] ?></td>
                        </tr>
                        <tr>
                            <th>Harga per Malam</th>
                            <td>Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <th>Total Biaya</th>
                            <td><strong>Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-credit-card"></i> Bukti Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <?php if (!empty($reservasi['buktibayar'])): ?>
                        <div class="text-center mb-2">
                            <img src="<?= base_url('assets/img/bukti_bayar/' . $reservasi['buktibayar']) ?>" 
                                 alt="Bukti Bayar" class="img-fluid rounded border" style="max-height: 200px; cursor: pointer;"
                                 onclick="window.open('<?= base_url('assets/img/bukti_bayar/' . $reservasi['buktibayar']) ?>', '_blank')">
                            <p class="text-muted mt-1 mb-0"><small>Klik gambar untuk memperbesar</small></p>
                        </div>
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th width="50%">File</th>
                                <td><?= $reservasi['buktibayar'] ?></td>
                            </tr>
                            <tr>
                                <th>Upload</th>
                                <td><?= date('d-m-Y H:i', strtotime($reservasi['updated_at'])) ?> WIB</td>
                            </tr>
                            <tr>
                                <th>Jumlah Bayar</th>
                                <td><strong>Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></strong></td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning text-center mb-0">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p class="mb-0">Bukti pembayaran belum diupload</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informasi Waktu -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-clock"></i> Informasi Waktu</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Dibuat:</strong></p>
                            <p class="text-muted"><?= date('d-m-Y H:i', strtotime($reservasi['created_at'])) ?> WIB</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Diupdate:</strong></p>
                            <p class="text-muted"><?= date('d-m-Y H:i', strtotime($reservasi['updated_at'])) ?> WIB</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Batas Waktu:</strong></p>
                            <?php if (!empty($reservasi['batas_waktu'])): ?>
                                <?php 
                                $batasWaktu = strtotime($reservasi['batas_waktu']);
                                $sekarang = time();
                                $isExpired = $sekarang > $batasWaktu;
                                ?>
                                <p class="<?= $isExpired ? 'text-danger' : 'text-warning' ?>">
                                    <?= date('d-m-Y H:i', $batasWaktu) ?> WIB
                                    <?php if ($isExpired): ?>
                                        <br><small><i class="fas fa-exclamation-triangle"></i> Expired</small>
                                    <?php endif; ?>
                                </p>
                            <?php else: ?>
                                <p class="text-muted">-</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($reservasi['status'] == 'ditolak'): ?>
    <!-- Alasan Penolakan -->
    <div class="alert alert-danger mt-3">
        <h6><i class="fas fa-times-circle"></i> Pembayaran Ditolak</h6>
        <p class="mb-0">Bukti pembayaran tidak valid atau tidak sesuai dengan jumlah yang harus dibayar.</p>
    </div>
    <?php elseif ($reservasi['status'] == 'diterima'): ?>
    <!-- Konfirmasi Diterima -->
    <div class="alert alert-success mt-3">
        <h6><i class="fas fa-check-circle"></i> Pembayaran Diterima</h6>
        <p class="mb-0">Bukti pembayaran telah diverifikasi dan reservasi dikonfirmasi.</p>
    </div>
    <?php endif; ?>
</div> 