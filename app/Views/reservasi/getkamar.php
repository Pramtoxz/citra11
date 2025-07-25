<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelKamar">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kamar</th>
                <th>Nama Kamar</th>
                <th>Harga</th>
                <th>DP</th>
                <th>Status Kamar</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelKamar').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/reservasi/viewgetkamar',
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
    $(document).on('click', '.btn-pilihkamar', function() {
        var id_kamar = $(this).data('id_kamar');
        var nama_kamar = $(this).data('nama_kamar');
        var harga = $(this).data('harga');
        var dp = $(this).data('dp');
        $('#id_kamar').val(id_kamar);
        $('#nama_kamar').val(nama_kamar);
        $('#harga').val(harga);
        $('#dp').val(dp);
        $('#modalKamar').modal('hide');
    });
});
</script>