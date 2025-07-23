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
                        <a href="<?= site_url('perawatan/formtambah') ?>" class="btn btn-danger">Tambah Perawatan</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelPerawatan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Perawatan</th>
                                    <th>Pasien</th>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
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

<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelPerawatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/perawatan/view',
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
        var idperawatan = $(this).data('idperawatan');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus perawatan ini?',
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
                    url: "<?php echo site_url('perawatan/delete'); ?>",
                    data: {
                        idperawatan: idperawatan,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
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
                            $('#tabelPerawatan').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error || 'Gagal menghapus perawatan',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus perawatan',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var idperawatan = $(this).data('idperawatan');
    window.location.href = "<?php echo site_url('perawatan/formedit/'); ?>" + idperawatan;
});
$(document).on('click', '.btn-detail', function() {
    var idperawatan = $(this).data('idperawatan');
    window.location.href = "<?php echo site_url('perawatan/detail/'); ?>" + idperawatan;
});


</script>
<?= $this->endSection() ?>