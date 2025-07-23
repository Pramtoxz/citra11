<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('jadwal/formtambah') ?>" class="btn btn-danger">Tambah Jadwal</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelJadwal">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Jadwal</th>
                                    <th>Dokter</th>
                                    <th>Hari</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Status</th>
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
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 900px;">
        <div class="modal-content" style="background-color: #f8f9fa; border-radius: 15px; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="modal-header"
                style="background-color: #20C997; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="fas fa-calendar-alt mr-2"></i> Detail Jadwal
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4" id="detail-content" style="overflow-y: auto;">
                <!-- Detail Jadwal akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
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
    $('#tabelJadwal').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/jadwal/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
    });

    $(document).on('click', '.btn-delete', function() {
        var idjadwal = $(this).data('idjadwal');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus jadwal ini?',
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
                    url: "<?php echo site_url('jadwal/delete'); ?>",
                    data: {
                        idjadwal: idjadwal
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.sukses,
                                icon: 'success'
                            });
                            // Refresh DataTable
                            $('#tabelJadwal').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus jadwal',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus jadwal',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var idjadwal = $(this).data('idjadwal');
    window.location.href = "<?php echo site_url('jadwal/formedit/'); ?>" + idjadwal;
});

$(document).on('click', '.btn-detail', function() {
    var idjadwal = $(this).data('idjadwal');
    $.ajax({
        type: "GET",
        url: "<?= site_url('jadwal/detail/') ?>" + idjadwal,
        dataType: 'html',
        success: function(response) {
            $('#detail-content').html(response);
            document.getElementById('detailModal').classList.remove('hidden');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Gagal memuat detail jadwal');
        }
    });
});

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Tutup modal jika mengklik diluar modal
window.onclick = function(event) {
    var modal = document.getElementById('detailModal');
    if (event.target == modal) {
        modal.classList.add('hidden');
    }
}

// Toggle status jadwal
$(document).on('click', '.btn-toggle-status', function() {
    var idjadwal = $(this).data('idjadwal');
    var currentStatus = $(this).data('status');
    
    $.ajax({
        type: "POST",
        url: "<?= site_url('jadwal/toggleStatus') ?>",
        data: {
            idjadwal: idjadwal,
            status: currentStatus
        },
        dataType: 'json',
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.sukses,
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#tabelJadwal').DataTable().ajax.reload();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.error || 'Gagal mengubah status jadwal'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengubah status jadwal'
            });
            console.error(xhr.responseText);
        }
    });
});
</script>
<?= $this->endSection() ?>