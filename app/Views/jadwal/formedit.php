<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
<div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
            <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Jadwal Dokter</h3>
            </div>

                <div class="card-body p-4">
                <?= form_open('jadwal/updatedata/'.$jadwal['idjadwal'], ['id' => 'formeditjadwal']) ?>
                <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="form-group row mb-4">
                                <label for="iddokter" class="col-sm-3 col-form-label">Dokter</label>
                                <div class="col-sm-9">
                                    <select id="iddokter" name="iddokter" class="form-control select2" style="width: 100%;">
                                <option value="">Pilih Dokter</option>
                                <?php foreach ($dokter as $d) : ?>
                                <option value="<?= $d['id_dokter'] ?>" <?= $jadwal['iddokter'] == $d['id_dokter'] ? 'selected' : '' ?>>
                                    <?= $d['nama'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback error_iddokter"></div>
                        </div>
                    </div>
                            
                            <div class="form-group row mb-4">
                                <label for="hari" class="col-sm-3 col-form-label">Hari</label>
                                <div class="col-sm-9">
                            <select id="hari" name="hari" class="form-control">
                                <option value="">Pilih Hari</option>
                                <option value="Senin" <?= $jadwal['hari'] == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                <option value="Selasa" <?= $jadwal['hari'] == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                <option value="Rabu" <?= $jadwal['hari'] == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                <option value="Kamis" <?= $jadwal['hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                <option value="Jumat" <?= $jadwal['hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                <option value="Sabtu" <?= $jadwal['hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                <option value="Minggu" <?= $jadwal['hari'] == 'Minggu' ? 'selected' : '' ?>>Minggu</option>
                            </select>
                            <div class="invalid-feedback error_hari"></div>
                        </div>
                    </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai</label>
                                <div class="col-sm-9">
                            <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control" value="<?= $jadwal['waktu_mulai'] ?>">
                            <div class="invalid-feedback error_waktu_mulai"></div>
                        </div>
                    </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                                <div class="col-sm-9">
                            <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control" value="<?= $jadwal['waktu_selesai'] ?>">
                            <div class="invalid-feedback error_waktu_selesai"></div>
                        </div>
                    </div>
                            
                            <div class="form-group row mb-4">
                                <label for="is_active" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                            <select id="is_active" name="is_active" class="form-control">
                                <option value="1" <?= $jadwal['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= $jadwal['is_active'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                            <div class="invalid-feedback error_is_active"></div>
                    </div>
                </div>
                
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN
                            </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('jadwal') ?>">
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
    // Inisialisasi select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    $('#formeditjadwal').submit(function(e) {
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

                    if (err.error_iddokter) {
                        $('#iddokter').addClass('is-invalid').removeClass('is-valid');
                        $('.error_iddokter').html(err.error_iddokter);
                    } else {
                        $('#iddokter').removeClass('is-invalid').addClass('is-valid');
                        $('.error_iddokter').html('');
                    }
                    
                    if (err.error_hari) {
                        $('#hari').addClass('is-invalid').removeClass('is-valid');
                        $('.error_hari').html(err.error_hari);
                    } else {
                        $('#hari').removeClass('is-invalid').addClass('is-valid');
                        $('.error_hari').html('');
                    }

                    if (err.error_waktu_mulai) {
                        $('#waktu_mulai').addClass('is-invalid').removeClass('is-valid');
                        $('.error_waktu_mulai').html(err.error_waktu_mulai);
                    } else {
                        $('#waktu_mulai').removeClass('is-invalid').addClass('is-valid');
                        $('.error_waktu_mulai').html('');
                    }

                    if (err.error_waktu_selesai) {
                        $('#waktu_selesai').addClass('is-invalid').removeClass('is-valid');
                        $('.error_waktu_selesai').html(err.error_waktu_selesai);
                    } else {
                        $('#waktu_selesai').removeClass('is-invalid').addClass('is-valid');
                        $('.error_waktu_selesai').html('');
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
                        window.location.href = '<?= site_url('jadwal') ?>';
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