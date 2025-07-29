<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row" style="justify-content: center;">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-body">
                <?= form_open('checkout/save', ['id' => 'formcheckout']) ?>
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="idcheckout">ID Checkout</label>
                            <input type="text" id="idcheckout" name="idcheckout" class="form-control" value="<?= $next_id ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="idcheckin">Checkin</label>
                            <div class="input-group">
                                <input type="hidden" id="idcheckin" name="idcheckin" class="form-control" readonly>
                                <input type="text" id="kode_checkin" name="kode_checkin" class="form-control" placeholder="Pilih Checkin" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-info" type="button" id="btnModalCariCheckin" data-toggle="modal" data-target="#modalcariCheckin">Cari</button>
                                </div>
                                <div class="invalid-feedback error_idcheckin"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Detail Checkin yang Dipilih -->
                <div class="row" id="detailCheckin" style="display: none;">
                    <div class="col-md-8">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Checkin</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Nama Tamu</th>
                                                    <td id="display_nama_tamu">-</td>
                                                </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td id="display_nik">-</td>
                                                </tr>
                                                <tr>
                                                    <th>No HP</th>
                                                    <td id="display_nohp">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Kamar</th>
                                                    <td id="display_nama_kamar">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Per Malam</th>
                                                    <td id="display_harga_kamar">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="40%">Tanggal Checkin</th>
                                                    <td id="display_tglcheckin">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Checkout</th>
                                                    <td id="display_tglcheckout">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Lama Menginap</th>
                                                    <td id="display_lama_hari">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Bayar</th>
                                                    <td id="display_totalbayar">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Sisa Bayar</th>
                                                    <td id="display_sisabayar">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Deposit</th>
                                                    <td id="display_deposit">-</td>
                                                </tr>
                                                <tr style="background-color: #f8f9fa;">
                                                    <th style="color: #28a745;">Kembalian</th>
                                                    <td id="display_grandtotal" style="font-weight: bold; color: #28a745;">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Input Checkout -->
                <div class="row" id="formInputCheckout" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tglcheckin">Tanggal Checkin <span class="text-danger">*</span></label>
                            <input type="date" id="tglcheckin" name="tglcheckin" class="form-control" readonly>
                            <div class="invalid-feedback error_tglcheckin"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tglcheckout_actual">Tanggal Checkout Aktual <span class="text-danger">*</span></label>
                            <input type="date" id="tglcheckout_actual" name="tglcheckout_actual" class="form-control">
                            <div class="invalid-feedback error_tglcheckout_actual"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="potongan">Potongan <span class="text-danger">*</span></label>
                            <input type="text" id="potongan_display" name="potongan_display" class="form-control" placeholder="Rp. 0">
                            <input type="hidden" id="potongan" name="potongan" value="0">
                            <div class="invalid-feedback error_potongan"></div>
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="grandtotal">Kembalian</label>
                            <input type="text" id="grandtotal_display" class="form-control" readonly style="color: green; font-weight: bold;">
                            <input type="hidden" id="grandtotal" name="grandtotal">
                            <small class="text-muted">Deposit - Potongan = Kembalian</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan checkout (opsional)"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <a href="<?= site_url('checkout') ?>" class="btn btn-secondary">Kembali</a>
                    <button type="submit" id="btnSimpan" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Checkout
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cari Checkin -->
<div class="modal fade" id="modalcariCheckin" tabindex="-1" role="dialog" aria-labelledby="modalcariCheckinLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalcariCheckinLabel">
                    <i class="fas fa-search"></i> Pilih Data Checkin untuk Checkout
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="tabelCheckin" style="width: 100%; margin-bottom: 0;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Checkin</th>
                                <th>Nama Tamu</th>
                                <th>Kamar</th>
                                <th>Tanggal Checkin</th>
                                <th>Tanggal Checkout</th>
                                <th class="no-short">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('style') ?>
<style>
/* Modal styling */
#modalcariCheckin .modal-dialog {
    max-width: 95%;
    margin: 1.75rem auto;
}

#modalcariCheckin .modal-content {
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

#modalcariCheckin .modal-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}

#modalcariCheckin .modal-body {
    padding: 25px !important;
    background: #f8f9fa;
}

/* Table styling */
#modalcariCheckin .table-responsive {
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

#modalcariCheckin table {
    margin-bottom: 0 !important;
    background: white;
    table-layout: fixed !important;
    width: 100% !important;
}

#modalcariCheckin thead th {
    background: #343a40;
    color: white;
    border: none;
    padding: 15px 8px;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    word-wrap: break-word;
    overflow: hidden;
}

#modalcariCheckin tbody td {
    padding: 12px 8px;
    vertical-align: middle;
    border-color: #dee2e6;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
}

#modalcariCheckin .btn-pilihcheckin {
    background: #28a745;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    color: white;
    font-size: 12px;
    font-weight: 500;
}

#modalcariCheckin .btn-pilihcheckin:hover {
    background: #218838;
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* DataTable styling */
#modalcariCheckin .dataTables_wrapper {
    width: 100% !important;
}

#modalcariCheckin .dataTables_wrapper .dataTables_scroll {
    width: 100% !important;
}

#modalcariCheckin .dataTables_wrapper .dataTables_scrollHead,
#modalcariCheckin .dataTables_wrapper .dataTables_scrollBody {
    width: 100% !important;
}

#modalcariCheckin .dataTables_wrapper table {
    width: 100% !important;
}

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin-bottom: 10px;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 6px 12px;
}

/* Responsive */
@media (max-width: 768px) {
    #modalcariCheckin .modal-dialog {
        max-width: 98%;
        margin: 10px;
    }
    
    #modalcariCheckin .modal-body {
        padding: 15px !important;
    }
    
    #modalcariCheckin thead th,
    #modalcariCheckin tbody td {
        padding: 8px 6px;
        font-size: 13px;
    }
}
</style>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    // Format currency function
    function formatRupiah(value) {
        const number = parseInt(value.replace(/[^0-9]/g, ''), 10);
        if (isNaN(number)) return '';
        return 'Rp. ' + number.toLocaleString('id-ID');
    }

    // Remove currency format to get plain number
    function removeCurrencyFormat(value) {
        return value.replace(/[^0-9]/g, '');
    }

    // Format currency on input for potongan
    $('#potongan_display').on('input', function() {
        const input = $(this);
        const value = input.val();
        const formatted = formatRupiah(value);
        input.val(formatted);
        
        // Update hidden field with numeric value
        const numericValue = removeCurrencyFormat(value);
        $('#potongan').val(numericValue);
        
        // Recalculate grand total
        calculateGrandTotal();
    });

    // Initialize DataTable untuk checkin
    var tableCheckin = $('#tabelCheckin').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/checkout/viewgetcheckin',
        info: true,
        ordering: true,
        paging: true,
        pageLength: 10,
        order: [
            [1, 'desc']
        ],
        autoWidth: false,
        scrollX: false,
        responsive: false,
        columnDefs: [
            { "width": "8%", "targets": 0, "className": "text-center" },    // No
            { "width": "20%", "targets": 1, "className": "text-center" },   // Kode Checkin
            { "width": "20%", "targets": 2, "className": "text-left" },     // Nama Tamu
            { "width": "15%", "targets": 3, "className": "text-center" },   // Kamar
            { "width": "15%", "targets": 4, "className": "text-center" },   // Tanggal Checkin
            { "width": "15%", "targets": 5, "className": "text-center" },   // Tanggal Checkout
            { "width": "7%", "targets": 6, "className": "text-center", "bSortable": false }  // Aksi
        ],
        language: {
            processing: "Memuat data...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir", 
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            emptyTable: "Tidak ada data checkin yang tersedia untuk checkout",
            zeroRecords: "Tidak ditemukan data checkin yang sesuai"
        }
    });

    // Handle pilih checkin
    $('#tabelCheckin').on('click', '.btn-pilihcheckin', function() {
        var idbooking = $(this).data('idbooking');
        var idcheckin = $(this).data('idcheckin');
        var nama_tamu = $(this).data('nama_tamu');
        var nik = $(this).data('nik');
        var nohp = $(this).data('nohp');
        var nama_kamar = $(this).data('nama_kamar');
        var tglcheckin = $(this).data('tglcheckin');
        var tglcheckout = $(this).data('tglcheckout');
        var totalbayar = $(this).data('totalbayar');
        var sisabayar = $(this).data('sisabayar');
        var deposit = $(this).data('deposit');
        var harga_kamar = $(this).data('harga_kamar');
        var lama_hari = $(this).data('lama_hari');

        // Set values
        $('#idcheckin').val(idcheckin);
        $('#kode_checkin').val(idcheckin);
        
        // Set field baru
        var tglcheckinDate = new Date(tglcheckin.split('-').reverse().join('-')); // Convert from dd-mm-yyyy to yyyy-mm-dd
        $('#tglcheckin').val(tglcheckinDate.toISOString().split('T')[0]);
        
        // Set tanggal checkout actual ke tanggal checkout dari datatable
        var tglcheckoutDate = new Date(tglcheckout.split('-').reverse().join('-')); // Convert from dd-mm-yyyy to yyyy-mm-dd
        $('#tglcheckout_actual').val(tglcheckoutDate.toISOString().split('T')[0]);
        
        // Store deposit untuk kalkulasi
        $('#deposit_value').remove(); // Remove existing hidden field if any
        $('<input>').attr({
            type: 'hidden',
            id: 'deposit_value',
            value: deposit
        }).appendTo('#formcheckout');
        
        // Display details
        $('#display_nama_tamu').text(nama_tamu);
        $('#display_nik').text(nik);
        $('#display_nohp').text(nohp);
        $('#display_nama_kamar').text(nama_kamar);
        $('#display_harga_kamar').text('Rp ' + new Intl.NumberFormat('id-ID').format(harga_kamar));
        $('#display_tglcheckin').text(tglcheckin);
        $('#display_tglcheckout').text(tglcheckout);
        $('#display_lama_hari').text(lama_hari + ' hari');
        $('#display_totalbayar').text('Rp ' + new Intl.NumberFormat('id-ID').format(totalbayar));
        $('#display_sisabayar').text('Rp ' + new Intl.NumberFormat('id-ID').format(sisabayar));
        $('#display_deposit').text('Rp ' + new Intl.NumberFormat('id-ID').format(deposit));

        // Hitung grand total awal
        calculateGrandTotal();

        // Show detail sections
        $('#detailCheckin').show();
        $('#formInputCheckout').show();

        // Close modal
        $('#modalcariCheckin').modal('hide');
    });

    // Fungsi kalkulasi Grand Total
    function calculateGrandTotal() {
        var deposit = parseFloat($('#deposit_value').val()) || 0;
        var potongan = parseFloat($('#potongan').val()) || 0;
        var grandTotal = deposit - potongan;
        
        if (grandTotal < 0) {
            grandTotal = 0;
        }
        
        var formattedTotal = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
        
        // Update form input display
        $('#grandtotal_display').val(formattedTotal);
        
        // Update hidden field with numeric value
        $('#grandtotal').val(grandTotal);
        
        // Update display in detail section
        $('#display_grandtotal').text(formattedTotal);
    }

    // Event listener untuk kalkulasi real-time sudah ada di format currency function

    // Reset form function
    function resetForm() {
        $('#detailCheckin').hide();
        $('#formInputCheckout').hide();
        $('#idcheckin').val('');
        $('#kode_checkin').val('');
        $('#potongan').val('0');
        $('#potongan_display').val('');
        $('#tglcheckin').val('');
        $('#tglcheckout_actual').val('');
        $('#grandtotal').val('');
        $('#grandtotal_display').val('');
        $('#keterangan').val('');
        $('#deposit_value').remove();
        
        // Reset display
        $('#display_grandtotal').text('-');
        
        // Reset validation
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }

    // Handle form submit
    $('#formcheckout').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        // Disable submit button
        $('#btnSimpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.sukses,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        // Redirect ke faktur dengan ID checkout yang baru dibuat
                        window.location.href = '/checkout/faktur/' + response.idcheckout;
                    });
                } else if (response.error) {
                    // Handle validation errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').text('');
                    
                    $.each(response.error, function(key, value) {
                        $('#' + key.replace('error_', '')).addClass('is-invalid');
                        $('.' + key).text(value);
                    });
                    
                    $('#btnSimpan').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Checkout');
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem'
                });
                $('#btnSimpan').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan Checkout');
            }
        });
    });

    // Reset form validation on input change
    $('input, textarea, select').on('input change', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').text('');
    });
});
</script>
<?= $this->endSection() ?> 