<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>ID Kamar</th>
        <th>Nama Kamar</th>
        <th>Harga</th>
        <th>DP</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($kamar as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['id_kamar'] ?></td>
        <td><?= $value['nama'] ?></td>
        <td><?= 'Rp. ' . number_format($value['harga'], 0, ',', '.') ?></td>
        <td><?= 'Rp. ' . number_format($value['dp'], 0, ',', '.') ?></td>
        </td>
    </tr>
    <?php
    } ?>
</table>