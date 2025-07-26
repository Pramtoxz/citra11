<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelKamar">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kamar</th>
                <th>Nama Kamar</th>
                <th>Harga</th>
                <th>DP</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
$('#tabelKamar').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/reservasi/viewgetkamar',
        type: 'POST',
        data: function(d) {
            d.tglcheckin = '<?= isset($tglcheckin) ? $tglcheckin : "" ?>';
            d.tglcheckout = '<?= isset($tglcheckout) ? $tglcheckout : "" ?>';
        }
    },
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
        var cover = $(this).data('cover');
        
        $('#id_kamar').val(id_kamar);
        $('#nama_kamar').val(nama_kamar);
        $('#harga').val(harga);
        $('#dp').val(dp);
        
        // Menutup modal
        $('#modalKamar').modal('hide');
    });
});
</script>