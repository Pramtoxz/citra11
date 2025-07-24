<div class="row">
    <div class="col-md-4">
        <div class="card shadow-lg h-100">
            <div class="card-body p-0 d-flex justify-content-center align-items-center" style="overflow: hidden; border-radius: 10px;">
                <i class="fas fa-bed fa-5x text-secondary"></i>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-lg h-100">
            <div class="card-header bg-teal text-white">
                <h5 class="mb-0"><i class="fas fa-door-open mr-2"></i> Informasi Kamar</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">ID Kamar</div>
                    <div class="col-md-8"><?= esc($kamar['id_kamar']) ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nama Kamar</div>
                    <div class="col-md-8"><?= esc($kamar['nama']) ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Harga / Malam</div>
                    <div class="col-md-8">Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Status</div>
                    <div class="col-md-8">
                        <?php
                        $status = $kamar['status_kamar'];
                        $badge = 'secondary';
                        if ($status == 'tersedia') $badge = 'success';
                        elseif ($status == 'terisi') $badge = 'danger';
                        elseif ($status == 'perbaikan') $badge = 'warning';
                        ?>
                        <span class="badge badge-<?= $badge ?> text-capitalize"><?= esc($status) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  