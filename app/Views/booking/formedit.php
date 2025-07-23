<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-teal shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i> Edit Booking</h3>
                </div>

                <div class="card-body p-4">
                    <?= form_open('booking/updatedata/' . $booking['idbooking'], ['id' => 'formeditbooking', 'enctype' => 'multipart/form-data']) ?>
                    <?= csrf_field() ?>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="form-group row mb-4">
                                <label for="idbooking" class="col-sm-3 col-form-label">ID Booking</label>
                                <div class="col-sm-9">
                                    <input type="text" id="idbooking" name="idbooking" value="<?= $booking['idbooking'] ?>" readonly class="form-control">
                                    <div class="invalid-feedback error_idbooking"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="id_pasien" class="col-sm-3 col-form-label">Pasien</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" id="id_pasien" name="id_pasien" class="form-control" value="<?= $booking['id_pasien'] ?>" readonly>
                                        <input type="text" id="namapasien" name="namapasien" class="form-control" value="<?= isset($booking['pasien_nama']) ? $booking['pasien_nama'] : '' ?>" readonly placeholder="Pilih Pasien">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btnCariPasien" data-toggle="modal"
                                                    data-target="#modalPasien">Cari</button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback error_id_pasien"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="idjadwal" class="col-sm-3 col-form-label">Jadwal</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="hidden" id="idjadwal" name="idjadwal" class="form-control" value="<?= $booking['idjadwal'] ?>" readonly>
                                        <input type="text" id="infojadwal" name="infojadwal" class="form-control" value="<?= isset($booking['jadwal_info']) ? $booking['jadwal_info'] : '' ?>" readonly placeholder="Pilih Jadwal">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="btnCariJadwal" data-toggle="modal"
                                                    data-target="#modalJadwal">Cari</button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback error_idjadwal"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Booking</label>
                                <div class="col-sm-9">
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $booking['tanggal'] ?>" min="<?= date('Y-m-d') ?>" disabled>
                                    <small class="form-text text-muted">Pilih tanggal sesuai hari jadwal dokter</small>
                                    <div id="jadwal-info" class="alert alert-info mt-2" style="display: none;">
                                        <i class="fas fa-info-circle"></i> <span id="jadwal-info-text"></span>
                                    </div>
                                    <div class="invalid-feedback error_tanggal"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="idjenis" class="col-sm-3 col-form-label">Jenis Perawatan</label>
                                <div class="col-sm-9">
                                    <select id="idjenis" name="idjenis" class="form-control select2">
                                        <option value="">Pilih Jenis Perawatan</option>
                                        <?php foreach ($jenis as $row): ?>
                                            <option value="<?= $row['idjenis'] ?>" data-durasi="<?= $row['estimasi'] ?>" <?= ($booking['idjenis'] == $row['idjenis']) ? 'selected' : ''; ?>>
                                                <?= $row['namajenis'] ?> (Est. <?= $row['estimasi'] ?> menit)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback error_idjenis"></div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-sm-3 col-form-label">Slot Tersedia</label>
                                <div class="col-sm-9">
                                    <button type="button" id="cekSlotButton" class="btn btn-info">
                                        <i class="fas fa-search"></i> Cek Slot Tersedia
                                    </button>
                                    <small class="form-text text-muted">Pilih tanggal, jadwal, dan jenis perawatan terlebih dahulu.</small>
                                    <div id="slotInfo" class="alert mt-2" style="display: none;"></div>
                                </div>
                            </div>
                         
                            <div class="form-group row mb-4">
                                <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai</label>
                                <div class="col-sm-9">
                                    <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control" value="<?= $booking['waktu_mulai'] ?>" readonly>
                                    <div class="invalid-feedback error_waktu_mulai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai</label>
                                <div class="col-sm-9">
                                    <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control" value="<?= $booking['waktu_selesai'] ?>" readonly>
                                    <div class="invalid-feedback error_waktu_selesai"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select id="status" name="status" class="form-control">
                                        <option value="pending" <?= ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="diterima" <?= ($booking['status'] == 'diterima') ? 'selected' : ''; ?>>Diterima</option>
                                        <option value="ditolak" <?= ($booking['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                    <div class="invalid-feedback error_status"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <label for="catatan" class="col-sm-3 col-form-label">Catatan</label>
                                <div class="col-sm-9">
                                    <textarea id="catatan" name="catatan" class="form-control" rows="3"><?= $booking['catatan'] ?></textarea>
                                    <div class="invalid-feedback error_catatan"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-5">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary btn-lg px-4" id="tombolSimpan">
                                        <i class="fas fa-save mr-1"></i> SIMPAN
                                    </button>
                                    <a class="btn btn-secondary btn-lg px-4 ml-2" href="<?= base_url('booking') ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> KEMBALI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?= form_close() ?>

                    <!-- Modal Pilih Pasien -->
                    <div class="modal fade" id="modalPasien" tabindex="-1" role="dialog" aria-labelledby="modalPasienLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalPasienLabel">Pilih Pasien</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Pilih Jadwal -->
                    <div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-labelledby="modalJadwalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalJadwalLabel">Pilih Jadwal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(function() {
    // Inisialisasi select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Fix for accessibility issue with modal focus
    $('#modalJadwal').on('hidden.bs.modal', function (e) {
        // Return focus to the button that opened the modal
        $('#btnCariJadwal').focus();
        // Ensure all focusable elements inside modal are properly reset
        $(this).find('button.btn-pilihjadwal').blur();
    });
    
    $('#modalPasien').on('hidden.bs.modal', function (e) {
        // Return focus to the button that opened the modal
        $('#btnCariPasien').focus();
        // Ensure all focusable elements inside modal are properly reset
        $(this).find('button.btn-pilihpasien').blur();
    });
    
    $('#formeditbooking').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                $('#tombolSimpan').prop('disabled', true);
            },

            complete: function() {
                $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                $('#tombolSimpan').prop('disabled', false);
            },

            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_id_pasien) {
                        $('#id_pasien').addClass('is-invalid');
                        $('.error_id_pasien').html(err.error_id_pasien);
                    } else {
                        $('#id_pasien').removeClass('is-invalid');
                        $('.error_id_pasien').html('');
                    }
                    
                    if (err.error_idjadwal) {
                        $('#idjadwal').addClass('is-invalid');
                        $('.error_idjadwal').html(err.error_idjadwal);
                    } else {
                        $('#idjadwal').removeClass('is-invalid');
                        $('.error_idjadwal').html('');
                    }
                    
                    if (err.error_idjenis) {
                        $('#idjenis').addClass('is-invalid');
                        $('.error_idjenis').html(err.error_idjenis);
                    } else {
                        $('#idjenis').removeClass('is-invalid');
                        $('.error_idjenis').html('');
                    }
                    
                    if (err.error_tanggal) {
                        $('#tanggal').addClass('is-invalid');
                        $('.error_tanggal').html(err.error_tanggal);
                    } else {
                        $('#tanggal').removeClass('is-invalid');
                        $('.error_tanggal').html('');
                    }

                    if (err.error_waktu_mulai) {
                        $('#waktu_mulai').addClass('is-invalid');
                        $('.error_waktu_mulai').html(err.error_waktu_mulai);
                    } else {
                        $('#waktu_mulai').removeClass('is-invalid');
                        $('.error_waktu_mulai').html('');
                    }

                    if (err.error_waktu_selesai) {
                        $('#waktu_selesai').addClass('is-invalid');
                        $('.error_waktu_selesai').html(err.error_waktu_selesai);
                    } else {
                        $('#waktu_selesai').removeClass('is-invalid');
                        $('.error_waktu_selesai').html('');
                    }

                    if (err.error_jadwal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.error_jadwal
                        });
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.sukses,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = '<?= site_url('booking') ?>';
                    }, 1500);
                }
            },

            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });

        return false;
    });
    
    $('#modalPasien').on('show.bs.modal', function(e) {
        var loader =
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Load data here from the server
        $.get('<?= base_url() ?>/booking/getPasien', function(data) {
            $('#modalPasien .modal-body').html(data);
        });
    });
    
    // Menangani klik pada tombol pilih pasien dari modal
    $(document).on('click', '.btn-pilihpasien', function() {
        var id_pasien = $(this).data('id_pasien');
        var nama_pasien = $(this).data('nama_pasien');
        
        $('#id_pasien').val(id_pasien);
        $('#namapasien').val(nama_pasien);
        
        // Hapus class is-invalid jika ada
        $('#id_pasien').removeClass('is-invalid');
        
        // Tutup modal
        $('#modalPasien').modal('hide');
    });

    $('#modalJadwal').on('show.bs.modal', function(e) {
        var loader =
            '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
        $(this).find('.modal-body').html(loader);

        // Debug test: coba isi dengan konten statis dulu
        var staticContent = '<div class="alert alert-info">Memuat data jadwal...</div>';
        $(this).find('.modal-body').html(staticContent);
        
        // Kemudian coba muat data asli
        $.ajax({
            url: '<?= site_url('booking/getJadwal') ?>',
            type: 'GET',
            success: function(response) {
                $('#modalJadwal .modal-body').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#modalJadwal .modal-body').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            }
        });
    });
    
    // Menangani klik pada tombol pilih jadwal dari modal
    $(document).on('click', '.btn-pilihjadwal', function() {
        var idjadwal = $(this).data('idjadwal');
        var nama_dokter = $(this).data('nama_dokter');
        var hari = $(this).data('hari');
        var waktu = $(this).data('waktu');
        
        $('#idjadwal').val(idjadwal);
        $('#infojadwal').val(nama_dokter + ' - ' + hari + ' ' + waktu);
        
        // Hapus class is-invalid jika ada
        $('#idjadwal').removeClass('is-invalid');
        
        // Tutup modal
        $('#modalJadwal').modal('hide');
        
        // Aktifkan input tanggal dan reset nilai
        $('#tanggal').val('').prop('disabled', false);
        
        // Tampilkan info jadwal
        $('#jadwal-info').show();
        $('#jadwal-info-text').html('Jadwal dokter <strong>' + nama_dokter + '</strong> pada hari <strong>' + hari + '</strong>. Pilih tanggal yang sesuai.');
        
        // Set validasi tanggal berdasarkan hari jadwal
        setValidDatesForDay(hari);
    });

    // Fungsi untuk membuat validasi tanggal berdasarkan hari jadwal
    function setValidDatesForDay(hari) {
        const dayMap = {
            'Minggu': 0,
            'Senin': 1,
            'Selasa': 2,
            'Rabu': 3,
            'Kamis': 4,
            'Jumat': 5,
            'Sabtu': 6
        };
        
        const dayNumber = dayMap[hari];
        if (dayNumber === undefined) {
            console.error('Hari tidak valid:', hari);
            return;
        }
        
        console.log('Setting up validation for day:', hari, 'day number:', dayNumber);
        
        const tanggalInput = $('#tanggal');
        
        // Reset event handler
        tanggalInput.off('change');
        
        // Tambahkan event handler baru
        tanggalInput.on('change', function() {
            const selectedDate = new Date($(this).val());
            if (!selectedDate || isNaN(selectedDate.getTime())) return;
            
            console.log('Selected date:', selectedDate, 'day of week:', selectedDate.getDay());
            
            // Cek apakah hari sesuai
            if (selectedDate.getDay() !== dayNumber) {
                Swal.fire({
                    title: 'Tanggal Tidak Sesuai',
                    text: `Tanggal yang Anda pilih bukan hari ${hari}. Silakan pilih tanggal yang jatuh pada hari ${hari}.`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                $(this).val(''); // Reset nilai
                return;
            }
            
            // Reset waktu saat tanggal berubah
            $('#waktu_mulai').val('');
            $('#waktu_selesai').val('');
            $('#slotInfo').hide();
            
            // Cek apakah waktu sudah lewat untuk hari ini
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate.getTime() === today.getTime()) {
                // Jika tanggal hari ini, periksa waktu
                const currentTime = new Date();
                const waktuJadwal = $('#infojadwal').val().split('-')[2].trim();
                const waktuMulai = waktuJadwal.split(' ')[0].trim();
                
                console.log('Today check - current time:', currentTime, 'jadwal waktu:', waktuMulai);
                
                // Konversi waktu jadwal ke objek Date
                const [hours, minutes] = waktuMulai.split(':').map(Number);
                const jadwalTime = new Date();
                jadwalTime.setHours(hours, minutes, 0, 0);
                
                // Jika waktu sekarang sudah melewati waktu jadwal
                if (currentTime > jadwalTime) {
                    Swal.fire({
                        title: 'Waktu Jadwal Sudah Lewat',
                        text: `Jadwal dokter untuk hari ini pada pukul ${waktuMulai} sudah lewat. Silakan pilih tanggal lain.`,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    $(this).val('');
                }
            }
        });
        
        // Set tanggal minimum ke hari ini
        const today = new Date();
        tanggalInput.attr('min', today.toISOString().split('T')[0]);
        
        // Cari tanggal berikutnya dengan hari yang sesuai
        let nextValidDate = new Date();
        while (nextValidDate.getDay() !== dayNumber) {
            nextValidDate.setDate(nextValidDate.getDate() + 1);
        }
        
        // Set placeholder dengan tanggal valid berikutnya
        const formattedDate = nextValidDate.toISOString().split('T')[0];
        tanggalInput.attr('placeholder', formattedDate);
        
        // Isi tanggal otomatis dengan tanggal valid berikutnya untuk memudahkan user
        tanggalInput.val(formattedDate);
        // Trigger change event untuk menjalankan validasi
        tanggalInput.trigger('change');
        
        console.log('Next valid date:', formattedDate);
    }

    // Cek slot tersedia saat tombol di klik
    $('#cekSlotButton').click(function() {
        var idjadwal = $('#idjadwal').val();
        var tanggal = $('#tanggal').val();
        var idjenis = $('#idjenis').val();
        
        if (!idjadwal || !tanggal || !idjenis) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih tanggal, jadwal, dan jenis perawatan terlebih dahulu.'
            });
            return;
        }
        
        // Set loading state
        $('#cekSlotButton').prop('disabled', true).html('<i class="fas fa-spin fa-spinner"></i> Mencari...');
        $('#slotInfo').hide();
        
        $.ajax({
            url: '<?= site_url('booking/findAvailableSlot') ?>',
            type: 'POST',
            data: {
                idjadwal: idjadwal,
                tanggal: tanggal,
                idjenis: idjenis,
                is_walk_in: true // Untuk booking offline
            },
            dataType: 'json',
            success: function(response) {
                $('#cekSlotButton').prop('disabled', false).html('<i class="fas fa-search"></i> Cek Slot Tersedia');
                
                console.log('Response from server:', response);
                
                if (response.success) {
                    // Slot tersedia
                    $('#slotInfo').removeClass('alert-danger').addClass('alert-success').show();
                    $('#slotInfo').html('<strong>Slot tersedia!</strong> ' +
                        'Waktu: ' + response.slot.waktu_mulai.substr(0, 5) + ' - ' + response.slot.waktu_selesai.substr(0, 5));
                    
                    // Tambahkan peringatan jika ada
                    if (response.warning) {
                        $('#slotInfo').append('<br><span class="text-warning"><i class="fas fa-exclamation-triangle"></i> ' + 
                            response.warning + '</span>');
                    }
                    
                    // Isi waktu mulai dan selesai otomatis
                    $('#waktu_mulai').val(response.slot.waktu_mulai.substr(0, 5));
                    $('#waktu_selesai').val(response.slot.waktu_selesai.substr(0, 5));
                } else {
                    // Slot tidak tersedia
                    $('#slotInfo').removeClass('alert-success').addClass('alert-danger').show();
                    $('#slotInfo').html('<strong>Tidak tersedia!</strong> ' + response.message);
                    
                    // Reset waktu
                    $('#waktu_mulai').val('');
                    $('#waktu_selesai').val('');
                }
            },
            error: function(xhr, status, error) {
                $('#cekSlotButton').prop('disabled', false).html('<i class="fas fa-search"></i> Cek Slot Tersedia');
                $('#slotInfo').removeClass('alert-success').addClass('alert-danger').show();
                $('#slotInfo').html('<strong>Error!</strong> Terjadi kesalahan saat mencari slot.');
                console.error(xhr.responseText);
            }
        });
    });

    // Reset fields when jadwal or jenis changes
    $('#idjadwal, #idjenis').change(function() {
        $('#waktu_mulai').val('');
        $('#waktu_selesai').val('');
        $('#slotInfo').hide();
    });
});
</script>
<?= $this->endSection() ?>