<br><br>
<?php if (isset($tglmulai) && isset($tglakhir)): ?>
    <text>Dari : <text> <b><?= date('d F Y', strtotime($tglmulai)) ?></b> <text>Sampai : <text> <b><?= date('d F Y', strtotime($tglakhir)) ?></b>
<?php elseif (isset($bulanawal) && isset($bulanakhir)): ?>
    <text>Dari : <text> <b><?= date('F Y', strtotime($bulanawal . '-01')) ?></b> <text>Sampai : <text> <b><?= date('F Y', strtotime($bulanakhir . '-01')) ?></b>
<?php endif; ?>
<br><br>

<table class="table table-bordered" style="border: 1px solid;">
    <tr class="text-center">
        <th style="width: 15px;">No</th>
        <th>Tanggal Checkout</th>
        <th>ID Checkout</th>
        <th>ID Checkin</th>
        <th>Nama Tamu</th>
        <th>Kode Kamar</th>
        <th>Tanggal Checkin</th>
        <th>Deposit</th>
        <th>Potongan</th>
    </tr>
    <?php $no = 1; ?>
    <?php $grandTotalPotongan = 0; ?>
    <?php foreach ($checkout as $key => $value) { ?>
    <?php $grandTotalPotongan += $value['potongan']; ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d M Y H:i', strtotime($value['tglcheckout'])) ?></td>
        <td><?= $value['idcheckout'] ?></td>
        <td><?= $value['idcheckin'] ?></td>
        <td><?= $value['nama_tamu'] ?></td>
        <td><?= $value['kode_kamar'] ?></td>
        <td><?= date('d M Y', strtotime($value['tglcheckin'])) ?></td>
        <td>Rp <?= number_format($value['deposit'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($value['potongan'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    <?php if (!empty($checkout)): ?>
    <tr style="background-color: #f8f9fa; font-weight: bold;">
        <td colspan="8" class="text-right"><strong>Grand Total Potongan:</strong></td>
        <td><strong>Rp <?= number_format($grandTotalPotongan, 0, ',', '.') ?></strong></td>
    </tr>
    <?php endif; ?>
</table>

<?php if (empty($checkout)): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Tidak ada data checkout pada periode yang dipilih.
    </div>
<?php else: ?>

<?php endif; ?>