<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="col-md-12">
    <div class="card card-teal">
        <div class="card-header">
            <h3 class="card-title">Laporan Barang</h3>
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
                        <b style="font-size: 20px; font-family: 'Times New Roman'; margin-bottom: 0; text-decoration: underline;">Laporan Obat</b>
                    </div>
                </div>
                <div class="tabelAset">
                </div>

                <div style="display: flex;
            justify-content: space-between;
            margin-top: 20px;">
                    <div></div>
                    <?php $tanggal = date('Y-m-d'); ?>
                    <div style="text-align: center;">
                        <p style="font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Padang <?= $tanggal ?></p>
                        <p style="margin-top: 5rem; font-size: 18px; font-family: 'Times New Roman'; margin-bottom: 0;">Klik Promedico</p>
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
            url: "<?= base_url('laporan-obat/view') ?>",
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.tabelAset').html(response.data);
                }
            }
        });
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