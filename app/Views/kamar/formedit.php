<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-teal">
            <div class="card-header">
                <h3 class="card-title">Edit Data Kamar</h3>
            </div>

            <div class="card-body">
                <?= form_open('kamar/updatedata/' . $kamar['id_kamar'], ['id' => 'formedikamar']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_kamar">Kode Kamar</label>
                            <input type="text" id="id_kamar" name="id_kamar" class="form-control"
                                value="<?= $kamar['id_kamar'] ?>" readonly>
                            <div class="invalid-feedback error_id_kamar"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Kamar</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $kamar['nama'] ?>">
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="harga">Harga / Malam</label>
                            <input type="number" id="harga" name="harga" class="form-control" value="<?= $kamar['harga'] ?>">
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status_kamar">Status</label>
                            <select id="status_kamar" name="status_kamar" class="form-control">
                                <option value="tersedia" <?= $kamar['status_kamar'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="terisi" <?= $kamar['status_kamar'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                                <option value="perbaikan" <?= $kamar['status_kamar'] == 'perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
                            </select>
                            <div class="invalid-feedback error_status_kamar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol -->
    <div class="col-md-4">
        <div class="card d-flex align-items-center justify-content-center" style="height: 100%;">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" id="tombolSimpan">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('kamar') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formedikamar').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu...');
                    $('#tombolSimpan').prop('disabled', true);
                },
                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                    $('#tombolSimpan').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;
                        if (err.error_id_kamar) {
                            $('#id_kamar').addClass('is-invalid');
                            $('.error_id_kamar').html(err.error_id_kamar);
                        } else {
                            $('#id_kamar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_id_kamar').html('');
                        }

                        if (err.error_nama) {
                            $('#nama').addClass('is-invalid');
                            $('.error_nama').html(err.error_nama);
                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nama').html('');
                        }

                        if (err.error_harga) {
                            $('#harga').addClass('is-invalid');
                            $('.error_harga').html(err.error_harga);
                        } else {
                            $('#harga').removeClass('is-invalid').addClass('is-valid');
                            $('.error_harga').html('');
                        }

                        if (err.error_status_kamar) {
                            $('#status_kamar').addClass('is-invalid');
                            $('.error_status_kamar').html(err.error_status_kamar);
                        } else {
                            $('#status_kamar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_status_kamar').html('');
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
                            window.location.href = "<?= site_url('kamar') ?>";
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });

            return false;
        });
    });
</script>
<?= $this->endSection() ?>