<div class="table-responsive">
    <table id="tabel-jadwal" class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID Jadwal</th>
                <th>Dokter</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($jadwal) && is_array($jadwal)): ?>
                <?php foreach ($jadwal as $row): ?>
                <tr>
                    <td><?= $row['idjadwal']; ?></td>
                    <td><?= $row['nama_dokter']; ?></td>
                    <td><?= $row['hari']; ?></td>
                    <td><?= substr($row['waktu_mulai'], 0, 5); ?> - <?= substr($row['waktu_selesai'], 0, 5); ?></td>
                    <td>
                        <?php if($row['is_active'] == 1): ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Tidak Aktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['is_active'] == 1): ?>
                            <button type="button" class="btn btn-sm btn-primary btn-pilihjadwal" 
                                    data-idjadwal="<?= $row['idjadwal']; ?>" 
                                    data-nama_dokter="<?= $row['nama_dokter']; ?>"
                                    data-hari="<?= $row['hari']; ?>"
                                    data-waktu="<?= substr($row['waktu_mulai'], 0, 5); ?> - <?= substr($row['waktu_selesai'], 0, 5); ?>">
                                <i class="fas fa-check-circle"></i> Pilih
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-sm btn-secondary" disabled>
                                <i class="fas fa-ban"></i> Tidak Tersedia
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data jadwal</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(function() {
    $('#tabel-jadwal').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 5,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ditemukan jadwal yang tersedia",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(disaring dari total _MAX_ data)"
        }
    });
});
</script> 