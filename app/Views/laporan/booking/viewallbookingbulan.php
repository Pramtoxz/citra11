<text>Bulan :</text> <b><?= $bulan ?></b>
<text>Tahun :</text> <b><?= $tahun ?></b>
<br><br>
<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>ID Booking</th>
        <th>Nama Pasien</th>
        <th>Tanggal</th>
        <th>Jam</th>
        <th>Dokter</th>
        <th>Jenis Perawatan</th>
        <th>Online</th>
        <th>status</th>
  <?php $no = 1; ?>
    <?php foreach ($booking as $key => $value) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idbooking'] ?></td>
        <td><?= $value['nama_pasien'] ?></td>
        <td><?= $value['tanggal'] ?></td>
        <td><?= substr($value['waktu_mulai'], 0, 5) ?> WIB - <?= substr($value['waktu_selesai'], 0, 5) ?> WIB</td>
        <td><?= $value['nama_dokter'] ?></td>
        <td><?= $value['namajenis'] ?></td>
        <td><?= $value['online'] == 1 ? 'Ya' : 'Tidak' ?></td>
        <td><?= $value['status'] ?></td>
    </tr>
    <?php
    } ?>
</table>