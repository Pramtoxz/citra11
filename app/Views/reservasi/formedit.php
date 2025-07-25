<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('perawatan/save', ['id' => 'formperawatan']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="idperawatan">ID Perawatan</label>
                            <div class="input-group">
                                <input type="text" id="idperawatan" name="idperawatan" class="form-control" value="<?= $perawatan['idperawatan'] ?>" readonly>
                                <input type="text" id="idbooking" name="idbooking" class="form-control" value="<?= $booking['idbooking'] ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="ModalPerawatan" data-toggle="modal" data-target="#modalPerawatan">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idperawatan"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="nama_pasien">Nama Pasien</label>
                            <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" value="<?= $bookingData['nama_pasien'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="text" id="tanggal" name="tanggal" class="form-control" value="<?= $perawatan['tanggal'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="dokter">Dokter</label>
                            <input type="text" id="dokter" name="dokter" class="form-control" value="<?= $bookingData['nama_dokter'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="resep">Resep</label>
                            <textarea id="resep" name="resep" class="form-control" rows="2" readonly><?= $perawatan['resep'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="namaobat">Nama Obat</label>
                            <div class="input-group">
                                <input type="hidden" id="idobat" name="idobat" class="form-control" readonly>
                                <input type="text" id="namaobat" name="namaobat" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="ModalObat" data-toggle="modal" data-target="#modalObat">Cari</button>
                                </div>
                                <div class="invalid-feedback error_namabarang"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" id="harga" name="harga" class="form-control" readonly>
                            <div class="invalid-feedback error_harga"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="hidden" id="stok" name="stok" class="form-control" readonly>
                            <input type="number" id="qty" name="qty" class="form-control" oninput="validateJumlah()">
                            <div class="invalid-feedback error_qty"></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="total">Total Harga</label>
                            <input type="number" id="total" name="total" class="form-control" readonly>
                            <div class="invalid-feedback error_total"></div>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header" style="display: flex; justify-content: space-between;">
                                <h3 class="card-title" style="font-size: x-large;" id="displayTotal">0</h3>
                                <input type="hidden" id="grandtotal" name="grandtotal" value="0">
                                <div style="margin-left: auto;">
                                    <button type="button" class="btn btn-danger btn-sm" id="clearAll">
                                        <i class="fas fa-trash"></i> Kosongkan Semua
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tempTabel" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Beli</th>
                                                <th>Qty</th>
                                                <th>Total Harga</th>
                                                <th class="no-short">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn btn-success" id="tombolSimpan" style="margin-right: 1rem;">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a class="btn btn-secondary" href="<?= base_url() ?>perawatan">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= form_close() ?>

    <!-- modal cari produk -->
    <div class="modal fade" id="modalPerawatan" tabindex="-1" role="dialog" aria-labelledby="modalPerawatanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPerawatanLabel">Pilih Perawatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getperawatan.php" -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

     <!-- modal cari supplier -->
     <div class="modal fade" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="modalObatLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalObatLabel">Pilih Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded here from "getuser.php" -->
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
        // Nonaktifkan tombol cari obat secara default
        $('#ModalObat').prop('disabled', true);
        
        // Cek status idperawatan saat halaman dimuat
        checkPerawatanSelection();
        
        // Fungsi untuk mengecek apakah data perawatan sudah dipilih
        function checkPerawatanSelection() {
            if($('#idperawatan').val() !== '') {
                // Aktifkan tombol cari obat jika perawatan sudah dipilih
                $('#ModalObat').prop('disabled', false);
            } else {
                // Nonaktifkan tombol cari obat jika perawatan belum dipilih
                $('#ModalObat').prop('disabled', true);
            }
        }
        
        // Terapkan pengecekan setiap kali idperawatan berubah
        $('#idperawatan').on('change', function() {
            checkPerawatanSelection();
        });
        
        // Juga periksa setelah modal perawatan ditutup (karena mungkin ada pemilihan)
        $('#modalPerawatan').on('hidden.bs.modal', function() {
            checkPerawatanSelection();
        });
        
        $('#formperawatan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    idperawatan: $('#idperawatan').val(),
                    grandtotal: $('#grandtotal').val(),
                    idbooking: $('#idbooking').val(),
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

                        if (err.error_idperawatan) {
                            $('#idperawatan').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idperawatan').html(err.error_idperawatan);
                        } else {
                            $('#idperawatan').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idperawatan').html('');
                        }
                       
                    }

                    if (response.sukses) {
                        var idperawatan = response.idperawatan;
                        toastr.success('Data Berhasil Disimpan')
                        setTimeout(function() {
                            window.location.href = '<?= site_url('/perawatan/detail/') ?>' + idperawatan;
                        }, 1500);
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });

            return false;
        });

        $('#modalPerawatan').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/perawatan/getperawatan', function(data) {
                $('#modalPerawatan .modal-body').html(data);
            });
        });

        $('#modalObat').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/perawatan/getobat', function(data) {
                $('#modalObat .modal-body').html(data);
            });
        });

        $('#qty').on('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault(); // Mencegah perilaku default dari tombol tab
                $('#addTemp').focus(); // Mengarahkan fokus ke tombol dengan class btn-success
            }
        });

        $('#qty').on('input', function() {
            var harga = $('#harga').val();
            var qty = $(this).val();
            var total = harga * qty;
            $('#total').val(total);
        });

        $('#addTemp').on('click', function() {

            $.ajax({
                type: "POST",
                url: '/perawatan/addtemp',
                data: {
                    idobat: $('#idobat').val(),
                    qty: $('#qty').val(),
                    total: $('#total').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('#addTemp').html('<i class="fas fa-spin fa-spinner"></i>');
                    $('#addTemp').prop('disabled', true);
                },

                complete: function() {
                    $('#addTemp').html('<i class="fas fa-plus"></i>');
                    $('#addTemp').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_idobat) {
                            $('#idobat').addClass('is-invalid').removeClass('is-valid');
                            $('.error_idobat').html(err.error_idobat);
                        } else {
                            $('#idobat').removeClass('is-invalid').addClass('is-valid');
                            $('.error_idobat').html('');
                        }


                        if (err.error_qty) {
                            $('#qty').addClass('is-invalid').removeClass('is-valid');
                            $('.error_qty').html(err.error_qty);
                        } else {
                            $('#qty').removeClass('is-invalid').addClass('is-valid');
                            $('.error_qty').html('');
                        }
                    }

                    if (response.sukses) {
                        $('#idobat').removeClass('is-invalid');
                        $('.error_idobat').html('');
                        $('#qty').removeClass('is-invalid');
                        $('.error_qty').html('');
                        $('#tempTabel').DataTable().ajax.reload();
                        $('#idobat').val('');
                        $('#qty').val('');
                        $('#total').val('');
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');

            $.ajax({
                type: "POST",
                url: "/perawatan/deletetemp/"+id,
               
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {

                        $('#tempTabel').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal menghapus data',
                        icon: 'error'
                    });
                }
            });

        });

        $(document).on('click', '#clearAll', function() {
            Swal.fire({
                title: 'Apakah Anda yakin ingin mengosongkan semua?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/perawatan/deletetempall",
                      
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#tempTabel').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus data',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });


    });

    $(document).ready(function() {
        var table = $('#tempTabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/perawatan/viewtemp',
            info: false,
            ordering: false,
            paging: false,
            searching: false,
            responsive: true, // Menambahkan opsi responsive
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }],
        });
        table.on('draw', function() {
            var total = 0;
            table.column(4, {
                search: 'applied'
            }).data().each(function(value, index) {
                total += parseFloat(value); // Pastikan bahwa kolom total adalah kolom ke-5 (index 4)
            });

            $('#displayTotal').text('Rp ' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')); // Menampilkan total di elemen dengan id 'displayTotal' dan format Rupiah
            $('#grandtotal').val(parseInt(total)); // Memperbarui nilai input grandtotal menjadi integer
        });
    });

    function validateJumlah() {
        var jumlah = document.getElementById('qty').value;
        var jumlahstok = document.getElementById('stok').value;
        var tombolAddTemp = document.getElementById('addTemp');
        
        if (parseInt(jumlah) > parseInt(jumlahstok)) {
            document.getElementById('qty').classList.add('is-invalid');
            document.querySelector('.error_qty').innerHTML = 'QTY tidak boleh melebihi Stok barang';
            tombolAddTemp.disabled = true;
        } else {
            document.getElementById('qty').classList.remove('is-invalid');
            document.querySelector('.error_qty').innerHTML = '';
            tombolAddTemp.disabled = false;
        }

        $('#modalObat').on('hidden.bs.modal', function () {
            document.getElementById('qty').classList.remove('is-invalid');
            document.querySelector('.error_qty').innerHTML = '';
            document.getElementById('qty').value = '';
            tombolAddTemp.disabled = false;
        });
    }
</script>
<?= $this->endSection() ?>