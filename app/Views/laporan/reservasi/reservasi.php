<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="card card-maroon">
        <div class="card-header">
            <h3 class="card-title">Laporan Reservasi</h3>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="col-10 input-group">
                            <span class="input-group-append">
                                <button class="btn btn-success" onclick="PrintLaporan()"><i class="fas fa-print"></i>Print</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <div>Tanggal Awal</div>
                        <input class="form-control" type="date" id="tglmulai" name="tglmulai">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div>Tanggal Akhir</div>
                        <div class="col-10 input-group">
                            <input class="form-control" type="date" id="tglakhir" name="tglakhir">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="ViewLaporanTanggal()">View</button> <br>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <div>Dari Bulan</div>
                        <input class="form-control" type="month" id="bulanawal" name="bulanawal">
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div>Sampai Bulan</div>
                        <div class="col-10 input-group">
                            <input class="form-control" type="month" id="bulanakhir" name="bulanakhir">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="ViewLaporanPerbulan()">View</button> <br>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-sm-12" id="printHalaman">

                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px; margin-left: -150px;">
                            <img src="<?= base_url() ?>/assets/img/citra11.png" alt="Logo" style="height: 100px;">
                            <div style="text-align: center; margin-left: 60px;">
                                <p style="font-size: 28px; font-family: 'Times New Roman'; margin-bottom: 0;"><b>Wisma Citra Sabaleh</b></p>
                                <p style="font-size: 20px; font-family: 'Times New Roman'; margin-bottom: 0;">Jl. Kp. Jawa Dalam IV Jl. Kp. Jawa Dalam No.21, Kec. Padang Barat, Kota Padang, Sumatera Barat 52112</p>
                            </div>
                        </div>
                        <hr style="border: 2px solid black; width: 68rem;">
                        <b style="font-size: 20px; font-family: 'Times New Roman'; margin-bottom: 0; text-decoration: underline;">Laporan Reservasi</b>
                    </div>
                </div>
                <div class="tabelObat">

                </div>

                <div style="display: flex;
            justify-content: space-between;
            margin-top: 20px;">
                    <div></div>
                    <?php $tanggal = date('Y-m-d'); ?>
                    <div style="text-align: center;">
                        <p style="font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Padang, <?= $tanggal ?></p>
                        <p style="margin-top: 5rem; font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Wisma Citra Sabaleh</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>

<script>
    function ViewLaporanTanggal() {
        let tglmulai = $('#tglmulai').val();
        let tglakhir = $('#tglakhir').val();
        if (tglmulai == '') {
            toastr.error('Tanggal Awal Belum Dipilih !!!');
        } else if (tglakhir == '') {
            toastr.error('Tanggal Akhir Belum Dipilih !!!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('laporan-wisma/reservasi/viewallreservasitanggal') ?>",
                data: {
                    tglmulai: tglmulai,
                    tglakhir: tglakhir,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        $('.tabelObat').html(response.data);
                    }
                }
            });
        }
    }
    function ViewLaporanPerbulan() {
        let bulanawal = $('#bulanawal').val();
        let bulanakhir = $('#bulanakhir').val();
        if (bulanawal == '') {
            toastr.error('Dari Bulan Belum Dipilih !!!');
        } else if (bulanakhir == '') {
            toastr.error('Sampai Bulan Belum Dipilih !!!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('laporan-wisma/reservasi/viewallreservasibulan') ?>",
                data: {
                    bulanawal: bulanawal,
                    bulanakhir: bulanakhir,
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.data) {
                        $('.tabelObat').html(response.data);
                    }
                }
            });
        }
    }
    function PrintLaporan() {
        var printContent = document.getElementById('printHalaman');
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<?= $this->endSection() ?>