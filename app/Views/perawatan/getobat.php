<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelObat">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Obat</th>
                <th>Nama Obat</th>
                <th>Harga</th>
                <th>Stok</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelObat').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/perawatan/viewgetobat',
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
    $(document).on('click', '.btn-pilihobat', function() {
        var idobat = $(this).data('idobat');
        var nama = $(this).data('nama');
        var harga = $(this).data('harga');
        var stok = $(this).data('stok');
        $('#idobat').val(idobat);
        $('#namaobat').val(nama);
        $('#harga').val(harga);
        $('#stok').val(stok);
        $('#modalObat').modal('hide').on('hidden.bs.modal', function() {
            $('').focus();
        });
    });
});
</script>