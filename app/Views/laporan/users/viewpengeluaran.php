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
        <th>Tanggal Pengeluaran</th>
        <th>Keterangan</th>
        <th>Total</th>
    </tr>
    <?php $no = 1; ?>
    <?php $grandTotalPengeluaran = 0; ?>
    <?php foreach ($pengeluaran as $key => $value) { ?>
    <?php $grandTotalPengeluaran += $value['total']; ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d F Y', strtotime($value['tgl'])) ?></td>
        <td><?= $value['keterangan'] ?></td>
        <td><?= 'Rp. ' . number_format($value['total'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    <?php if (!empty($pengeluaran)): ?>
    <tr style="background-color: #f8f9fa; font-weight: bold;">
        <td colspan="3" class="text-right"><strong>Grand Total Pengeluaran:</strong></td>
        <td><strong>Rp. <?= number_format($grandTotalPengeluaran, 0, ',', '.') ?></strong></td>
    </tr>
    <?php endif; ?>
</table>

<?php if (empty($pengeluaran)): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Tidak ada data pengeluaran pada periode yang dipilih.
    </div>
<?php endif; ?>