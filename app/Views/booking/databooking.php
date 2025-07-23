<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-teal">
                <div class="card-header">
                    <h5 class="card-title">
                        <?= $title ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <a href="<?= site_url('booking/formtambah') ?>" class="btn btn-danger">Tambah Booking</a>
                        </div>
                        <div>
                            <button type="button" id="btnCheckinBookingModal" class="btn btn-warning">Checkin Booking</button>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal mt-4">
                        <table class="table table-hover" id="tabelBooking">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Booking</th>
                                    <th>Tanggal</th>
                                    <th>Pasien</th>
                                    <th>Dokter</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th class="no-short">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Check-in QR -->
<div class="modal fade" id="checkinQrModal" tabindex="-1" role="dialog" aria-labelledby="checkinQrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="checkinQrModalLabel"><i class="fas fa-qrcode mr-2"></i> Check-in Booking dengan QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="alert alert-info">
              <i class="fas fa-info-circle"></i> Scan QR Code dari faktur booking pasien untuk melakukan check-in.
            </div>
            <div class="text-center mb-4">
              <button id="startQrScanBtn" class="btn btn-primary btn-lg">
                <i class="fas fa-camera"></i> Mulai Scan QR Code
              </button>
            </div>
            <div id="scanner-container-modal" style="display: none;">
              <div class="video-container" style="position: relative; width: 100%; max-width: 400px; margin: 0 auto;">
                <video id="preview-modal" style="width: 100%; border: 3px solid #20c997; border-radius: 10px;"></video>
                <div class="scanner-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 2px solid #20c997; border-radius: 10px; box-shadow: 0 0 0 4000px rgba(0, 0, 0, 0.3); z-index: 10;"></div>
              </div>
              <div class="text-center mt-3 mb-3">
                <button id="stopQrScanBtn" class="btn btn-danger">
                  <i class="fas fa-stop-circle"></i> Berhenti
                </button>
              </div>
            </div>
            <div id="result-modal" class="mt-4"></div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header bg-info">
                <h4 class="card-title">Detail Booking</h4>
              </div>
              <div class="card-body" id="booking-details-modal">
                <div class="text-center py-5">
                  <i class="fas fa-qrcode fa-5x text-muted mb-3"></i>
                  <p>Data booking akan ditampilkan di sini setelah QR code berhasil di-scan.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-close-checkin-qr">
          <i class="fas fa-times mr-1"></i> Tutup
        </button>
      </div>
    </div>
  </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    $('#tabelBooking').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/booking/view',
        info: true,
        ordering: true,
        paging: true,
        order: [
            [0, 'desc']
        ],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-short"]
        }],
        // Tidak ada kolom check-in QR
    });

    $(document).on('click', '#btn-close-checkin-qr', function() {
        $('#checkinQrModal').modal('hide');
        window.location.href = "/perawatan";
      });
    $(document).on('click', '.btn-delete', function() {
        var idbooking = $(this).data('idbooking');

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data booking ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('booking/delete'); ?>",
                    data: {
                        idbooking: idbooking
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.sukses,
                                icon: 'success'
                            });
                            // Refresh DataTable
                            $('#tabelBooking').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data booking',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data booking',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

$(document).on('click', '.btn-edit', function() {
    var idbooking = $(this).data('idbooking');
    window.location.href = "<?php echo site_url('booking/formedit/'); ?>" + idbooking;
});

$(document).on('click', '.btn-detail', function() {
    var idbooking = $(this).data('idbooking');
    window.location.href = "<?php echo site_url('booking/detail/'); ?>" + idbooking;
});

$(document).on('click', '.btn-cek-bukti', function() {
    var idbooking = $(this).data('idbooking');
    window.location.href = "<?php echo site_url('booking/getBuktiBooking/'); ?>" + idbooking;
});


// Add event handlers for approve and reject buttons
$(document).on('click', '.btn-approve', function() {
    var idbooking = $(this).data('idbooking');
    
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menyetujui booking ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Setuju!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('booking/updateStatus'); ?>",
                data: {
                    idbooking: idbooking,
                    status: 'diterima'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.sukses,
                            icon: 'success'
                        });
                        // Refresh DataTable
                        $('#tabelBooking').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal mengubah status booking',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengubah status booking',
                        icon: 'error'
                    });
                }
            });
        }
    });
});

$(document).on('click', '.btn-reject', function() {
    var idbooking = $(this).data('idbooking');
    
    Swal.fire({
        title: 'Konfirmasi',
        text: "Apakah Anda yakin ingin menolak booking ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tolak!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('booking/updateStatus'); ?>",
                data: {
                    idbooking: idbooking,
                    status: 'ditolak'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.sukses,
                            icon: 'success'
                        });
                        // Refresh DataTable
                        $('#tabelBooking').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal mengubah status booking',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengubah status booking',
                        icon: 'error'
                    });
                }
            });
        }
    });
});

// Script untuk modal QR Check-in
$.getScript('https://rawgit.com/schmich/instascan-builds/master/instascan.min.js');
let scannerModal = null;
// Trigger modal dari tombol lama
$('#btnCheckinBookingModal').on('click', function() {
  $('#checkinQrModal').modal('show');
});
$('#checkinQrModal').on('shown.bs.modal', function () {
  // Reset tampilan
  $('#result-modal').html('');
  $('#booking-details-modal').html('<div class="text-center py-5"><i class="fas fa-qrcode fa-5x text-muted mb-3"></i><p>Data booking akan ditampilkan di sini setelah QR code berhasil di-scan.</p></div>');
  $('#startQrScanBtn').show();
  $('#scanner-container-modal').hide();
});
$('#startQrScanBtn').on('click', function() {
  $('#scanner-container-modal').show();
  $(this).hide();
  scannerModal = new Instascan.Scanner({ video: document.getElementById('preview-modal'), mirror: false, scanPeriod: 5 });
  scannerModal.addListener('scan', function(content) {
    const beep = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAABHcnNyY25hbWUAU1RBUkRJVklORTEuV0FWZGVzY3JpcHRpb24AR2VuZXJhdGVkIGJ5IHNvdW5kZGVzaWduZXIgMS42NCwgMDMtMDQtOTYuZGF0YQ');
    beep.play();
    $('#result-modal').html(`<div class="alert alert-success"><i class="fas fa-check-circle"></i> QR Code terdeteksi: ${content}</div>`);
    processBookingCheckinModal(content);
    scannerModal.stop();
    $('#scanner-container-modal').hide();
    $('#startQrScanBtn').show().text('Scan QR Code Lainnya').prepend('<i class="fas fa-sync mr-2"></i>');
  });
  Instascan.Camera.getCameras().then(function(cameras) {
    if (cameras.length > 0) {
      let selectedCamera = cameras[0];
      for(let i = 0; i < cameras.length; i++) {
        if(cameras[i].name && cameras[i].name.toLowerCase().indexOf('back') !== -1) {
          selectedCamera = cameras[i];
          break;
        }
      }
      scannerModal.start(selectedCamera);
    } else {
      $('#result-modal').html(`<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Tidak ada kamera yang terdeteksi pada perangkat ini.</div>`);
      $('#scanner-container-modal').hide();
      $('#startQrScanBtn').show();
    }
  }).catch(function(e) {
    console.error(e);
    $('#result-modal').html(`<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error: ${e}</div>`);
    $('#scanner-container-modal').hide();
    $('#startQrScanBtn').show();
  });
});
$('#stopQrScanBtn').on('click', function() {
  if (scannerModal) {
    scannerModal.stop();
  }
  $('#scanner-container-modal').hide();
  $('#startQrScanBtn').show();
});
function processBookingCheckinModal(bookingId) {
  $.ajax({
    url: '<?= site_url('booking/processCheckin') ?>',
    type: 'POST',
    data: { idbooking: bookingId },
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        Swal.fire({ icon: 'success', title: 'Check-in Berhasil!', text: response.message, timer: 3000, showConfirmButton: false });
        displayBookingDetailsModal(response.booking);
        if (typeof $('#tabelBooking').DataTable === 'function') {
          $('#tabelBooking').DataTable().ajax.reload();
        }
      } else {
        Swal.fire({ icon: 'error', title: 'Check-in Gagal', text: response.message });
        $('#booking-details-modal').html(`<div class="text-center py-5"><i class="fas fa-exclamation-circle fa-5x text-danger mb-3"></i><p>${response.message}</p></div>`);
      }
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
      Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat memproses check-in.' });
    }
  });
}
function displayBookingDetailsModal(booking) {
  const statusClass = booking.status === 'diperiksa' ? 'badge-success' : (booking.status === 'pending' ? 'badge-warning' : (booking.status === 'ditolak' ? 'badge-danger' : 'badge-info'));
  const html = `
    <div class="booking-info">
      <h5 class="text-primary">Booking #${booking.idbooking}</h5>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <p><strong>Pasien:</strong> ${booking.nama_pasien}</p>
          <p><strong>Dokter:</strong> ${booking.nama_dokter}</p>
          <p><strong>Jenis Perawatan:</strong> ${booking.namajenis}</p>
        </div>
        <div class="col-md-6">
          <p><strong>Tanggal:</strong> ${formatDateModal(booking.tanggal)}</p>
          <p><strong>Waktu:</strong> ${booking.waktu_mulai.substr(0, 5)} - ${booking.waktu_selesai.substr(0, 5)}</p>
          <p><strong>Status:</strong> <span class="badge ${statusClass}">${capitalizeFirstLetterModal(booking.status)}</span></p>
        </div>
      </div>
      <div class="alert alert-success mt-3">
        <i class="fas fa-check-circle"></i> Pasien telah berhasil check-in dan siap untuk diperiksa.
      </div>
    </div>
  `;
  $('#booking-details-modal').html(html);
}
function formatDateModal(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
}
function capitalizeFirstLetterModal(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>
<?= $this->endSection() ?>