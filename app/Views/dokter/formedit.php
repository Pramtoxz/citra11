<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-teal">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Dokter</h3>
            </div>

            <div class="card-body">
                <?= form_open('dokter/updatedata/'.$dokter['id_dokter'], ['id' => 'formeditdokter', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_dokter">Kode Dokter</label>
                            <input type="text" id="id_dokter" name="id_dokter" class="form-control"
                                value="<?= $dokter['id_dokter'] ?>" readonly>
                            <div class="invalid-feedback error_id_dokter"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Dokter</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $dokter['nama'] ?>">
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $dokter['alamat'] ?>">
                            <div class="invalid-feedback error_alamat"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control" value="<?= $dokter['nohp'] ?>">
                            <div class="invalid-feedback error_nohp"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="jenkel">Jenkel</label>
                            <select id="jenkel" name="jenkel" class="form-control">
                                <option value="Laki-laki" <?= $dokter['jenkel'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $dokter['jenkel'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback error_jenkel"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tgllahir">Tanggal Lahir</label>
                            <input type="date" id="tgllahir" name="tgllahir" class="form-control" value="<?= $dokter['tgllahir'] ?>">
                            <div class="invalid-feedback error_tgllahir"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Form untuk informasi user account -->
                <?php if(!empty($dokter['iduser'])): ?>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <h5><i class="fas fa-user-shield"></i> Informasi Akun User</h5>
                        <p class="text-muted">Dokter ini sudah memiliki akun user. Anda dapat mengubah password jika diperlukan.</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= $dokter['email'] ?? '' ?>" <?= !empty($dokter) ? 'readonly' : '' ?>>
                            <small class="text-muted">Email tidak dapat diubah untuk akun yang sudah ada</small>
                            <div class="invalid-feedback error_email"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            <div class="invalid-feedback error_password"></div>
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
                <h3 class="card-title">Foto Dokter</h3>
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="cover" name="cover" accept="image/*"
                        onchange="previewCover()">
                    <label class="custom-file-label" for="cover"><?= !empty($dokter['foto']) ? $dokter['foto'] : 'Pilih foto' ?></label>
                    <div class="invalid-feedback error_cover"></div>
                </div>
            </div>
            <div class="card-body" style="overflow: hidden;">
                <img id="coverPreview" src="<?= !empty($dokter['foto']) ? base_url('assets/img/dokter/' . $dokter['foto']) : base_url('assets/img/dokter.png') ?>" alt="Preview Cover" class="img-fluid"
                    style="max-width: 100%; max-height: 100%;">
            </div>
        </div>
        <div class="card"
            style="padding-left: 10px; padding-right: 10px; display: flex; flex-direction: column; justify-content: center; height: 15%;">
            <div class="form-group" style="text-align: center;">
                <button type="submit" class="btn btn-primary" id="tombolSimpan" style="margin-right: 1rem;">
                    <i class="fas fa-save"></i> SIMPAN
                </button>
                <a class="btn btn-secondary" href="<?= base_url('dokter') ?>">Kembali</a>
            </div>
        </div>
    </div>
    <?= form_close() ?>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    $('#formeditdokter').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this); // Menggunakan FormData untuk mendukung file upload
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: formData, // Menggunakan formData untuk mendukung file upload
            contentType: false, // Menunjukkan tidak adanya konten
            processData: false, // Menunjukkan tidak adanya proses data
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

                    if (err.error_id_dokter) {
                        $('#id_dokter').addClass('is-invalid').removeClass('is-valid');
                        $('.error_id_dokter').html(err.error_id_dokter);
                    } else {
                        $('#id_dokter').removeClass('is-invalid').addClass('is-valid');
                        $('.error_id_dokter').html('');
                    }
                    if (err.error_nama) {
                        $('#nama').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nama').html(err.error_nama);
                    } else {
                        $('#nama').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nama').html('');
                    }



                    if (err.error_nohp) {
                        $('#nohp').addClass('is-invalid').removeClass('is-valid');
                        $('.error_nohp').html(err.error_nohp);
                    } else {
                        $('#nohp').removeClass('is-invalid').addClass('is-valid');
                        $('.error_nohp').html('');
                    }

                    if (err.error_jenkel) {
                        $('#jenkel').addClass('is-invalid').removeClass('is-valid');
                        $('.error_jenkel').html(err.error_jenkel);
                    } else {
                        $('#jenkel').removeClass('is-invalid').addClass('is-valid');
                        $('.error_jenkel').html('');
                    }

                    if (err.error_tgllahir) {
                        $('#tgllahir').addClass('is-invalid').removeClass('is-valid');
                        $('.error_tgllahir').html(err.error_tgllahir);
                    } else {
                        $('#tgllahir').removeClass('is-invalid').addClass('is-valid');
                        $('.error_tgllahir').html('');
                    }

                    if (err.error_cover) {
                        $('#cover').addClass('is-invalid').removeClass('is-valid');
                        $('.error_cover').html(err.error_cover);
                    } else {
                        $('#cover').removeClass('is-invalid').addClass('is-valid');
                        $('.error_cover').html('');
                    }
                    
                    // Validasi untuk field password
                    if (err.error_password) {
                        $('#password').addClass('is-invalid').removeClass('is-valid');
                        $('.error_password').html(err.error_password);
                    } else {
                        $('#password').removeClass('is-invalid').addClass('is-valid');
                        $('.error_password').html('');
                    }

                    // Validasi untuk field email
                    if (err.error_email) {
                        $('#email').addClass('is-invalid').removeClass('is-valid');
                        $('.error_email').html(err.error_email);
                    } else {
                        $('#email').removeClass('is-invalid').addClass('is-valid');
                        $('.error_email').html('');
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
                        window.location.href = '<?= site_url('dokter') ?>';
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

<?php if(!empty($dokter['iduser'])): ?>
// Handler untuk update password
$('#password').on('change', function() {
    const password = $(this).val();
    if (password.length > 0 && password.length < 6) {
        $('#password').addClass('is-invalid');
        $('.error_password').text('Password minimal 6 karakter');
    } else {
        $('#password').removeClass('is-invalid');
        $('.error_password').text('');
    }
});
<?php endif; ?>

function previewCover() {
    const cover = document.querySelector('#cover');
    const coverPreview = document.querySelector('#coverPreview');
    const coverLabel = document.querySelector('label[for="cover"]');

    coverPreview.style.display = 'block';
    const oFReader = new FileReader();
    oFReader.readAsDataURL(cover.files[0]);

    oFReader.onload = function(oFREvent) {
        coverPreview.src = oFREvent.target.result;
    };

    coverLabel.textContent = cover.files[0].name;
}
</script>
<?= $this->endSection() ?>