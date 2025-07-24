<div class="row">
    <div class="col-md-4">
        <div class="card shadow-lg h-100">
            <div class="card-body p-0 d-flex justify-content-center align-items-center" style="overflow: hidden; border-radius: 10px;">
                <i class="fas fa-money-bill-wave fa-5x text-secondary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-lg h-100">
            <div class="card-header bg-teal text-white">
                <h5 class="mb-0"><i class="fas fa-receipt mr-2"></i> Informasi Pengeluaran</h5>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">ID Pengeluaran</div>
                    <div class="col-md-8"><?= esc($pengeluaran['id']) ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Tanggal</div>
                    <div class="col-md-8"><?= date('d-m-Y', strtotime($pengeluaran['tgl'])) ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Keterangan</div>
                    <div class="col-md-8"><?= esc($pengeluaran['keterangan']) ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Total</div>
                    <div class="col-md-8">Rp <?= number_format($pengeluaran['total'], 0, ',', '.') ?></div>
                </div>

            </div>
        </div>
    </div>
</div>