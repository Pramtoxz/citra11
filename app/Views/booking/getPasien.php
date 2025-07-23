<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelPasien">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pasien</th>
                <th>Nama Pasien</th>
                <th>Jenkel</th>
                <th>Tgl Lahir</th>
                <th>No HP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelPasien').DataTable({
    processing: true,
    serverSide: true,
    ajax: '<?= site_url("booking/viewGetPasien") ?>',
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
    $(document).on('click', '.btn-pilihpasien', function() {
        var id_pasien = $(this).data('id_pasien');
        var nama_pasien = $(this).data('nama_pasien');
        
        $('#idpasien').val(id_pasien);
        $('#namapasien').val(nama_pasien);

        $('#modalPasien').modal('hide');
    });
});
</script>y