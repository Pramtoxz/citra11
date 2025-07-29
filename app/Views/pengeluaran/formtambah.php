<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-maroon">
            <div class="card-header text-center">
                <h3 class="card-title">Tambah Data Pengeluaran</h3>
            </div>

            <div class="card-body">
                <?= form_open('pengeluaran/save', ['id' => 'formtambahpengeluaran', 'enctype' => 'multipart/form-data']) ?>
                <?= csrf_field() ?>
                
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <!-- <label for="id">ID Pengeluaran</label> -->
                            <input type="hidden" id="id" name="id" class="form-control" readonly>
                            <div class="invalid-feedback error_id"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="tgl">Tanggal</label>
                            <input type="date" id="tgl" name="tgl" class="form-control">
                            <div class="invalid-feedback error_tgl"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea type="text" id="keterangan" name="keterangan" class="form-control"></textarea>
                            <div class="invalid-feedback error_keterangan"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" id="total" name="total" class="form-control" placeholder="Rp. 0">
                            <div class="invalid-feedback error_total"></div>
                        </div>
                        
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary" id="tombolSimpan">
                                <i class="fas fa-save"></i> SIMPAN
                            </button>
                            <a class="btn btn-secondary ml-2" href="<?= base_url('pengeluaran') ?>">
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
        $('#total').on('input', function() {
            const input = $(this);
            const value = input.val();
            const formatted = formatRupiah(value);
            input.val(formatted);
        });

        $('#formtambahpengeluaran').submit(function(e) {
            e.preventDefault();
            
            // Convert currency format back to plain numbers before submitting
            const totalPlain = removeCurrencyFormat($('#total').val());
            
            // Create new FormData and set plain numbers
            let formData = new FormData(this);
            formData.set('total', totalPlain);

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
                    } else if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.href = "<?= site_url('pengeluaran') ?>";
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