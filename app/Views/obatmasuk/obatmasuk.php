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
                        <a href="<?= site_url('obatmasuk/formtambah') ?>" class="btn btn-danger">
                            <span class="d-none d-md-inline">Tambah Data</span>
                            <span class="d-inline d-md-none"><i class="fas fa-plus"></i></span>
                        </a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="produkTabel" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Faktur</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Total Item</th>
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
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="height: 100%;">
        <div class="modal-content" style="height: 100%;">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Detail pelanggan akan dimuat melalui AJAX -->
            </div>

        </div>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        var table = $('#produkTabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'obatmasuk/view',
            info: true,
            ordering: true,
            paging: true,
            responsive: true, // Menambahkan opsi responsive
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }],
        });

        // Fungsi untuk membuat DataTable responsif ketika sidebar di-hide
        $('#sidebarToggle').on('click', function() {
            table.columns.adjust().responsive.recalc();
        });

        $(document).on('click', '.btn-delete', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
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
                        url: "<?php echo route_to('obatmasuk.delete'); ?>",
                        data: {
                            id: id
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
                                $('#produkTabel').DataTable().ajax.reload();
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

    $(document).on('click', '.btn-edit', function() {
        var faktur = $(this).data('faktur');
        window.location.href = "<?php echo site_url('obatmasuk/edit/'); ?>" + faktur;
    });

    $(document).on('click', '.btn-detail', function() {
        var faktur = $(this).data('faktur');
        window.location.href = "<?php echo site_url('obatmasuk/detail/'); ?>" + faktur;
    });
</script>
<?= $this->endSection() ?>

