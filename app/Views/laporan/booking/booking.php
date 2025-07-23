<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="card card-teal">
        <div class="card-header">
            <h3 class="card-title">Laporan Booking</h3>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="col-10 input-group">
                            <span class="input-group-append">
                                <button class="btn btn-primary" onclick="ViewLaporanSemua()">View Laporan</button> <br>
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
                        <div>Bulan</div>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">--Bulan--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div>Tahun</div>
                        <div class="col-10 input-group">
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">Tahun</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                            </select>
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
                            <img src="<?= base_url() ?>/assets/img/promedicotp.png" alt="Logo Klik Promedico" style="height: 100px;">
                            <div style="text-align: center; margin-left: 60px;">
                                <p style="font-size: 28px; font-family: 'Times New Roman'; margin-bottom: 0;"><b>Klik Promedico</b></p>
                                <p style="font-size: 20px; font-family: 'Times New Roman'; margin-bottom: 0;">Kota Pariaman, Sumatera Barat</p>
                            </div>
                        </div>
                        <hr style="border: 2px solid black; width: 68rem;">
                        <b style="font-size: 20px; font-family: 'Times New Roman'; margin-bottom: 0; text-decoration: underline;">Laporan Obat Masuk</b>
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
                        <p style="font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Padang <?= $tanggal ?></p>
                        <p style="margin-top: 5rem; font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Klinik Promedico</p>
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
    function ViewLaporanSemua() {
        $.ajax({
            type: "get",
            url: "<?= base_url('laporan-transaksi/booking/view') ?>",
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.tabelObat').html(response.data);
                }
            }
        });
    }

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
                url: "<?= base_url('laporan-transaksi/booking/viewtanggal') ?>",
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
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        if (bulan == '') {
            toastr.error('Bulan Belum Dipilih !!!');
        } else if (tahun == '') {
            toastr.error('Tahun Belum Dipilih !!!');
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('laporan-transaksi/booking/viewbulan') ?>",
                data: {
                    bulan: bulan,
                    tahun: tahun,
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