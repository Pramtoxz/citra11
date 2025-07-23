<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Kode Jadwal</th>
        <th>Nama Dokter</th>
        <th>Hari</th>
        <th>Jadwal</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($jadwal as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idjadwal'] ?></td>
        <td><?= $value['nama'] ?></td>
        <td><?= $value['hari'] ?></td>
        <td><?= substr($value['waktu_mulai'], 0, 5) ?> WIB - <?= substr($value['waktu_selesai'], 0, 5) ?> WIB</td>
    </tr>
    <?php
    } ?>
</table>