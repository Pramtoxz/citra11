<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Kode Jenis</th>
        <th>Nama Jenis</th>
        <th>Estimasi</th>
        <th>Harga</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($jenis as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idjenis'] ?></td>
        <td><?= $value['namajenis'] ?></td>
        <td><?= $value['estimasi'] ?>Menit</td>
        <td><?= 'Rp ' . number_format($value['harga'], 0, ',', '.') ?></td>
    </tr>
    <?php
    } ?>
</table>