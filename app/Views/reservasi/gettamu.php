<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelWedding">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelWedding').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/reservasi/viewgettamu',
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
        // Menghapus atribut onclick dan menggunakan event listener jQuery
        $(document).on('click', '.btn-pilihtamu', function() {
            var nik = $(this).data('nik');
            var nama_tamu = $(this).data('nama_tamu');
            $('#nik').val(nik);
            $('#nama_tamu').val(nama_tamu);
            $('#modalcariTamu').modal('hide');
        });
    });
</script>