<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="invoice p-3 mb-3" style="background-color: #f4f6f9; color: #333;">
    <!-- title row -->
    <div class="row">
        <div class="col-12 text-center">
            <h4>
                <i class="fas fa-tooth"></i> PROMEDICO DENTAL CARE
            </h4>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <b style="font-size: 18px;">Faktur Perawatan #<?= $perawatan['idperawatan'] ?></b><br>
                <small><strong>Status: </strong>
                    <span class="badge badge-success">
                        <?= ucfirst($booking['status']) ?>
                    </span>
                </small>
            </div>
        </div>
        <!-- /.col -->
    </div>
    
    <!-- info row -->
    <div class="row invoice-info mt-4">
        <div class="col-sm-4 invoice-col">
            <h5>Informasi Klinik:</h5>
            <address>
                <strong>Promedico Dental</strong><br>
                Jl. Maransi Aie Pacah Padang<br>
                Kota Padang, Sumatera Barat<br>
                Phone: 081234567890<br>
                Email: promedico@gmail.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <h5>Detail Perawatan:</h5>
            <address>
                <strong>Tanggal:</strong> <?= date('d F Y', strtotime($perawatan['tanggal'])) ?><br>
                <strong>Jenis Perawatan:</strong> <?= $booking['namajenis'] ?><br>
                <strong>Dokter:</strong> <?= $booking['nama_dokter'] ?><br>
                <strong>No. Booking:</strong> <?= $booking['idbooking'] ?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <h5>Informasi Pasien:</h5>
            <address>
                <strong><?= $booking['nama_pasien'] ?></strong><br>
                <?= isset($booking['alamat']) ? $booking['alamat'] : 'Alamat tidak tersedia' ?><br>
                Phone: <?= isset($booking['nohp']) ? $booking['nohp'] : 'No. HP tidak tersedia' ?><br>
            </address>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    
    <!-- Obat yang digunakan row -->
    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($detailObat as $obat): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $obat['nama_obat'] ?></td>
                        <td>Rp <?= number_format($obat['harga'], 0, ',', '.') ?></td>
                        <td><?= $obat['qty'] ?></td>
                        <td>Rp <?= number_format($obat['total'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Biaya Perawatan</th>
                        <th>Rp <?= number_format($booking['harga'], 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Obat</th>
                        <th>Rp <?= number_format(array_sum(array_column($detailObat, 'total')), 0, ',', '.') ?></th>
                    </tr> 
                    <tr>
                        <th colspan="4" class="text-right">Biaya Jenis Perawatan</th>
                        <th>Rp <?= number_format($booking['harga'], 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Biaya Konsultasi</th>
                        <th>Rp <?= number_format($booking['konsultasi'], 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">Total Keseluruhan</th>
                        <th>Rp <?= number_format($booking['harga'] + $booking['konsultasi'] + array_sum(array_column($detailObat, 'total')), 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- this row will not appear when printing -->
    <div class="row no-print mt-4">
        <div class="col-12">
            <a href="#" onclick="window.print();" class="btn btn-default">
                <i class="fas fa-print"></i> Cetak
            </a>
            <a href="<?= base_url() ?>/perawatan" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        // JavaScript tambahan jika diperlukan
    });
</script>
<?= $this->endSection() ?>