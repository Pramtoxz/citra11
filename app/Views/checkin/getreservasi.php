<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover" id="tabelReservasi">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Reservasi</th>
                <th>Tanggal Checkin</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Harga Kamar</th>
                <th>Total Bayar</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelReservasi').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/checkin/viewgetreservasi',
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
        scrollX: true
    });

    $(document).ready(function() {
        // Event listener untuk tombol pilih reservasi
        $(document).on('click', '.btn-pilihcheckin', function() {
            var idbooking = $(this).data('idbooking');
            var kode_reservasi = $(this).data('kode_reservasi');
            var nama_tamu = $(this).data('nama_tamu');
            var nik = $(this).data('nik');
            var nohp = $(this).data('nohp');
            var nama_kamar = $(this).data('nama_kamar');
            var tglcheckin = $(this).data('tglcheckin');
            var tglcheckout = $(this).data('tglcheckout');
            var totalbayar = $(this).data('totalbayar');
            var tipe = $(this).data('tipe');
            var harga_kamar = $(this).data('harga_kamar');
            var cover = $(this).data('cover');
            var lama_hari = $(this).data('lama_hari');
            
            // Trigger event ke parent window
            $(document).trigger('checkinSelected', {
                idbooking: idbooking,
                kode_reservasi: kode_reservasi,
                nama_tamu: nama_tamu,
                nik: nik,
                nohp: nohp,
                nama_kamar: nama_kamar,
                tglcheckin: tglcheckin,
                tglcheckout: tglcheckout,
                totalbayar: totalbayar,
                tipe: tipe,
                harga_kamar: harga_kamar,
                cover: cover,
                lama_hari: lama_hari
            });
        });
    });
</script>