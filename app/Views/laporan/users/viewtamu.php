<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>NIK Tamu</th>
        <th>Nama Tamu</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Jenis Kelamin</th>
        <th>Email</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($tamu as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['nik'] ?></td>
        <td><?= $value['nama'] ?></td>
        <td><?= $value['alamat'] ?></td>
        <td><?= $value['nohp'] ?></td>
        <td>
            <?php
                if ($value['jk'] == 'L') {
                    echo 'Laki-laki';
                } elseif ($value['jk'] == 'P') {
                    echo 'Perempuan';
                } else {
                    echo $value['jk'];
                }
            ?>
        </td>
        <td>
            <?= ($value['email'] !== null) ? $value['email'] : 'Tamu Belum Memiliki Akun' ?>
        </td>
    </tr>
    <?php
    } ?>
</table>