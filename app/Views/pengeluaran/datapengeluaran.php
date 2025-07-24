<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-maroon">
                <div class="card-header">
                    <h5 class="card-title"><?= $title ?></h5>
                </div>
                <div class="card-body">
                    <div class="buttons">
                        <a href="<?= site_url('pengeluaran/formtambah') ?>" class="btn btn-danger">Tambah Pengeluaran</a>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelPengeluaran">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header bg-teal text-white">
                <h5 class="modal-title"><i class="fas fa-file-invoice-dollar mr-2"></i> Detail Pengeluaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Konten detail pengeluaran akan dimuat lewat AJAX -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        const table = $('#tabelPengeluaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('pengeluaran/viewPengeluaran') ?>",
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }]
        });

        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus pengeluaran ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("<?= site_url('pengeluaran/delete') ?>", {
                        id: id
                    }, function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    }, 'json').fail(function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error');
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            window.location.href = "<?= site_url('pengeluaran/formedit/') ?>" + id;
        });

        $(document).on('click', '.btn-detail', function() {
            const id = $(this).data('id');
            $.get("<?= site_url('pengeluaran/detail/') ?>" + id, function(response) {
                $('#detail-content').html(response);
                $('#detailModal').modal('show');
            }).fail(function(xhr) {
                console.error(xhr.responseText);
                Swal.fire('Gagal!', 'Tidak dapat memuat detail.', 'error');
            });
        });
    });
</script>
<?= $this->endSection() ?>