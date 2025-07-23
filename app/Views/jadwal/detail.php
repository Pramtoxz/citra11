<div class="row">
    <div class="col-md-12">
        <div class="card card-teal">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">ID Jadwal</div>
                    <div class="col-md-8"><?= $jadwal['idjadwal'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Kode Jadwal</div>
                    <div class="col-md-8"><?= $jadwal['idjadwal'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Dokter</div>
                    <div class="col-md-8"><?= $dokter['nama'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Hari</div>
                    <div class="col-md-8">
                        <span class="badge badge-primary"><?= $jadwal['hari'] ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Waktu Mulai</div>
                    <div class="col-md-8"><i class="fas fa-clock mr-1"></i> <?= $jadwal['waktu_mulai'] ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">Waktu Selesai</div>
                    <div class="col-md-8"><i class="fas fa-clock mr-1"></i> <?= $jadwal['waktu_selesai'] ?></div>
                </div>
                <div class="row">
                    <div class="col-md-4 font-weight-bold">Status</div>
                    <div class="col-md-8">
                        <span class="badge <?= $jadwal['is_active'] ? 'badge-success' : 'badge-danger' ?>">
                            <?= $jadwal['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>