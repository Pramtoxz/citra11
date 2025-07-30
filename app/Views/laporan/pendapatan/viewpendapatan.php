<br><br>
<?php if (isset($tglmulai) && isset($tglakhir)): ?>
    <text>Dari : <text> <b><?= date('d F Y', strtotime($tglmulai)) ?></b> <text>Sampai : <text> <b><?= date('d F Y', strtotime($tglakhir)) ?></b>
<?php elseif (isset($tahun) && isset($isLaporanTahun)): ?>
    <text>Laporan Pendapatan Bersih Tahun : <text> <b><?= $tahun ?></b>
<?php endif; ?>
<br><br>

<?php if (isset($isLaporanTahun) && $isLaporanTahun): ?>
    <!-- Laporan Ringkasan Per Bulan -->
    <table class="table table-bordered" style="border: 1px solid;">
        <tr class="text-center">
            <th style="width: 15px;">No</th>
            <th>Bulan</th>
            <th>Total</th>
        </tr>
        <?php 
        $no = 1; 
        $grandTotalBersih = 0;
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        ?>
        <?php foreach ($pendapatanPerBulan as $key => $value) { ?>
        <?php $grandTotalBersih += $value['total_bersih_bulan']; ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= $namaBulan[$value['bulan']] ?></td>
            <td class="text-center"><?= 'Rp. ' . number_format($value['total_bersih_bulan'], 0, ',', '.') ?></td>
        </tr>
        <?php } ?>
        <?php if (!empty($pendapatanPerBulan)): ?>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="2" class="text-center"><strong>Grand Total Pendapatan:</strong></td>
            <td class="text-center"><strong>Rp. <?= number_format($grandTotalBersih, 0, ',', '.') ?></strong></td>
        </tr>
        <?php endif; ?>
    </table>

    <?php if (empty($pendapatanPerBulan)): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data pendapatan pada tahun <?= $tahun ?>.
        </div>
    <?php endif; ?>

<?php else: ?>
    <!-- Laporan Detail Per Tanggal -->
    <table class="table table-bordered" style="border: 1px solid;">
        <tr class="text-center">
            <th style="width: 15px;">No</th>
            <th>Tanggal</th>
            <th>Pendapatan Checkin (DP + Sisa Bayar)</th>
            <th>Pendapatan Checkout (Potongan)</th>
            <th>Total Bersih</th>
        </tr>
        <?php 
        $no = 1; 
        $grandTotalCheckin = 0;
        $grandTotalCheckout = 0;
        $grandTotalBersih = 0;
        ?>
        <?php foreach ($pendapatan as $key => $value) { 
            $grandTotalCheckin += $value['total_checkin'];
            $grandTotalCheckout += $value['total_checkout'];
            $grandTotalBersih += $value['total_bersih'];
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d M Y', strtotime($value['tanggal'])) ?></td>
            <td>Rp <?= number_format($value['total_checkin'], 0, ',', '.') ?></td>
            <td>Rp <?= number_format($value['total_checkout'], 0, ',', '.') ?></td>
            <td><strong>Rp <?= number_format($value['total_bersih'], 0, ',', '.') ?></strong></td>
        </tr>
        <?php } ?>
        
        <?php if (!empty($pendapatan)): ?>
        <tr style="background-color: #f8f9fa; font-weight: bold; border-top: 2px solid #000;">
            <td colspan="2" class="text-right"><strong>GRAND TOTAL:</strong></td>
            <td><strong>Rp <?= number_format($grandTotalCheckin, 0, ',', '.') ?></strong></td>
            <td><strong>Rp <?= number_format($grandTotalCheckout, 0, ',', '.') ?></strong></td>
            <td style="background-color: #d4edda;"><strong>Rp <?= number_format($grandTotalBersih, 0, ',', '.') ?></strong></td>
        </tr>
        <?php endif; ?>
    </table>

    <?php if (empty($pendapatan)): ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> Tidak ada data pendapatan pada periode yang dipilih.
        </div>
    <?php endif; ?>
<?php endif; ?>