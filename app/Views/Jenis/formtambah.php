<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Tambah Jenis Perawatan</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('jenis/save', ['id' => 'formtambahjenis']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="idjenis" class="col-sm-3 col-form-label">Kode Jenis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="idjenis" name="idjenis" value="<?= $next_number ?>" readonly>
                                    <div class="invalid-feedback error_idjenis"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="namajenis" class="col-sm-3 col-form-label">Nama Jenis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="namajenis" name="namajenis" placeholder="Masukkan nama jenis perawatan">
                                    <div class="invalid-feedback error_namajenis"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="estimasi" class="col-sm-3 col-form-label">Estimasi (Menit)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="estimasi" name="estimasi" placeholder="Estimasi waktu pengerjaan (dalam menit)">
                                    <div class="invalid-feedback error_estimasi"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="harga" class="col-sm-3 col-form-label">Harga (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga jasa">
                                    <div class="invalid-feedback error_harga"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan tambahan (opsional)"></textarea>
                                    <div class="invalid-feedback error_keterangan"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('jenis') ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> KEMBALI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    // Format input harga dengan pemisah ribuan
    $('#harga').on('input', function() {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    
    $('#formtambahjenis').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
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

                    if (err.error_namajenis) {
                        $('#namajenis').addClass('is-invalid').removeClass('is-valid');
                        $('.error_namajenis').html(err.error_namajenis);
                    } else {
                        $('#namajenis').removeClass('is-invalid').addClass('is-valid');
                        $('.error_namajenis').html('');
                    }
                    
                    if (err.error_estimasi) {
                        $('#estimasi').addClass('is-invalid').removeClass('is-valid');
                        $('.error_estimasi').html(err.error_estimasi);
                    } else {
                        $('#estimasi').removeClass('is-invalid').addClass('is-valid');
                        $('.error_estimasi').html('');
                    }

                    if (err.error_harga) {
                        $('#harga').addClass('is-invalid').removeClass('is-valid');
                        $('.error_harga').html(err.error_harga);
                    } else {
                        $('#harga').removeClass('is-invalid').addClass('is-valid');
                        $('.error_harga').html('');
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
                        window.location.href = '<?= site_url('jenis') ?>';
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