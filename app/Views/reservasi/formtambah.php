<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('reservasi/save', ['id' => 'formreservasi']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="idbooking">ID Reservasi</label>
                            <input type="text" id="idbooking" name="idbooking" class="form-control" value="<?= $next_id ?>" readonly>
                        </div>
                    </div>
                    <!-- Tambahkan tombol debug untuk manipulasi tanggal -->
                    <!-- <?php if (ENVIRONMENT !== 'production'): ?>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="debug_date">Tanggal Debug</label>
                            <div class="input-group">
                                <input type="date" id="debug_date" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-warning" type="button" id="btnDebugDate">
                                        <i class="fas fa-sync"></i> Debug
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?> -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="nik">ID Tamu</label>
                            <div class="input-group">
                                <input type="text" id="nama_tamu" name="nama_tamu" class="form-control" placeholder="Pilih Tamu" readonly>
                                <input type="hidden" id="nik" name="nik" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariTamu" data-toggle="modal" data-target="#modalcariTamu">Cari</button>
                                </div>
                                <div class="invalid-feedback error_nama_tamu"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="tglcheckin">Tanggal Checkin</label>
                            <input type="date" id="tglcheckin" name="tglcheckin" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="tglcheckout">Tanggal Checkout</label>
                            <input type="date" id="tglcheckout" name="tglcheckout" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="lama">Lama Menginap</label>
                            <div class="input-group">
                                <input type="number" id="lama" name="lama" class="form-control" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">Malam</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="idkamar">Kamar</label>
                                    <div class="input-group">
                                        <input type="hidden" id="id_kamar" name="idkamar" class="form-control" readonly>
                                        <input type="text" id="nama_kamar" name="nama_kamar" class="form-control" placeholder="Pilih Kamar" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" id="btnModalKamar" data-toggle="modal" data-target="#modalKamar">Cari</button>
                                        </div>
                                        <div class="invalid-feedback error_nama_kamar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="harga">Harga Kamar</label>
                                    <input type="text" id="harga_display" name="harga_display" class="form-control" readonly placeholder="Rp. 0">
                                    <input type="hidden" id="harga" name="harga">
                                    <div class="invalid-feedback error_harga"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="dp">DP (Uang Muka)</label>
                                    <input type="text" id="dp_display" name="dp_display" class="form-control" readonly placeholder="Rp. 0">
                                    <input type="hidden" id="dp" name="dp">
                                    <div class="invalid-feedback error_dp"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipebayar">Tipe Bayar</label>
                                    <select name="tipebayar" id="tipebayar" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                    <div class="invalid-feedback error_tipebayar"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="is_dp">Gunakan DP?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_dp" name="is_dp">
                                        <label class="form-check-label" for="is_dp">
                                            Ya, gunakan DP
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <!-- <label for="totalbayar">Total Bayar</label> -->
                                    <input type="hidden" name="totalbayar" id="totalbayar" class="form-control" readonly>
                                    <div class="invalid-feedback error_totalbayar"></div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <!-- <label for="sisabayar">Sisa Bayar</label> -->
                                    <input type="hidden" name="sisabayar" id="sisabayar" class="form-control" readonly>
                                    <div class="invalid-feedback error_sisabayar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="card bg-light">
                            <div class="card-header text-center">
                                <h5 class="m-0">Foto Kamar</h5>
                            </div>
                            <div class="card-body text-center">
                                <img id="kamarPreview" src="<?= base_url('assets/img/kamar/index.html') ?>" alt="Preview Kamar" class="img-fluid mb-3" style="max-width: 100%; max-height: 200px; object-fit: contain;">
                                <div id="noKamarSelected" class="text-center text-muted">
                                    <p>Silakan pilih kamar terlebih dahulu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header" style="display: flex; justify-content: space-between;">
                                <h3 class="card-title" style="font-size: x-large; color: red;" id="displayTotal">Rp 0</h3>
                                <input type="hidden" id="grandtotal" name="grandtotal" value="0">
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Kamar</th>
                                            <td width="70%" id="summaryKamar">-</td>
                                        </tr>
                                        <tr>
                                            <th>Lama Menginap</th>
                                            <td id="summaryLama">-</td>
                                        </tr>
                                        <tr>
                                            <th>Harga Per Malam</th>
                                            <td id="summaryHarga">-</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th>Total Biaya Kamar</th>
                                            <td id="summaryTotal" class="font-weight-bold" style="color: green;">-</td>
                                        </tr>
                                        <tr>
                                            <th>DP (jika digunakan)</th>
                                            <td id="summaryDP">-</td>
                                        </tr>
                                        <tr>
                                            <th>Sisa Bayar (saat check-in)</th>
                                            <td id="summarySisaBayar">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-3">
                    <button type="submit" class="btn btn-success" id="tombolSimpan">
                        <i class="fas fa-save"></i> Simpan Reservasi
                    </button>
                    <a class="btn btn-secondary" href="<?= base_url() ?>reservasi">Kembali</a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- modal cari Tamu -->
    <div class="modal fade" id="modalcariTamu" tabindex="-1" role="dialog" aria-labelledby="modalcariTamuLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcariTamuLabel">Pilih Tamu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "gettamu.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

     <!-- modal cari Kamar -->
     <div class="modal fade" id="modalKamar" tabindex="-1" role="dialog" aria-labelledby="modalKamarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKamarLabel">Pilih Kamar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getkamar.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        // Nonaktifkan tombol cari kamar secara default
        $('#btnModalKamar').prop('disabled', true);
        
        // Mengatur tanggal default untuk checkin dan checkout
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);
        
        // Format tanggal untuk atribut min
        var todayFormatted = today.toISOString().substr(0, 10);
        
        // Set nilai default dan min attribute untuk mencegah pemilihan tanggal di masa lalu
        $('#tglcheckin').val(todayFormatted);
        $('#tglcheckin').attr('min', todayFormatted);
        $('#tglcheckout').val(tomorrow.toISOString().substr(0, 10));
        $('#tglcheckout').attr('min', tomorrow.toISOString().substr(0, 10));
        hitungLamaMenginap();
        
        // Event untuk menghitung lama menginap saat tanggal berubah
        $('#tglcheckin').on('change', function() {
            var selectedDate = new Date($(this).val());
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Reset jam menjadi 00:00:00
            
            // Validasi tanggal tidak boleh di masa lalu
            if(selectedDate < currentDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal tidak valid',
                    text: 'Tanggal checkin tidak boleh kurang dari hari ini'
                });
                $(this).val(todayFormatted);
                return;
            }
            
            // Update minimum date untuk checkout agar selalu sehari setelah checkin
            var nextDay = new Date(selectedDate);
            nextDay.setDate(nextDay.getDate() + 1);
            var nextDayFormatted = nextDay.toISOString().substr(0, 10);
            $('#tglcheckout').attr('min', nextDayFormatted);
            
            // Jika checkout sebelum checkin+1, atur checkout ke checkin+1
            var checkoutDate = new Date($('#tglcheckout').val());
            if(checkoutDate <= selectedDate) {
                $('#tglcheckout').val(nextDayFormatted);
            }
            
            hitungLamaMenginap();
            updateTotalBayar();
            
            // Reset kamar yang dipilih jika tanggal berubah
            if ($('#id_kamar').val() !== '') {
                $('#id_kamar').val('');
                $('#nama_kamar').val('');
                $('#harga').val('');
                $('#harga_display').val('');
                $('#dp').val('');
                $('#dp_display').val('');
                $('#kamarPreview').attr('src', '<?= base_url('assets/img/kamar/index.html') ?>');
                $('#noKamarSelected').show();
                updateSummary();
            }
        });
        
        $('#tglcheckout').on('change', function() {
            var checkinDate = new Date($('#tglcheckin').val());
            var selectedDate = new Date($(this).val());
            
            // Validasi checkout harus setelah checkin
            if(selectedDate <= checkinDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal tidak valid',
                    text: 'Tanggal checkout harus setelah tanggal checkin'
                });
                var nextDay = new Date(checkinDate);
                nextDay.setDate(nextDay.getDate() + 1);
                $(this).val(nextDay.toISOString().substr(0, 10));
            }
            
            hitungLamaMenginap();
            updateTotalBayar();
            
            // Reset kamar yang dipilih jika tanggal berubah
            if ($('#id_kamar').val() !== '') {
                $('#id_kamar').val('');
                $('#nama_kamar').val('');
                $('#harga').val('');
                $('#harga_display').val('');
                $('#dp').val('');
                $('#dp_display').val('');
                $('#kamarPreview').attr('src', '<?= base_url('assets/img/kamar/index.html') ?>');
                $('#noKamarSelected').show();
                updateSummary();
            }
        });
        
        // Fungsi untuk menghitung lama menginap
        function hitungLamaMenginap() {
            var checkin = new Date($('#tglcheckin').val());
            var checkout = new Date($('#tglcheckout').val());
            
            // Validasi tanggal
            if(checkout <= checkin) {
                var nextDay = new Date(checkin);
                nextDay.setDate(checkin.getDate() + 1);
                $('#tglcheckout').val(nextDay.toISOString().substr(0, 10));
                checkout = nextDay;
            }
            
            // Hitung selisih hari
            var timeDiff = Math.abs(checkout.getTime() - checkin.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            $('#lama').val(diffDays);
            
            updateSummary();
        }
        
        // Cek status nik saat halaman dimuat
        checkReservasiSelection();
        
        // Fungsi untuk mengecek apakah data tamu sudah dipilih
        function checkReservasiSelection() {
            if($('#nik').val() !== '') {
                // Aktifkan tombol cari kamar jika tamu sudah dipilih
                $('#btnModalKamar').prop('disabled', false);
            } else {
                // Nonaktifkan tombol cari kamar jika tamu belum dipilih
                $('#btnModalKamar').prop('disabled', true);
            }
        }
        
        // Terapkan pengecekan setiap kali nik berubah
        $('#nik').on('change', function() {
            checkReservasiSelection();
        });
        
        // Juga periksa setelah modal tamu ditutup (karena mungkin ada pemilihan)
        $('#modalcariTamu').on('hidden.bs.modal', function() {
            checkReservasiSelection();
        });
        
        // Fungsi untuk menghitung total bayar
        function updateTotalBayar() {
            var harga = parseFloat($('#harga').val()) || 0;
            var lama = parseInt($('#lama').val()) || 0;
            var isDP = $('#is_dp').is(':checked');
            var dpValue = parseFloat($('#dp').val()) || 0;
            
            // Hitung total harga penuh
            var hargaFull = harga * lama;
            
            // Tentukan total yang dibayar berdasarkan apakah DP digunakan
            var total = isDP ? dpValue : hargaFull;
            
            // Hitung sisa yang harus dibayar saat check-in
            var sisaBayar = isDP ? (hargaFull - dpValue) : 0;
            
            // Update nilai input
            $('#totalbayar').val(total);
            $('#sisabayar').val(sisaBayar);
            $('#grandtotal').val(hargaFull);
            
            // Format untuk tampilan
            var formattedTotal = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(total);
            
            $('#displayTotal').text(formattedTotal);
            
            updateSummary();
        }
        
        // Event untuk checkbox DP
        $('#is_dp').on('change', function() {
            updateTotalBayar();
        });
        
        // Update summary setiap kali ada perubahan pada form
        function updateSummary() {
            var namaKamar = $('#nama_kamar').val() || '-';
            var lama = $('#lama').val() || '-';
            var harga = parseFloat($('#harga').val()) || 0;
            var isDP = $('#is_dp').is(':checked');
            var dpValue = parseFloat($('#dp').val()) || 0;
            var total = parseFloat($('#totalbayar').val()) || 0;
            var sisaBayar = parseFloat($('#sisabayar').val()) || 0;
            var hargaFull = harga * lama;
            
            // Format mata uang untuk harga dan total
            var formattedHarga = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(harga);
            
            var formattedDP = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(dpValue);
            
            var formattedTotal = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(hargaFull);
            
            var formattedSisaBayar = new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(sisaBayar);
            
            $('#summaryKamar').text(namaKamar);
            $('#summaryLama').text(lama + ' malam');
            $('#summaryHarga').text(formattedHarga);
            $('#summaryDP').text(isDP ? formattedDP + ' (digunakan)' : formattedDP + ' (tidak digunakan)');
            $('#summarySisaBayar').text(isDP ? formattedSisaBayar : 'Rp 0 (Bayar penuh)');
            $('#summaryTotal').text(formattedTotal);
        }
        
        $('#formreservasi').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idbooking: $('#idbooking').val(),
                    tglcheckin: $('#tglcheckin').val(),
                    tglcheckout: $('#tglcheckout').val(),
                    lama: $('#lama').val(),
                    tipebayar: $('#tipebayar').val(),
                    nik: $('#nik').val(),
                    harga: $('#harga').val(),
                    idkamar: $('#id_kamar').val(),
                    is_dp: $('#is_dp').is(':checked') ? 1 : 0,
                    dp: $('#dp').val(),
                    totalbayar: $('#totalbayar').val(),
                    sisabayar: $('#sisabayar').val()
                },
              
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

                        if (err.error_nama_tamu) {
                            $('#nama_tamu').addClass('is-invalid').removeClass('is-valid');
                            $('.error_nama_tamu').html(err.error_nama_tamu);
                        } else {
                            $('#nama_tamu').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nama_tamu').html('');
                        }
                        if (err.error_nama_kamar) {
                            $('#nama_kamar').addClass('is-invalid').removeClass('is-valid');
                            $('.error_nama_kamar').html(err.error_nama_kamar);
                        } else {
                            $('#nama_kamar').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nama_kamar').html('');
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
                        var idbooking = response.idbooking;
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data Reservasi Berhasil Disimpan',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href = '<?= site_url('/reservasi/detail/') ?>' + idbooking;
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

        $('#modalcariTamu').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/reservasi/gettamu', function(data) {
                $('#modalcariTamu .modal-body').html(data);
            });
        });

        $('#modalKamar').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);
            
            var tglcheckin = $('#tglcheckin').val();
            var tglcheckout = $('#tglcheckout').val();

            // Load data here from the server dengan parameter tanggal
            $.get('<?= base_url() ?>/reservasi/getkamar', { 
                tglcheckin: tglcheckin,
                tglcheckout: tglcheckout 
            }, function(data) {
                $('#modalKamar .modal-body').html(data);
            });
        });
        
        // Event saat kamar dipilih
        $(document).on('click', '.btn-pilihkamar', function() {
            var id_kamar = $(this).data('id_kamar');
            var nama_kamar = $(this).data('nama_kamar');
            var harga = $(this).data('harga');
            var dp = $(this).data('dp');
            var cover = $(this).data('cover');
            
            $('#id_kamar').val(id_kamar);
            $('#nama_kamar').val(nama_kamar);
            $('#harga').val(harga);
            $('#harga_display').val('Rp. ' + parseInt(harga).toLocaleString('id-ID'));
            $('#dp').val(dp);
            $('#dp_display').val('Rp. ' + parseInt(dp).toLocaleString('id-ID'));
            
            // Update gambar kamar
            if (cover && cover !== '') {
                $('#kamarPreview').attr('src', '<?= base_url('assets/img/kamar/') ?>' + cover);
                $('#noKamarSelected').hide();
            } else {
                $('#kamarPreview').attr('src', '<?= base_url('assets/img/kamar/kamar.png') ?>');
                $('#noKamarSelected').hide();
            }
            
            $('#modalKamar').modal('hide');
            
            // Hitung total bayar
            updateTotalBayar();
        });

        // Tombol debug yang sudah ada, update script-nya
        $('#btnDebugDate').on('click', function() {
            var debugDate = $('#debug_date').val();
            if (debugDate) {
                // Perbarui checkin dan checkout
                $('#tglcheckin').val(debugDate);
                $('#tglcheckin').attr('min', debugDate);
                var tomorrow = new Date(debugDate);
                tomorrow.setDate(tomorrow.getDate() + 1);
                $('#tglcheckout').val(tomorrow.toISOString().substr(0, 10));
                $('#tglcheckout').attr('min', tomorrow.toISOString().substr(0, 10));
                hitungLamaMenginap();
                updateTotalBayar();
                
                // Panggil API untuk mendapatkan ID baru berdasarkan tanggal debug
                $.ajax({
                    url: '<?= base_url() ?>/reservasi/debugNewId',
                    type: 'POST',
                    data: {
                        debug_date: debugDate
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // Tampilkan loading
                        Swal.fire({
                            title: 'Loading...',
                            text: 'Menyiapkan ID reservasi baru',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update ID booking
                            $('#idbooking').val(response.new_id);
                            
                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'ID Reservasi Diperbarui',
                                text: 'ID Reservasi telah diperbarui berdasarkan tanggal ' + response.debug_date + ': ' + response.new_id,
                                showConfirmButton: true
                            });
                        } else {
                            // Tampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error || 'Terjadi kesalahan saat memperbarui ID'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan: ' + error
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Debug',
                    text: 'Silakan pilih tanggal terlebih dahulu.'
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>