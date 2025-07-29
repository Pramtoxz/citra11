<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('checkin/updateCheckin', ['id' => 'formcheckin']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idcheckin">ID Checkin</label>
                            <input type="text" id="idcheckin" name="idcheckin" class="form-control" value="<?= $checkin['idcheckin'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idbooking">Reservasi</label>
                            <div class="input-group">
                                <input type="hidden" id="idbooking" name="idbooking" class="form-control" value="<?= $checkin['idbooking'] ?>" readonly>
                                <input type="text" id="kode_reservasi" name="kode_reservasi" class="form-control" value="<?= $checkin['idbooking'] ?>" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-secondary text-white">Terkunci</span>
                                </div>
                                <div class="invalid-feedback error_idbooking"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Detail Reservasi yang Dipilih -->
                <div class="row" id="detailReservasi">
                    <div class="col-md-8">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Reservasi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Nama Tamu</th>
                                                    <td id="display_nama_tamu"><?= $checkin['nama_tamu'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td id="display_nik"><?= $checkin['nik'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No HP</th>
                                                    <td id="display_nohp"><?= $checkin['nohp'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Kamar</th>
                                                    <td id="display_nama_kamar"><?= $checkin['nama_kamar'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Per Malam</th>
                                                    <td id="display_harga_kamar"><?= number_format($checkin['harga_kamar'], 0, ',', '.') ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Tanggal Checkin</th>
                                                    <td id="display_tglcheckin"><?= date('d-m-Y', strtotime($checkin['tglcheckin'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Checkout</th>
                                                    <td id="display_tglcheckout"><?= date('d-m-Y', strtotime($checkin['tglcheckout'])) ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lama Menginap</th>
                                                    <td id="display_lama_hari"><?= $checkin['lama_hari'] ?> malam</td>
                                                </tr>
                                                <tr>
                                                    <th>Total di Reservasi</th>
                                                    <td id="display_totalbayar"><?= number_format($checkin['totalbayar'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tipe Bayar</th>
                                                    <td id="display_tipe"><?= $checkin['tipe'] == 'cash' ? 'Cash' : 'Transfer' ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
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
                                <img id="kamarPreview" src="<?= base_url('assets/img/kamar/' . (!empty($checkin['cover']) ? $checkin['cover'] : 'kamar.png')) ?>" alt="Preview Kamar" class="img-fluid mb-3" style="max-width: 100%; max-height: 200px; object-fit: contain;">
                                <div id="noKamarSelected" class="text-center text-muted" style="display: none;">
                                    <p>Belum ada kamar dipilih</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Perhitungan Sisa Bayar -->
                <div class="row" id="perhitunganSisaBayar">
                    <div class="col-md-12">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-calculator"></i> Perhitungan Sisa Bayar</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Harga Per Malam</th>
                                                    <td id="calc_harga_per_malam"><?= number_format($checkin['harga_kamar'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lama Menginap</th>
                                                    <td id="calc_lama_hari"><?= $checkin['lama_hari'] ?> malam</td>
                                                </tr>
                                                <tr class="bg-light">
                                                    <th>Total Seharusnya</th>
                                                    <td id="calc_total_seharusnya" class="font-weight-bold"><?= number_format($checkin['harga_kamar'] * $checkin['lama_hari'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Sudah Dibayar di Reservasi</th>
                                                    <td id="calc_sudah_dibayar"><?= number_format($checkin['totalbayar'], 0, ',', '.') ?></td>
                                                </tr>
                                                <tr class="bg-warning">
                                                    <th>Sisa yang Harus Dibayar</th>
                                                    <td id="calc_sisa_bayar" class="font-weight-bold text-danger"><?= number_format($checkin['sisabayar'], 0, ',', '.') ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle"></i> Informasi</h6>
                                            <p class="mb-0">Sisa bayar dihitung otomatis berdasarkan:</p>
                                            <small>(Lama Hari × Harga) - Total Reservasi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Checkin -->
                <div class="row" id="formInputCheckin">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="sisabayar">Sisa Bayar <span class="text-danger">*</span></label>
                            <input type="text" id="sisabayar_display" class="form-control" value="Rp. <?= number_format($checkin['sisabayar'], 0, ',', '.') ?>" readonly style="background-color: #e9ecef;">
                            <input type="hidden" id="sisabayar" name="sisabayar" value="<?= $checkin['sisabayar'] ?>">
                            <small class="form-text text-muted">Sisa pembayaran yang harus dibayar saat checkin (dihitung otomatis)</small>
                            <div class="invalid-feedback error_sisabayar"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="deposit">Deposit <span class="text-danger">* (Wajib)</span></label>
                            <input type="text" id="deposit_display" class="form-control" value="Rp. <?= number_format($checkin['deposit'], 0, ',', '.') ?>">
                            <input type="hidden" id="deposit" name="deposit" value="<?= $checkin['deposit'] ?>">
                            <small class="form-text text-muted">Deposit keamanan kamar yang harus dibayar tamu (dapat diubah)</small>
                            <div class="invalid-feedback error_deposit"></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="total_bayar">Total yang Harus Dibayar <span class="text-success">*</span></label>
                            <input type="text" id="total_bayar_display" class="form-control" value="Rp. <?= number_format($checkin['sisabayar'] + $checkin['deposit'], 0, ',', '.') ?>" readonly style="background-color: #d4edda; color: #155724; font-weight: bold; font-size: 16px;">
                            <small class="form-text text-success"><strong>Sisa Bayar + Deposit = Total</strong></small>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-3" id="tombolSubmit">
                    <button type="submit" class="btn btn-success" id="tombolSimpan">
                        <i class="fas fa-save"></i> Update Checkin
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url() ?>checkin">Kembali</a>
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
            if (!value || value === '') return '';
            const cleanValue = value.toString().replace(/[^0-9]/g, '');
            if (cleanValue === '') return '';
            const number = parseInt(cleanValue, 10);
            if (isNaN(number) || number === 0) return '';
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        // Remove currency format to get plain number
        function removeCurrencyFormat(value) {
            return value.replace(/[^0-9]/g, '');
        }

        // Calculate total bayar real-time
        function calculateTotalBayar() {
            var sisaBayar = parseFloat($('#sisabayar').val()) || 0;
            var deposit = parseFloat($('#deposit').val()) || 0;
            var total = sisaBayar + deposit;
            
            if (total > 0) {
                $('#total_bayar_display').val('Rp. ' + total.toLocaleString('id-ID'));
            } else {
                $('#total_bayar_display').val('Rp. ' + sisaBayar.toLocaleString('id-ID'));
            }
        }

        // Format currency on input for deposit
        $('#deposit_display').on('input', function() {
            const input = $(this);
            const value = input.val();
            const formatted = formatRupiah(value);
            input.val(formatted);
            
            // Update hidden field with numeric value
            const numericValue = removeCurrencyFormat(value);
            $('#deposit').val(numericValue);
            
            // Update total bayar
            calculateTotalBayar();
        });
        
        $('#formcheckin').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idcheckin: $('#idcheckin').val(),
                    idbooking: $('#idbooking').val(),
                    sisabayar: $('#sisabayar').val(),
                    deposit: $('#deposit').val()
                },
              
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Proses Checkin');
                    $('#tombolSimpan').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_idbooking) {
                            $('#kode_reservasi').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idbooking').html(err.error_idbooking);
                        } else {
                            $('#kode_reservasi').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idbooking').html('');
                        }
                        if (err.error_sisabayar) {
                            $('#sisabayar').addClass('is-invalid').removeClass('is-valid');
                            $('.error_sisabayar').html(err.error_sisabayar);
                        } else {
                            $('#sisabayar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_sisabayar').html('');
                        }
                        if (err.error_deposit) {
                            $('#deposit').addClass('is-invalid').removeClass('is-valid');
                            $('.error_deposit').html(err.error_deposit);
                        } else {
                            $('#deposit').removeClass('is-invalid').addClass('is-valid');
                            $('.error_deposit').html('');
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.sukses,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/checkin/faktur/') ?>' + $('#idcheckin').val();
                        });
                    }
                },

                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan: ' + e.responseText
                    });
                }
            });

            return false;
        });

        // Form sudah terisi dengan data, tidak perlu event handler tambahan
    });
</script>
<?= $this->endSection() ?>