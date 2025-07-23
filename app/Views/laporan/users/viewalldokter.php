<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>ID Dokter</th>
        <th>Nama Dokter</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Jenkel</th>
        <th>Tanggal Lahir</th>
        <th>Email</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($dokter as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['id_dokter'] ?></td>
        <td><?= $value['nama'] ?></td>
        <td><?= $value['alamat'] ?></td>
        <td><?= $value['nohp'] ?></td>
        <td>
            <?php
                if ($value['jenkel'] == 'L') {
                    echo 'Laki-laki';
                } elseif ($value['jenkel'] == 'P') {
                    echo 'Perempuan';
                } else {
                    echo $value['jenkel'];
                }
            ?>
        </td>
        <td><?= $value['tgllahir'] ?></td>
        <td>
            <?= ($value['email'] !== null) ? $value['email'] : 'Belum memiliki Akun' ?>
        </td>
    </tr>
    <?php
    } ?>
</table>