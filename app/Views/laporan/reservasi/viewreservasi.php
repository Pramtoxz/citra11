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
        <th>ID Booking</th>
        <th>Tanggal Booking</th>
        <th>Nama Tamu</th>
        <th>Kode Kamar</th>
        <th>Harga Kamar</th>
        <th>Tanggal Checkin</th>
        <th>Tanggal Checkout</th>
        <th>Lama Inap</th>
        <th>Tipe Pembayaran</th>
        <th>Status Booking</th>
        <th>Total Bayar</th>
    </tr>
    <?php $no = 1; ?>
    <?php $grandTotal = 0; ?>
    <?php foreach ($reservasi as $key => $value) { 
        // Calculate lama menginap
        $checkin = new DateTime($value['tglcheckin']);
        $checkout = new DateTime($value['tglcheckout']);
        $interval = $checkin->diff($checkout);
        $lamaMenginap = $interval->days;
        
        // Determine tipe pembayaran (DP atau Lunas)
        $totalHarga = $lamaMenginap * $value['harga'];
        $tipePembayaran = ($value['totalbayar'] >= $totalHarga) ? 'Lunas' : 'DP';
        
        // Add to grand total
        $grandTotal += $value['totalbayar'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $value['idbooking'] ?></td>
        <td><?= date('d M Y', strtotime($value['tanggal_booking'])) ?></td>
        <td><?= $value['nama_tamu'] ?></td>
        <td><?= $value['kode_kamar'] ?></td>
        <td>Rp <?= number_format($value['harga'], 0, ',', '.') ?></td>
        <td><?= date('d M Y', strtotime($value['tglcheckin'])) ?></td>
        <td><?= date('d M Y', strtotime($value['tglcheckout'])) ?></td>
        <td><?= $lamaMenginap ?> malam</td>
        <td><?= $tipePembayaran ?></td>
        <td>
            <?php
            $statusClass = '';
            $statusText = '';
            switch($value['status']) {
                case 'diproses':
                    $statusClass = 'badge-warning';
                    $statusText = 'Diproses';
                    break;
                case 'diterima':
                    $statusClass = 'badge-success';
                    $statusText = 'Diterima';
                    break;
                case 'ditolak':
                    $statusClass = 'badge-danger';
                    $statusText = 'Ditolak';
                    break;
                case 'selesai':
                    $statusClass = 'badge-info';
                    $statusText = 'Selesai';
                    break;
                case 'checkin':
                    $statusClass = 'badge-primary';
                    $statusText = 'Check In';
                    break;
                case 'cancel':
                    $statusClass = 'badge-secondary';
                    $statusText = 'Dibatalkan';
                    break;
                default:
                    $statusClass = 'badge-dark';
                    $statusText = '-';
            }
            ?>
            <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
        </td>
        <td>Rp <?= number_format($value['totalbayar'], 0, ',', '.') ?></td>
    </tr>
    <?php } ?>
    
    <?php if (!empty($reservasi)): ?>
    <tr style="background-color: #f8f9fa; font-weight: bold;">
        <td colspan="11" class="text-right">Total Pendapatan:</td>
        <td>Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
    </tr>
    <?php endif; ?>
</table>

<?php if (empty($reservasi)): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> Tidak ada data reservasi pada periode yang dipilih.
    </div>
<?php endif; ?>