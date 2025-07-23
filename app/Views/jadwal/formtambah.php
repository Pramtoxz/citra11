<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i> Tambah Jadwal Dokter</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('jadwal/save', ['id' => 'formtambahjadwal']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="form-group row mb-4">
                                <label for="idjadwal" class="col-sm-3 col-form-label">ID Jadwal</label>
                                <div class="col-sm-9">
                                    <input type="text" id="idjadwal" name="idjadwal" value="<?= $next_number ?>" readonly class="form-control">
                                    <div class="invalid-feedback error_idjadwal"></div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="iddokter" class="col-sm-3 col-form-label">Dokter</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" id="iddokter" name="iddokter" class="form-control" readonly>
                                        <input type="text" id="namadokter" name="namadokter" class="form-control" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="button-addon2" data-toggle="modal"
                                                    data-target="#modalDokter">Cari</button>
                                        </div>
                                        <div class="invalid-feedback error_iddokter"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="hari" class="col-sm-3 col-form-label">Hari</label>
                                <div class="col-sm-9">
                                    <select id="hari" name="hari" class="form-control">
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                    <div class="invalid-feedback error_hari"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai</label>
                                <div class="col-sm-9">
                                    <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control">
                                    <div class="invalid-feedback error_waktu_mulai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                                <div class="col-sm-9">
                                    <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control">
                                    <div class="invalid-feedback error_waktu_selesai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="is_active" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select id="is_active" name="is_active" class="form-control">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
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

                    <!-- Modal Pilih Dokter -->
                    <div class="modal fade" id="modalDokter" tabindex="-1" role="dialog" aria-labelledby="modalDokterLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDokterLabel">Pilih Dokter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
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
    
    $('#formtambahjadwal').submit(function(e) {
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
    
    $('#modalDokter').on('show.bs.modal', function(e) {
        var loader =
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Load data here from the server
        $.get('<?= base_url() ?>/jadwal/getdokter', function(data) {
            $('#modalDokter .modal-body').html(data);
        });
    });
    
    // Menangani klik pada tombol pilih dokter dari modal
    $(document).on('click', '.btn-pilihdokter', function() {
        var id_dokter = $(this).data('id_dokter');
        var nama_dokter = $(this).data('nama_dokter');
        
        $('#iddokter').val(id_dokter);
        $('#namadokter').val(nama_dokter);
        
        // Hapus class is-invalid jika ada
        $('#iddokter').removeClass('is-invalid');
        
        // Tutup modal
        $('#modalDokter').modal('hide');
    });
});
</script>
<?= $this->endSection() ?>