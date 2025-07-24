<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-teal">
            <div class="card-header">
                <h3 class="card-title">Edit Data Pengeluaran</h3>
            </div>

            <div class="card-body">
                <?= form_open('pengeluaran/updatedata/' . $pengeluaran['id'], ['id' => 'formedipengeluaran']) ?>
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id">ID Pengeluaran</label>
                            <input type="text" id="id" name="id" class="form-control" value="<?= $pengeluaran['id'] ?>" readonly>
                            <div class="invalid-feedback error_id"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="date" id="tgl" name="tgl" class="form-control" value="<?= $pengeluaran['tgl'] ?>">
                            <div class="invalid-feedback error_tgl"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="<?= $pengeluaran['keterangan'] ?>">
                            <div class="invalid-feedback error_keterangan"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="total">Total (Rp)</label>
                            <input type="number" id="total" name="total" class="form-control" value="<?= $pengeluaran['total'] ?>">
                            <div class="invalid-feedback error_total"></div>
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
                <a class="btn btn-secondary" href="<?= base_url('pengeluaran') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formedipengeluaran').submit(function(e) {
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

                        if (err.id) {
                            $('#id').addClass('is-invalid');
                            $('.error_id').html(err.id);
                        } else {
                            $('#id').removeClass('is-invalid').addClass('is-valid');
                            $('.error_id').html('');
                        }

                        if (err.tgl) {
                            $('#tgl').addClass('is-invalid');
                            $('.error_tgl').html(err.tgl);
                        } else {
                            $('#tgl').removeClass('is-invalid').addClass('is-valid');
                            $('.error_tgl').html('');
                        }

                        if (err.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.error_keterangan').html(err.keterangan);
                        } else {
                            $('#keterangan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_keterangan').html('');
                        }

                        if (err.total) {
                            $('#total').addClass('is-invalid');
                            $('.error_total').html(err.total);
                        } else {
                            $('#total').removeClass('is-invalid').addClass('is-valid');
                            $('.error_total').html('');
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
                            window.location.href = "<?= site_url('pengeluaran') ?>";
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });

            return false;
        });
    });
</script>
<?= $this->endSection() ?>