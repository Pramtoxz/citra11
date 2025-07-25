<div class="row">
    <div class="col-md-4">
        <div class="card shadow-lg h-100">
            <div class="card-body p-0 d-flex justify-content-center align-items-center" style="overflow: hidden; border-radius: 10px;">
                <i class="fas fa-user-circle fa-5x text-secondary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-lg h-100">
            <div class="card-header bg-maroon text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i> Informasi Tamu</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">ID Tamu</div>
                    <div class="col-md-8"><?= $tamu['nik'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nama Tamu</div>
                    <div class="col-md-8"><?= $tamu['nama'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Jenis Kelamin</div>
                    <div class="col-md-8">
                        <span class="badge <?= $tamu['jk'] == 'L' ? 'badge-primary' : 'badge-danger' ?>">
                            <?= $tamu['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Alamat</div>
                    <div class="col-md-8"><?= $tamu['alamat'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Nomor Handphone</div>
                    <div class="col-md-8"><i class="fas fa-phone-alt mr-1"></i> <?= $tamu['nohp'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>