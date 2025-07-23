<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Faktur</th>
        <th>Tanggal Masuk</th>
        <th>Kode Obat</th>
        <th>Tanggal Expired</th>
        <th>Jumlah</th>
    </tr>
    <?php 
    $no = 1; 
    $prev_faktur = '';
    $prev_tanggal = '';
    $faktur_count = [];
    
    // Count rows per faktur and tanggal
    foreach ($obat as $item) {
        $faktur_tgl_key = $item['faktur'] . '_' . $item['tglmasuk'];
        if (!isset($faktur_count[$faktur_tgl_key])) {
            $faktur_count[$faktur_tgl_key] = 0;
        }
        $faktur_count[$faktur_tgl_key]++;
    }
    
    foreach ($obat as $key => $value) { 
        $current_faktur_tgl = $value['faktur'] . '_' . $value['tglmasuk'];
        $rowspan = $faktur_count[$current_faktur_tgl];
        $show_faktur = ($prev_faktur != $value['faktur'] || $prev_tanggal != $value['tglmasuk']);
    ?>
    <tr>
        <?php if ($show_faktur): ?>
        <td rowspan="<?= $rowspan ?>"><?= $no++ ?></td>
        <td rowspan="<?= $rowspan ?>"><?= $value['faktur'] ?></td>
        <td rowspan="<?= $rowspan ?>"><?= date('d-m-Y', strtotime($value['tglmasuk'])) ?></td>
        <?php endif; ?>
        <td><?= $value['idobat'] ?></td>
        <td><?= date('d-m-Y', strtotime($value['tglexpired'])) ?></td>
        <td><?= $value['qty'] ?></td>
    </tr>
    <?php 
        $prev_faktur = $value['faktur'];
        $prev_tanggal = $value['tglmasuk'];
    } 
    ?>
</table>