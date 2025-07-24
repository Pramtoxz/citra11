<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-teal">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Kamar</h3>
            </div>

            <div class="card-body">
                <?= form_open('kamar/save', ['id' => 'formtambahkamar', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_kamar">ID Kamar</label>
                            <input type="text" id="id_kamar" name="id_kamar" class="form-control" value="<?= $next_id ?>" readonly>
                            <div class="invalid-feedback error_id_kamar"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Kamar</label>
                            <input type="text" id="nama" name="nama" class="form-control">
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" class="form-control">
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status_kamar">Status</label>
                            <select id="status_kamar" name="status_kamar" class="form-control">
                                <option value="tersedia">Tersedia</option>
                                <option value="terisi">Terisi</option>
                            </select>
                            <div class="invalid-feedback error_status_kamar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Simpan -->
    <div class="col-md-4">
        <div class="card" style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
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
        $('#formtambahkamar').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

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

                        if (err.id_kamar) {
                            $('#id_kamar').addClass('is-invalid');
                            $('.error_id_kamar').html(err.id_kamar);
                        } else {
                            $('#id_kamar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_id_kamar').html('');
                        }

                        if (err.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.error_nama').html(err.nama);
                        } else {
                            $('#nama').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nama').html('');
                        }

                        if (err.harga) {
                            $('#harga').addClass('is-invalid');
                            $('.error_harga').html(err.harga);
                        } else {
                            $('#harga').removeClass('is-invalid').addClass('is-valid');
                            $('.error_harga').html('');
                        }

                        if (err.status_kamar) {
                            $('#status_kamar').addClass('is-invalid');
                            $('.error_status_kamar').html(err.status_kamar);
                        } else {
                            $('#status_kamar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_status_kamar').html('');
                        }

                    } else if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.href = "<?= site_url('kamar') ?>";
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan:\n' + xhr.responseText);
                }
            });

            return false;
        });
    });
</script>
<?= $this->endSection() ?>