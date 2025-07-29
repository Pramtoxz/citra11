<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-maroon">
            <div class="card-header text-center">
                <h3 class="card-title">Edit Data Kamar</h3>
            </div>

            <div class="card-body">
                <?= form_open('kamar/updatedata/' . $kamar['id_kamar'], ['id' => 'formeditkamar', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_kamar">ID Kamar</label>
                                    <input type="text" id="id_kamar" name="id_kamar" class="form-control" value="<?= $kamar['id_kamar'] ?>" readonly>
                                    <div class="invalid-feedback error_id_kamar"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="nama">Nama Kamar</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $kamar['nama'] ?>">
                                    <div class="invalid-feedback error_nama"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" id="harga" name="harga" class="form-control" value="Rp. <?= number_format($kamar['harga'], 0, ',', '.') ?>">
                                    <div class="invalid-feedback error_harga"></div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status_kamar">Status</label>
                                    <select id="status_kamar" name="status_kamar" class="form-control">
                                        <option value="tersedia" <?= $kamar['status_kamar'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                        <option value="terisi" <?= $kamar['status_kamar'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                                    </select>
                                    <div class="invalid-feedback error_status_kamar"></div>
                                </div>
                                <div class="form-group">
                                    <label for="dp">Nominal DP</label>
                                    <input type="text" id="dp" name="dp" class="form-control" value="Rp. <?= number_format($kamar['dp'], 0, ',', '.') ?>">
                                    <div class="invalid-feedback error_dp"></div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="8"><?= $kamar['deskripsi'] ?></textarea>
                                    <div class="invalid-feedback error_deskripsi"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header text-center">
                                <h5 class="m-0">Foto Kamar</h5>
                            </div>
                            <div class="card-body text-center">
                                <?php
                                $cover = !empty($kamar['cover']) ? $kamar['cover'] : '';
                                $imageSource = '';
                                
                                // Cek apakah ada file cover
                                if (!empty($cover)) {
                                    $imageSource = base_url('assets/img/kamar/' . $cover);
                                } else {
                                    $imageSource = base_url('assets/img/kamar/kamar.png');
                                }
                                ?>
                                <img id="coverPreview" src="<?= $imageSource ?>" alt="Preview Cover" class="img-fluid mb-3" 
                                     style="max-width: 100%; max-height: 200px; object-fit: contain;">
                                
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="cover" name="cover" accept="image/*"
                                        onchange="previewCover()">
                                    <label class="custom-file-label" for="cover">
                                        <?= !empty($cover) ? $cover : 'Pilih foto' ?>
                                    </label>
                                    <div class="invalid-feedback error_cover"></div>
                                </div>
                                <small class="form-text text-muted mt-2">Klik untuk memilih foto baru</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary" id="tombolSimpan">
                            <i class="fas fa-save"></i> SIMPAN
                        </button>
                        <a class="btn btn-secondary ml-2" href="<?= base_url('kamar') ?>">
                            <i class="fas fa-arrow-left"></i> KEMBALI
                        </a>
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
        // Format currency function
        function formatRupiah(value) {
            const number = parseInt(value.replace(/[^0-9]/g, ''), 10);
            if (isNaN(number)) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        // Remove currency format to get plain number
        function removeCurrencyFormat(value) {
            return value.replace(/[^0-9]/g, '');
        }

        // Format currency on input
        $('#harga, #dp').on('input', function() {
            const input = $(this);
            const value = input.val();
            const formatted = formatRupiah(value);
            input.val(formatted);
        });

        $('#formeditkamar').submit(function(e) {
            e.preventDefault();
            
            // Convert currency format back to plain numbers before submitting
            const hargaPlain = removeCurrencyFormat($('#harga').val());
            const dpPlain = removeCurrencyFormat($('#dp').val());
            
            // Create new FormData and set plain numbers
            let formData = new FormData(this);
            formData.set('harga', hargaPlain);
            formData.set('dp', dpPlain);

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

                        if (err.dp) {
                            $('#dp').addClass('is-invalid');
                            $('.error_dp').html(err.dp);
                        } else {
                            $('#dp').removeClass('is-invalid').addClass('is-valid');
                            $('.error_dp').html('');
                        }
                        
                        if (err.error_cover) {
                            $('#cover').addClass('is-invalid').removeClass('is-valid');
                            $('.error_cover').html(err.error_cover);
                        } else {
                            $('#cover').removeClass('is-invalid').addClass('is-valid');
                            $('.error_cover').html('');
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