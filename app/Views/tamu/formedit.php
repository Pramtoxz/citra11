<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-maroon">
            <div class="card-header text-center">
                <h3 class="card-title">Edit Data Tamu</h3>
            </div>

            <div class="card-body">
                <?= form_open('tamu/updatedata/' . $tamu['nik'], ['id' => 'formedittamu', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="text" id="nik" name="nik" class="form-control"
                                value="<?= $tamu['nik'] ?>" readonly>
                            <div class="invalid-feedback error_id_tamu"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama">Nama Tamu</label>
                            <input type="text" id="nama" name="nama" class="form-control" value="<?= $tamu['nama'] ?>">
                            <div class="invalid-feedback error_nama"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" value="<?= $tamu['alamat'] ?>">
                            <div class="invalid-feedback error_alamat"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nohp">No HP</label>
                            <input type="number" id="nohp" name="nohp" class="form-control" value="<?= $tamu['nohp'] ?>">
                            <div class="invalid-feedback error_nohp"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="jk">Jenis Kelamin</label>
                            <select id="jk" name="jk" class="form-control">
                                <option value="L" <?= $tamu['jk'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $tamu['jk'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <div class="invalid-feedback error_jk"></div>
                        </div>

                        <!-- Form untuk informasi user account -->
                        <?php if (!empty($tamu['iduser'])): ?>
                            <hr class="mt-4 mb-4">
                            <h5 class="text-center"><i class="fas fa-user-shield"></i> Informasi Akun User</h5>
                            <p class="text-muted text-center">Tamu ini sudah memiliki akun user. Anda dapat mengubah password jika diperlukan.</p>
                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" value="<?= $tamu['username'] ?? '' ?>" readonly>
                                <small class="text-muted">Username tidak dapat diubah untuk akun yang sudah ada</small>
                                <div class="invalid-feedback error_username"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= $tamu['email'] ?? '' ?>" readonly>
                                <small class="text-muted">Email tidak dapat diubah untuk akun yang sudah ada</small>
                                <div class="invalid-feedback error_email"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                <div class="invalid-feedback error_password"></div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary" id="tombolSimpan">
                                <i class="fas fa-save"></i> SIMPAN
                            </button>
                            <a class="btn btn-secondary ml-2" href="<?= base_url('tamu') ?>">
                                <i class="fas fa-arrow-left"></i> KEMBALI
                            </a>
                        </div>
                    </div>
                </div>
                
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formedittamu').submit(function(e) {
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

                        if (err.error_id_tamu) {
                            $('#nik').addClass('is-invalid').removeClass('is-valid');
                            $('.error_id_tamu').html(err.error_id_tamu);
                        } else {
                            $('#nik').removeClass('is-invalid').addClass('is-valid');
                            $('.error_id_tamu').html('');
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

                        if (err.error_jk) {
                            $('#jk').addClass('is-invalid').removeClass('is-valid');
                            $('.error_jk').html(err.error_jk);
                        } else {
                            $('#jk').removeClass('is-invalid').addClass('is-valid');
                            $('.error_jk').html('');
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
                            window.location.href = '<?= site_url('tamu') ?>';
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

    <?php if (!empty($tamu['iduser'])): ?>
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