<br><br>
<?php if (isset($tglmulai) && isset($tglakhir)): ?>
    <text>Dari : <text> <b><?= date('d F Y', strtotime($tglmulai)) ?></b> <text>Sampai : <text> <b><?= date('d F Y', strtotime($tglakhir)) ?></b>
<?php elseif (isset($tahun) && isset($isLaporanTahun)): ?>
    <text>Laporan Pengeluaran Tahun : <text> <b><?= $tahun ?></b>
<?php endif; ?>
<br><br>

<?php if (isset($isLaporanTahun) && $isLaporanTahun): ?>
    <!-- Laporan Ringkasan Per Bulan -->
    <table class="table table-bordered" style="border: 1px solid;">
        <tr class="text-center">
            <th style="width: 15px;">No</th>
            <th>Bulan</th>
            <th>Jumlah</th>
        </tr>
        <?php 
        $no = 1; 
        $grandTotalPengeluaran = 0;
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        ?>
        <?php foreach ($pengeluaranPerBulan as $key => $value) { ?>
        <?php $grandTotalPengeluaran += $value['total_bulan']; ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= $namaBulan[$value['bulan']] ?></td>
            <td class="text-center"><?= 'Rp. ' . number_format($value['total_bulan'], 0, ',', '.') ?></td>
        </tr>
        <?php } ?>
        <?php if (!empty($pengeluaranPerBulan)): ?>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="2" class="text-center"><strong>Grand Total Pengeluaran:</strong></td>
            <td class="text-center"><strong>Rp. <?= number_format($grandTotalPengeluaran, 0, ',', '.') ?></strong></td>
        </tr>
        <?php endif; ?>
    </table>

    <?php if (empty($pengeluaranPerBulan)): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data pengeluaran pada tahun <?= $tahun ?>.
        </div>
    <?php endif; ?>

<?php else: ?>
    <!-- Laporan Detail Per Tanggal -->
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
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= date('d F Y', strtotime($value['tgl'])) ?></td>
            <td class="text-center"><?= $value['keterangan'] ?></td>
            <td class="text-center"><?= 'Rp. ' . number_format($value['total'], 0, ',', '.') ?></td>
        </tr>
        <?php } ?>
        <?php if (!empty($pengeluaran)): ?>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="3" class="text-center"><strong>Grand Total Pengeluaran:</strong></td>
            <td class="text-center"><strong>Rp. <?= number_format($grandTotalPengeluaran, 0, ',', '.') ?></strong></td>
        </tr>
        <?php endif; ?>
    </table>

    <?php if (empty($pengeluaran)): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data pengeluaran pada periode yang dipilih.
        </div>
    <?php endif; ?>
<?php endif; ?>