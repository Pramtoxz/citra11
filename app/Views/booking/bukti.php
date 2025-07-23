<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-teal">
            <div class="card-header">
                <h3 class="card-title">Bukti Booking</h3>
            </div>

            <div class="card-body">
                <?= form_open('booking/updateStatusBukti/'.$booking['idbooking'], ['id' => 'formeditpasien', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idbooking">Kode Booking</label>
                            <input type="text" id="idbooking" name="idbooking" class="form-control"
                                value="<?= $booking['idbooking'] ?>" readonly>
                            <div class="invalid-feedback error_idbooking"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Pasien</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $booking['pasien_nama'] ?? '' ?>" readonly>
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="text" id="waktu_mulai" name="waktu_mulai" class="form-control" value="<?= $booking['waktu_mulai'] ?? '' ?>" readonly>
                            <div class="invalid-feedback error_waktu_mulai"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="text" id="waktu_selesai" name="waktu_selesai" class="form-control" value="<?= $booking['waktu_selesai'] ?? '' ?>" readonly>
                            <div class="invalid-feedback error_waktu_selesai"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama_dokter">Dokter</label>
                            <input type="text" id="nama_dokter" name="nama_dokter" class="form-control" value="<?= $booking['nama_dokter'] ?? '' ?>" readonly>
                            <div class="invalid-feedback error_nama_dokter"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $booking['tanggal'] ?? '' ?>" readonly>
                            <div class="invalid-feedback error_tanggal"></div>
                        </div>
                    </div>
                </div>
                <!-- Status Booking -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">Status Booking</label>
                            <select id="status" name="status" class="form-control">
                                <option value="diterima" <?= $booking['status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                                <option value="ditolak" <?= $booking['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                            <div class="invalid-feedback error_status"></div>
                        </div>
                    </div>
                </div>
                <!-- Informasi Akun User (readonly) -->
                <?php if(!empty($booking['iduser'])): ?>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <h5><i class="fas fa-user-shield"></i> Informasi Akun User</h5>
                        <p class="text-muted">Pasien ini sudah memiliki akun user.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $booking['email'] ?? '' ?>" readonly>
                            <small class="text-muted">Email tidak dapat diubah</small>
                            <div class="invalid-feedback error_email"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Card Preview -->
    <div class="col-md-4">
        <div class="card bg-teal" style="padding-left: 10px; padding-right: 10px; height: 362px;">
            <div class="card-header ">
                <h3 class="card-title">Foto Pasien</h3>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cover" name="cover" accept="image/*" disabled>
                    <label class="custom-file-label" for="cover">Pilih File</label>
                    <div class="invalid-feedback error_cover"></div>
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <img id="coverPreview" src="<?= base_url('assets/img/' . $booking['bukti_bayar']) ?>" alt="Preview Cover" class="img-fluid"
                    style="max-width: 100%; max-height: 100%; display: block;">
            </div>
        </div>
        <div class="card"
            style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('booking') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditpasien').submit(function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('status', $('#status').val());
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                $('#tombolSimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;
                    if (err.error_status) {
                        $('#status').addClass('is-invalid').removeClass('is-valid');
                        $('.error_status').html(err.error_status);
                    } else {
                        $('#status').removeClass('is-invalid').addClass('is-valid');
                        $('.error_status').html('');
                    }
                }
                if (response.sukses) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = '<?= site_url('booking') ?>';
                    }, 1500);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false;
    });
});
</script>
<?= $this->endSection() ?>