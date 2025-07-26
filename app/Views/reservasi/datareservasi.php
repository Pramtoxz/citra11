<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-maroon">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('reservasi/formtambah') ?>" class="btn btn-danger">Tambah Reservasi</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelReservasi">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Reservasi</th>
                                    <th>Tanggal Checkin</th>
                                    <th>Tanggal Checkout</th>
                                    <th>Tamu</th>
                                    <th>Kamar</th>
                                    <th>Status Reservasi</th>
                                    <th class="no-short">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cek Bukti Bayar -->
<div class="modal fade" id="modalCekBukti" tabindex="-1" role="dialog" aria-labelledby="modalCekBuktiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalCekBuktiLabel">
                    <i class="fas fa-file-invoice mr-2"></i> Verifikasi Bukti Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bukti-content">
                <!-- Konten bukti pembayaran akan dimuat lewat AJAX -->
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-2">Memuat bukti pembayaran...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="button" class="btn btn-danger" id="btnTolakBukti" style="display: none;">
                    <i class="fas fa-times-circle"></i> Tolak Pembayaran
                </button>
                <button type="button" class="btn btn-success" id="btnTerimaBukti" style="display: none;">
                    <i class="fas fa-check-circle"></i> Terima Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    var dataTable = $('#tabelReservasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= site_url('reservasi/viewreservasi') ?>',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }]
    });

    $(document).on('click', '.btn-delete', function() {
        var idbooking = $(this).data('idbooking');
        var $button = $(this);

        // Validasi ID booking
        if (!idbooking) {
            Swal.fire({
                title: 'Error!',
                text: 'ID Booking tidak valid',
                icon: 'error'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus reservasi ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button untuk mencegah double click
                $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('reservasi/delete') ?>",
                    data: {
                        idbooking: idbooking,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    timeout: 10000,
                    success: function(response) {
                        if (response.sukses) {
                            // Refresh DataTable sebelum menampilkan alert
                            var table = $('#tabelReservasi').DataTable();
                            table.ajax.reload(function() {
                                // Tampilkan success message setelah reload
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.sukses,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }, false);
                            
                        } else if (response.error) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Response tidak valid dari server',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = 'Gagal menghapus reservasi';
                        
                        if (xhr.status === 0) {
                            errorMessage = 'Tidak ada koneksi ke server';
                        } else if (xhr.status === 404) {
                            errorMessage = 'Halaman tidak ditemukan (404)';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Kesalahan server internal (500)';
                        } else if (status === 'timeout') {
                            errorMessage = 'Request timeout. Coba lagi.';
                        } else if (status === 'parsererror') {
                            errorMessage = 'Error parsing response';
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function() {
                        // Re-enable button
                        $button.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                    }
                });
            }
        });
    });

    // Handle tombol cek bukti
    $(document).on('click', '.btn-cek-bukti', function() {
        var idbooking = $(this).data('idbooking');
        
        // Reset modal content
        $('#bukti-content').html(`
            <div class="text-center">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Memuat bukti pembayaran...</p>
            </div>
        `);
        $('#btnTolakBukti, #btnTerimaBukti').hide().removeData('idbooking');
        
        // Show modal
        $('#modalCekBukti').modal('show');
        
        // Load bukti pembayaran
        $.get("<?= site_url('reservasi/cekbukti/') ?>" + idbooking, function(response) {
            $('#bukti-content').html(response);
            
            // Show action buttons jika status masih diproses
            if (response.includes('data-status="diproses"')) {
                $('#btnTolakBukti, #btnTerimaBukti').show().data('idbooking', idbooking);
            }
        }).fail(function(xhr) {
            console.error(xhr.responseText);
            $('#bukti-content').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gagal memuat bukti pembayaran. Silakan coba lagi.
                </div>
            `);
        });
    });

    // Handle tombol terima bukti
    $(document).on('click', '#btnTerimaBukti', function() {
        var idbooking = $(this).data('idbooking');
        
        Swal.fire({
            title: 'Konfirmasi Verifikasi',
            text: 'Apakah Anda yakin ingin menerima bukti pembayaran ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Terima',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatusPembayaran(idbooking, 'diterima');
            }
        });
    });

    // Handle tombol tolak bukti
    $(document).on('click', '#btnTolakBukti', function() {
        var idbooking = $(this).data('idbooking');
        
        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak bukti pembayaran ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatusPembayaran(idbooking, 'ditolak');
            }
        });
    });

    // Function untuk update status pembayaran
    function updateStatusPembayaran(idbooking, status) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('reservasi/updatestatus') ?>",
            data: {
                idbooking: idbooking,
                status: status,
                <?= csrf_token() ?>: '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            beforeSend: function() {
                $('#btnTolakBukti, #btnTerimaBukti').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
            },
            success: function(response) {
                if (response.sukses) {
                    $('#modalCekBukti').modal('hide');
                    
                    var statusText = status === 'diterima' ? 'diterima' : 'ditolak';
                    var iconType = status === 'diterima' ? 'success' : 'info';
                    
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Bukti pembayaran telah ' + statusText,
                        icon: iconType
                    });
                    
                    // Refresh DataTable
                    $('#tabelReservasi').DataTable().ajax.reload();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error || 'Gagal memperbarui status',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memperbarui status pembayaran',
                    icon: 'error'
                });
            },
            complete: function() {
                $('#btnTolakBukti, #btnTerimaBukti').prop('disabled', false);
                $('#btnTerimaBukti').html('<i class="fas fa-check-circle"></i> Terima Pembayaran');
                $('#btnTolakBukti').html('<i class="fas fa-times-circle"></i> Tolak Pembayaran');
            }
        });
    }
});

$(document).on('click', '.btn-edit', function() {
    var idbooking = $(this).data('idbooking');
    window.location.href = "<?php echo site_url('reservasi/formedit/'); ?>" + idbooking;
});
$(document).on('click', '.btn-detail', function() {
    var idbooking = $(this).data('idbooking');
    window.location.href = "<?php echo site_url('reservasi/detail/'); ?>" + idbooking;
});
</script>
<?= $this->endSection() ?>