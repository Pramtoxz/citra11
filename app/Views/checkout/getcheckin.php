<style>
/* Table fixed layout untuk distribusi kolom yang merata */
#tabelCheckout {
    table-layout: fixed !important;
    width: 100% !important;
}

#tabelCheckout thead th {
    word-wrap: break-word;
    overflow: hidden;
    text-align: center;
    vertical-align: middle;
}

#tabelCheckout tbody td {
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
}

.dataTables_wrapper {
    width: 100% !important;
}

.dataTables_wrapper table {
    width: 100% !important;
}
</style>

<div class="table-responsive datatable-minimal mt-4">
    <table class="table table-hover table-striped" id="tabelCheckout" style="width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Checkin</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th>Tanggal Checkin</th>
                <th>Tanggal Checkout</th>
                <th class="no-short">Aksi</th>
            </tr>
        </thead>
    </table>
</div>
<script>
    $('#tabelCheckout').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/checkout/viewgetcheckin',
        info: true,
        ordering: true,
        paging: true,
        pageLength: 10,
        order: [
            [1, 'desc']
        ],
        autoWidth: false,
        scrollX: false,
        responsive: false,
        columnDefs: [
            { "width": "8%", "targets": 0, "className": "text-center" },    // No
            { "width": "20%", "targets": 1, "className": "text-center" },   // Kode Checkin
            { "width": "20%", "targets": 2, "className": "text-left" },     // Nama Tamu
            { "width": "15%", "targets": 3, "className": "text-center" },   // Kamar
            { "width": "15%", "targets": 4, "className": "text-center" },   // Tanggal Checkin
            { "width": "15%", "targets": 5, "className": "text-center" },   // Tanggal Checkout
            { "width": "7%", "targets": 6, "className": "text-center", "bSortable": false }  // Aksi
        ],
        language: {
            processing: "Memuat data...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data checkin yang tersedia untuk checkout",
            zeroRecords: "Tidak ditemukan data checkin yang sesuai"
        }
    });

    $(document).ready(function() {
        // Event listener untuk tombol pilih checkin
        $(document).on('click', '.btn-pilihcheckin', function() {
            var idcheckin = $(this).data('idcheckin');
            var idbooking = $(this).data('idbooking');
            var nama_tamu = $(this).data('nama_tamu');
            var nik = $(this).data('nik');
            var nohp = $(this).data('nohp');
            var nama_kamar = $(this).data('nama_kamar');
            var tglcheckin = $(this).data('tglcheckin');
            var tglcheckout = $(this).data('tglcheckout');
            var totalbayar = $(this).data('totalbayar');
            var sisabayar = $(this).data('sisabayar');
            var deposit = $(this).data('deposit');
            var harga_kamar = $(this).data('harga_kamar');
            var lama_hari = $(this).data('lama_hari');
            
            // Trigger event ke parent window
            $(document).trigger('checkinSelected', {
                idcheckin: idcheckin,
                idbooking: idbooking,
                nama_tamu: nama_tamu,
                nik: nik,
                nohp: nohp,
                nama_kamar: nama_kamar,
                tglcheckin: tglcheckin,
                tglcheckout: tglcheckout,
                totalbayar: totalbayar,
                sisabayar: sisabayar,
                deposit: deposit,
                harga_kamar: harga_kamar,
                lama_hari: lama_hari
            });
        });
    });
</script>