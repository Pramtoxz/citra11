<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-4">Detail Jenis Perawatan</h5>
        
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td width="30%" class="font-weight-bold">Kode Jenis</td>
                        <td width="5%">:</td>
                        <td><?= $jenis['idjenis'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nama Jenis</td>
                        <td>:</td>
                        <td><?= $jenis['namajenis'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Estimasi Waktu</td>
                        <td>:</td>
                        <td><?= $jenis['estimasi'] ?> menit</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Harga</td>
                        <td>:</td>
                        <td>Rp <?= number_format($jenis['harga'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Keterangan</td>
                        <td>:</td>
                        <td><?= !empty($jenis['keterangan']) ? $jenis['keterangan'] : '<em class="text-muted">Tidak ada keterangan</em>' ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Dibuat pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($jenis['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Diperbarui pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($jenis['updated_at'])) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>