<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-4">Detail Obat</h5>
        
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td width="30%" class="font-weight-bold">Kode Obat</td>
                        <td width="5%">:</td>
                        <td><?= $obat['idobat'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Nama Obat</td>
                        <td>:</td>
                        <td><?= $obat['nama'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Stok</td>
                        <td>:</td>
                        <td><?= $obat['stok'] ?> unit</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Jenis</td>
                        <td>:</td>
                        <td><?= $obat['jenis'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Keterangan</td>
                        <td>:</td>
                        <td><?= !empty($obat['keterangan']) ? $obat['keterangan'] : '<em class="text-muted">Tidak ada keterangan</em>' ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Dibuat pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($obat['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Diperbarui pada</td>
                        <td>:</td>
                        <td><?= date('d F Y H:i', strtotime($obat['updated_at'])) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div> 