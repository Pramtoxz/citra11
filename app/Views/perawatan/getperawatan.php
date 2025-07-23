<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelWedding">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Perawatan</th>
                <th>ID Booking</th>
                <th>Nama Pasien</th>
                <th>Tanggal</th>
                <th>Dokter</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelWedding').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/perawatan/viewgetperawatan',
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
        $(document).on('click', '.btn-pilihperawatan', function() {
            var idperawatan = $(this).data('idperawatan');
            var nama_pasien = $(this).data('nama_pasien');
            var tanggal = $(this).data('tanggal');
            var dokter = $(this).data('dokter');
            var resep = $(this).data('resep');
            var idbooking = $(this).data('idbooking');
            $('#idperawatan').val(idperawatan);
            $('#nama_pasien').val(nama_pasien);
            $('#tanggal').val(tanggal);
            $('#dokter').val(dokter);
            $('#resep').val(resep);
            $('#idbooking').val(idbooking);
            // $('#fasilitas').val(fasilitas); // Menambahkan input fasilitas ke dalam form
            $('#modalPerawatan').modal('hide').on('hidden.bs.modal', function () {
                $('#idperawatan').focus();
            });
        });
    });
</script>