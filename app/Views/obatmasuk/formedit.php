<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('obatmasuk/updatedata', ['id' => 'formobatmasuk']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="faktur">Faktur</label>
                            <input type="text" id="faktur" name="faktur" class="form-control" value="<?= $faktur ?>" readonly>
                            <div class="invalid-feedback error_faktur"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tglmasuk">Tanggal Masuk</label>
                            <div class="input-group">
                                <input type="date" id="tglmasuk" name="tglmasuk" class="form-control" value="<?= $tglmasuk ?>" readonly>
                                <div class="invalid-feedback error_tglmasuk"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idobat">Nama Obat</label>
                            <div class="input-group">
                                <input type="hidden" id="idobat" name="idobat" class="form-control" readonly>
                                <input type="text" id="namaobat" name="namaobat" class="form-control" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="button-addon2" data-toggle="modal" data-target="#modalObat">Cari</button>
                                </div>
                                <div class="invalid-feedback error_namaobat"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="tglexpired">Tanggal Expired</label>
                            <input type="date" id="tglexpired" name="tglexpired" class="form-control" >
                            <div class="invalid-feedback error_tglexpired"></div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" id="qty" name="qty" class="form-control">
                            <div class="invalid-feedback error_qty"></div>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tempTabel" style="width:100%">
                                    <div style="margin-left: auto;">
                                    <button type="button" class="btn btn-danger btn-sm" id="clearAll">
                                        <i class="fas fa-trash"></i> Kosongkan Semua
                                    </button>
                                </div>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>Tanggal Expired</th>
                                                <th>Qty</th>
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
                        <a class="btn btn-secondary" href="<?= base_url() ?>obatmasuk">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= form_close() ?>

    <!-- modal cari produk -->
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

     <!-- modal cari supplier -->
     <div class="modal fade" id="modalSupplier" tabindex="-1" role="dialog" aria-labelledby="modalSupplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupplierLabel">Pilih Supplier</h5>
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
        $('#formobatmasuk').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    faktur: $('#faktur').val(),
                    tglmasuk: $('#tglmasuk').val(),
                    idobat: $('#idobat').val(),
                    tglexpired: $('#tglexpired').val(),
                    qty: $('#qty').val(),
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

                        if (err.error_faktur) {
                            $('#faktur').addClass('is-invalid').removeClass('is-valid');
                            $('.error_faktur').html(err.error_faktur);
                        } else {
                            $('#faktur').removeClass('is-invalid').addClass('is-valid');
                            $('.error_faktur').html('');
                        }

                        if (err.error_tglmasuk) {
                            $('#tglmasuk').addClass('is-invalid').removeClass('is-valid');
                            $('.error_tglmasuk').html(err.error_tglmasuk);
                        } else {
                            $('#tglmasuk').removeClass('is-invalid').addClass('is-valid');
                            $('.error_tglmasuk').html('');
                        }
                        
                       
                        if (err.error_grandtotal) {
                            $('#grandtotal').addClass('is-invalid').removeClass('is-valid');
                            $('.error_grandtotal').html(err.error_grandtotal);
                        } else {
                            $('#grandtotal').removeClass('is-invalid').addClass('is-valid');
                            $('.error_grandtotal').html('');
                        }
                    }

                    if (response.sukses) {
                        var faktur = response.faktur;
                        toastr.success('Data Berhasil Disimpan')
                        setTimeout(function() {
                            window.location.href = '<?= site_url('/obatmasuk/detail/') ?>' + faktur;
                        }, 1500);
                    }
                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });

            return false;
        });

        $('#modalObat').on('show.bs.modal', function(e) {
            var loader = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
            $(this).find('.modal-body').html(loader);

            // Load data here from the server
            $.get('<?= base_url() ?>/obatmasuk/getobat', function(data) {
                $('#modalObat .modal-body').html(data);
            });
        });

        $('#qty').on('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault(); // Mencegah perilaku default dari tombol tab
                $('#addTemp').focus(); // Mengarahkan fokus ke tombol dengan class btn-success
            }
        });



        $('#addTemp').on('click', function() {

            $.ajax({
                type: "POST",
                url: '/obatmasuk/addtemp',
                data: {
                    idobat: $('#idobat').val(),
                    tglexpired: $('#tglexpired').val(),
                    qty: $('#qty').val(),
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

                        if (err.error_tglexpired) {
                            $('#tglexpired').addClass('is-invalid').removeClass('is-valid');
                            $('.error_tglexpired').html(err.error_tglexpired);
                        } else {
                            $('#tglexpired').removeClass('is-invalid').addClass('is-valid');
                            $('.error_tglexpired').html('');
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
                        $('#tglexpired').removeClass('is-invalid');
                        $('.error_tglexpired').html('');
                        $('#qty').removeClass('is-invalid');
                        $('.error_qty').html('');
                        $('#tempTabel').DataTable().ajax.reload();
                        $('#idobat').val('');
                        $('#tglexpired').val('');
                        $('#qty').val('');
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
                url: "<?php echo route_to('obatmasuk.deletetemp'); ?>",
                data: {
                    id: id
                },
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
                        url: "<?php echo route_to('obatmasuk.deletealltemp'); ?>",
                      
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
            ajax: '/obatmasuk/viewtemp',
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

           
        });
    });
</script>
<?= $this->endSection() ?>