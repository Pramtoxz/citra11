<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="invoice p-3 mb-3" style="background-color: #f4f6f9; color: #333;">
    <!-- title row -->
    <div class="row">
        <div class="col-12 text-center">
            <h4>
                <i class="fas fa-tooth"></i> PROMEDICO DENTAL CARE
            </h4>
            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                <b style="font-size: 18px;">Faktur Obat Masuk #<?= $mainData['faktur'] ?></b><br>
                <small><strong>Tanggal Masuk: </strong>
                    <?= date('d F Y', strtotime($mainData['tglmasuk'])) ?>
                </small>
            </div>
        </div>
        <!-- /.col -->
    </div>
    
    <!-- info row -->
    <div class="row invoice-info mt-4">
        <div class="col-sm-6 invoice-col">
            <h5>Informasi Klinik:</h5>
            <address>
                <strong>Promedico Dental</strong><br>
                Jl. Maransi Aie Pacah Padang<br>
                Kota Padang, Sumatera Barat<br>
                Phone: 081234567890<br>
                Email: promedico@gmail.com
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
            <h5>Detail Faktur:</h5>
            <address>
                <strong>No. Faktur:</strong> <?= $mainData['faktur'] ?><br>
                <strong>Tanggal:</strong> <?= date('d F Y', strtotime($mainData['tglmasuk'])) ?><br>
                <strong>Total Quantity:</strong> <?= $mainData['total_qty'] ?> item
            </address>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    
    <!-- Obat yang masuk row -->
    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Obat</th>
                        <th>Nama Obat</th>
                        <th>Tanggal Expired</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; 
                    if (!empty($detailData)): 
                        foreach ($detailData as $obat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $obat['idobat'] ?></td>
                            <td><?= $obat['nama'] ?></td>
                            <td><?= date('d F Y', strtotime($obat['tglexpired'])) ?></td>
                            <td><?= $obat['qty'] ?></td>
                        </tr>
                        <?php endforeach; 
                    else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data detail</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total Quantity</th>
                        <th><?= $mainData['total_qty'] ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <!-- this row will not appear when printing -->
    <div class="row no-print mt-4">
        <div class="col-12">
            <a href="#" onclick="window.print();" class="btn btn-default">
                <i class="fas fa-print"></i> Cetak
            </a>
            <a href="<?= base_url() ?>/obatmasuk" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(function() {
        // JavaScript tambahan jika diperlukan
    });
</script>
<?= $this->endSection() ?>
