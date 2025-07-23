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
                <b style="font-size: 18px;">Booking Receipt #<?= $booking['idbooking'] ?></b><br>
                <small><strong>Status: </strong>
                    <span class="badge <?= ($booking['status'] == 'pending') ? 'badge-warning' : (($booking['status'] == 'diterima') ? 'badge-success' : 'badge-danger') ?>">
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
            <h5>Clinic Information:</h5>
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
            <h5>Appointment Details:</h5>
            <address>
                <strong>Date:</strong> <?= date('d F Y', strtotime($booking['tanggal'])) ?><br>
                <strong>Time:</strong> <?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?><br>
                <strong>Treatment:</strong> <?= $booking['namajenis'] ?><br>
                <strong>Duration:</strong> <?= $booking['estimasi'] ?> minutes<br>
                <strong>Doctor:</strong> <?= $booking['nama_dokter'] ?><br>
                <strong>Day:</strong> <?= $booking['hari'] ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <h5>Patient Information:</h5>
            <address>
                <strong><?= $booking['nama_pasien'] ?></strong><br>
                <?= isset($booking['alamat']) ? $booking['alamat'] : 'Address not provided' ?><br>
                Phone: <?= isset($booking['nohp']) ? $booking['nohp'] : 'Phone not provided' ?><br>
            </address>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    
    <!-- Treatment row -->
    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Treatment</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $booking['namajenis'] ?></td>
                        <td>Dental treatment - <?= $booking['estimasi'] ?> minutes</td>
                        <td>Rp <?= number_format($booking['harga'], 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- QR and signature row -->
    <div class="row mt-4">
        <div class="col-6">
            <div class="text-center">
                <p><strong>Scan QR Code for Check-in:</strong></p>
                <img src="<?= $qrCodeImage ?>" alt="Check-in QR Code" style="width: 150px; margin-top: 20px;">
                <p class="mt-2 text-muted">Present this QR code when you arrive at the clinic</p>
            </div>
        </div>
        <div class="col-6">
            <div class="text-center">
                <p><strong>Padang, <?= date('d F Y') ?></strong></p>
                <br><br>
                <p class="mt-4"><strong>Promedico Dental</strong></p>
                <p>Management</p>
            </div>
        </div>
    </div>
    
    <?php if (isset($booking['catatan']) && !empty($booking['catatan'])): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Notes:</h5>
                <?= $booking['catatan'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- this row will not appear when printing -->
    <div class="row no-print mt-4">
        <div class="col-12">
            <a href="#" onclick="window.print();" class="btn btn-default">
                <i class="fas fa-print"></i> Print
            </a>
            <a href="<?= base_url() ?>/booking" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Additional scripts if needed -->
<script>
    $(function() {
        // Any additional JavaScript can be added here
    });
</script>
<?= $this->endSection() ?>