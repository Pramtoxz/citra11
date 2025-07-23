<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelDokter">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Dokter</th>
                <th>Nama Dokter</th>
                <th>Jenkel</th>
                <th>Tgl Lahir</th>
                <th>No HP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelDokter').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("jadwal/viewGetDokter") ?>',
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

$(document).ready(function() {
    $(document).on('click', '.btn-pilihdokter', function() {
        var id_dokter = $(this).data('id_dokter');
        var nama_dokter = $(this).data('nama_dokter');
        
        $('#iddokter').val(id_dokter);
        $('#namadokter').val(nama_dokter);

        $('#modalDokter').modal('hide');
    });
});
</script>