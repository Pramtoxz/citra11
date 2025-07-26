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
        <th>Tanggal Check</th>
        <th>ID Checkin</th>
        <th>ID Booking</th>
        <th>Nama Tamu</th>
        <th>Kode Kamar</th>
        <th>Tipe Bayar</th>
        <th>Total Reservasi</th>
        <th>Sisa Bayar</th>
        <th>Deposit</th>
        <th>Total</th>
    </tr>
    <?php $no = 1; ?>
    <?php $grandTotal = 0; ?>
    <?php foreach ($checkin as $key => $value) { 
        // Calculate lama menginap untuk menentukan total harga kamar
        $checkinDate = new DateTime($value['tglcheckin']);
        $checkoutDate = new DateTime($value['tglcheckin']);
        $checkoutDate->modify('+1 day'); // Default 1 malam jika tidak ada data checkout
        $lamaMenginap = 1; // Default untuk checkin
        
        // Hitung total harga kamar
        $totalHargaKamar = $lamaMenginap * $value['harga'];
        
        // Determine tipe pembayaran (DP atau Lunas)
        $tipePembayaran = ($value['totalbayar'] >= $totalHargaKamar) ? 'Lunas' : 'DP';
        
        // Calculate total = sisa bayar + deposit (tidak termasuk total reservasi)
        $total = $value['sisabayar'] + $value['deposit'];
        
        // Add to grand total
        $grandTotal += $total;
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= date('d M Y', strtotime($value['tanggal_checkin'])) ?></td>
        <td><?= $value['idcheckin'] ?></td>
        <td><?= $value['idbooking'] ?></td>
        <td><?= $value['nama_tamu'] ?></td>
        <td><?= $value['kode_kamar'] ?></td>
        <td><?= $tipePembayaran ?></td>
        <td>Rp <?= number_format($value['totalbayar'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($value['sisabayar'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($value['deposit'], 0, ',', '.') ?></td>
        <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    
    <?php if (!empty($checkin)): ?>
    <tr style="background-color: #f8f9fa; font-weight: bold;">
        <td colspan="10" class="text-right">Total Pendapatan:</td>
        <td>Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
    </tr>
    <?php endif; ?>
</table>

<?php if (empty($checkin)): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Tidak ada data checkin pada periode yang dipilih.
    </div>
<?php endif; ?>