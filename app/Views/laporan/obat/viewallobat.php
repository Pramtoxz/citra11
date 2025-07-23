<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Kode Obat</th>
        <th>Nama Obat</th>
        <th>Jumlah Obat</th>
        <th>Kategori</th>
    </tr>
    <?php $no = 1;
    $grandtotal = 0; ?>
    <?php foreach ($obat as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idobat'] ?></td>
        <td><?= $value['nama'] ?></td>
        <td><?= $value['stok'] ?></td>
        <td><?= $value['jenis'] ?></td>
    </tr>
    <?php
    } ?>
</table>