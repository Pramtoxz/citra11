<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Tambah Data Obat</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('obat/save', ['id' => 'formtambahobat']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="idobat" class="col-sm-3 col-form-label">Kode Obat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="idobat" name="idobat" value="<?= $next_number ?>" readonly>
                                    <div class="invalid-feedback error_idobat"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Obat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama obat">
                                    <div class="invalid-feedback error_nama"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Jumlah stok obat">
                                    <div class="invalid-feedback error_stok"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="jenis" name="jenis">
                                        <option value="">Pilih Jenis Obat</option>
                                        <option value="Tablet">Tablet</option>
                                        <option value="Kapsul">Kapsul</option>
                                        <option value="Sirup">Sirup</option>
                                        <option value="Salep">Salep</option>
                                        <option value="Tetes">Tetes</option>
                                        <option value="Injeksi">Injeksi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <div class="invalid-feedback error_jenis"></div>
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
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('obat') ?>">
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
    $('#formtambahobat').submit(function(e) {
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

                    if (err.error_nama) {
                        $('#nama').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nama').html(err.error_nama);
                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nama').html('');
                    }
                    
                    if (err.error_stok) {
                        $('#stok').addClass('is-invalid').removeClass('is-valid');
                        $('.error_stok').html(err.error_stok);
                    } else {
                        $('#stok').removeClass('is-invalid').addClass('is-valid');
                        $('.error_stok').html('');
                    }

                    if (err.error_jenis) {
                        $('#jenis').addClass('is-invalid').removeClass('is-valid');
                        $('.error_jenis').html(err.error_jenis);
                    } else {
                        $('#jenis').removeClass('is-invalid').addClass('is-valid');
                        $('.error_jenis').html('');
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
                        window.location.href = '<?= site_url('obat') ?>';
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