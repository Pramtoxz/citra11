<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h3 class="card-title">Detail Check-in Booking</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h4 class="card-title">Booking #<?= $booking['idbooking'] ?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Pasien:</label>
                                                <p class="form-control"><?= $booking['nama_pasien'] ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Dokter:</label>
                                                <p class="form-control"><?= $booking['nama_dokter'] ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Perawatan:</label>
                                                <p class="form-control"><?= $booking['namajenis'] ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal:</label>
                                                <p class="form-control"><?= date('d F Y', strtotime($booking['tanggal'])) ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Waktu:</label>
                                                <p class="form-control"><?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Status:</label>
                                                <p>
                                                    <span class="badge 
                                                        <?= ($booking['status'] == 'pending') ? 'badge-warning' : 
                                                            (($booking['status'] == 'diterima') ? 'badge-success' : 
                                                            (($booking['status'] == 'diperiksa') ? 'badge-info' : 'badge-danger')) ?>">
                                                        <?= ucfirst($booking['status']) ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php if ($booking['status'] == 'diterima'): ?>
                                    <div class="text-center mt-4">
                                        <button id="checkinButton" class="btn btn-success btn-lg" data-id="<?= $booking['idbooking'] ?>">
                                            <i class="fas fa-check-circle"></i> Proses Check-in
                                        </button>
                                    </div>
                                    <?php elseif ($booking['status'] == 'diperiksa'): ?>
                                    <div class="alert alert-success mt-4">
                                        <i class="fas fa-check-circle"></i> Pasien sudah check-in dan sedang dalam proses pemeriksaan.
                                    </div>
                                    <?php elseif ($booking['status'] == 'pending'): ?>
                                    <div class="alert alert-warning mt-4">
                                        <i class="fas fa-exclamation-circle"></i> Booking ini masih dalam status pending. Harap konfirmasi terlebih dahulu sebelum check-in.
                                    </div>
                                    <?php elseif ($booking['status'] == 'ditolak'): ?>
                                    <div class="alert alert-danger mt-4">
                                        <i class="fas fa-times-circle"></i> Booking ini telah ditolak dan tidak dapat diproses.
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('booking/checkin') ?>" class="btn btn-primary">
                        <i class="fas fa-qrcode"></i> Scan QR Code Lain
                    </a>
                    <a href="<?= base_url('booking') ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Handle check-in button
    $('#checkinButton').on('click', function() {
        const bookingId = $(this).data('id');
        
        Swal.fire({
            title: 'Konfirmasi Check-in',
            text: "Apakah Anda yakin ingin memproses check-in pasien ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Proses Check-in',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                processCheckin(bookingId);
            }
        });
    });
    
    function processCheckin(bookingId) {
        $.ajax({
            url: '<?= site_url('booking/processCheckin') ?>',
            type: 'POST',
            data: {
                idbooking: bookingId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Check-in Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload the page to reflect the new status
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Check-in Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses check-in.'
                });
            }
        });
    }
});
</script>
<?= $this->endSection() ?> 