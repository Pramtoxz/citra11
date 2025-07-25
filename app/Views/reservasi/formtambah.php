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
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="nik">ID Tamu</label>
                            <div class="input-group">
                                <input type="text" id="nama_tamu" name="nama_tamu" class="form-control" readonly>
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
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="lama">Lama Menginap</label>
                            <input type="number" id="lama" name="lama" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idkamar">ID Kamar</label>
                            <div class="input-group">
                                <input type="hidden" id="id_kamar" name="idkamar" class="form-control" readonly>
                                <input type="text" id="nama_kamar" name="nama_kamar" class="form-control" readonly>
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
                            <input type="number" id="harga" name="harga" class="form-control" readonly>
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
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
                    <div class="col-sm-1" style="margin-top: 30px;">
                        <div class="form-group">
                            <button type="button" class="btn btn-success" id="addTemp">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn btn-success" id="tombolSimpan" style="margin-right: 1rem;">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a class="btn btn-secondary" href="<?= base_url() ?>reservasi">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= form_close() ?>

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
        
        $('#tglcheckin').val(today.toISOString().substr(0, 10));
        $('#tglcheckout').val(tomorrow.toISOString().substr(0, 10));
        hitungLamaMenginap();
        
        // Event untuk menghitung lama menginap saat tanggal berubah
        $('#tglcheckin, #tglcheckout').on('change', function() {
            hitungLamaMenginap();
        });
        
        // Fungsi untuk menghitung lama menginap
        function hitungLamaMenginap() {
            var checkin = new Date($('#tglcheckin').val());
            var checkout = new Date($('#tglcheckout').val());
            
            // Validasi tanggal
            if(checkout <= checkin) {
                alert('Tanggal checkout harus setelah tanggal checkin');
                var nextDay = new Date(checkin);
                nextDay.setDate(checkin.getDate() + 1);
                $('#tglcheckout').val(nextDay.toISOString().substr(0, 10));
                checkout = nextDay;
            }
            
            // Hitung selisih hari
            var timeDiff = Math.abs(checkout.getTime() - checkin.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            $('#lama').val(diffDays);
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
                        toastr.success('Data Berhasil Disimpan')
                        setTimeout(function() {
                            window.location.href = '<?= site_url('/reservasi/detail/') ?>' + idbooking;
                        }, 1500);
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
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

            // Load data here from the server
            $.get('<?= base_url() ?>/reservasi/getkamar', function(data) {
                $('#modalKamar .modal-body').html(data);
            });
        });
    });
</script>
<?= $this->endSection() ?>