<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Check-in Booking dengan QR Code</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Scan QR Code dari faktur booking pasien untuk melakukan check-in.
                            </div>
                            
                            <div class="text-center mb-4">
                                <button id="startButton" class="btn btn-primary btn-lg">
                                    <i class="fas fa-camera"></i> Mulai Scan QR Code
                                </button>
                            </div>
                            
                            <div id="scanner-container" style="display: none;">
                                <div class="video-container" style="position: relative; width: 100%; max-width: 500px; margin: 0 auto;">
                                    <video id="preview" style="width: 100%; border: 3px solid #20c997; border-radius: 10px;"></video>
                                    <div class="scanner-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 2px solid #20c997; border-radius: 10px; box-shadow: 0 0 0 4000px rgba(0, 0, 0, 0.3); z-index: 10;"></div>
                                </div>
                                
                                <div class="text-center mt-3 mb-3">
                                    <button id="stopButton" class="btn btn-danger">
                                        <i class="fas fa-stop-circle"></i> Berhenti
                                    </button>
                                </div>
                            </div>
                            
                            <div id="result" class="mt-4"></div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h4 class="card-title">Detail Booking</h4>
                                </div>
                                <div class="card-body" id="booking-details">
                                    <div class="text-center py-5">
                                        <i class="fas fa-qrcode fa-5x text-muted mb-3"></i>
                                        <p>Data booking akan ditampilkan di sini setelah QR code berhasil di-scan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('booking') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- Include instascan.js -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
$(document).ready(function() {
    let scanner = null;
    
    // Handle start scanning button
    $('#startButton').on('click', function() {
        // Show scanner container
        $('#scanner-container').show();
        $(this).hide();
        
        // Initialize scanner
        scanner = new Instascan.Scanner({ 
            video: document.getElementById('preview'),
            mirror: false,
            scanPeriod: 5 // Scan every 5 milliseconds
        });
        
        // Handle successful scans
        scanner.addListener('scan', function(content) {
            // Play a beep sound
            const beep = new Audio('data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAABHcnNyY25hbWUAU1RBUkRJVklORTEuV0FWZGVzY3JpcHRpb24AR2VuZXJhdGVkIGJ5IHNvdW5kZGVzaWduZXIgMS42NCwgMDMtMDQtOTYuZGF0YQ');
            beep.play();
            
            // Visual feedback
            $('#result').html(`<div class="alert alert-success"><i class="fas fa-check-circle"></i> QR Code terdeteksi: ${content}</div>`);
            
            // Process the booking ID
            processBookingCheckin(content);
            
            // Stop scanning
            scanner.stop();
            $('#scanner-container').hide();
            $('#startButton').show().text('Scan QR Code Lainnya').prepend('<i class="fas fa-sync mr-2"></i>');
        });
        
        // Start the scanner
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                // Try to use the back camera on mobile devices
                let selectedCamera = cameras[0]; // Default to first camera
                
                // Look for back camera
                for(let i = 0; i < cameras.length; i++) {
                    if(cameras[i].name && cameras[i].name.toLowerCase().indexOf('back') !== -1) {
                        selectedCamera = cameras[i];
                        break;
                    }
                }
                
                scanner.start(selectedCamera);
            } else {
                $('#result').html(`<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Tidak ada kamera yang terdeteksi pada perangkat ini.</div>`);
                $('#scanner-container').hide();
                $('#startButton').show();
            }
        }).catch(function(e) {
            console.error(e);
            $('#result').html(`<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Error: ${e}</div>`);
            $('#scanner-container').hide();
            $('#startButton').show();
        });
    });
    
    // Handle stop scanning button
    $('#stopButton').on('click', function() {
        if (scanner) {
            scanner.stop();
        }
        $('#scanner-container').hide();
        $('#startButton').show();
    });
    
    // Process booking check-in
    function processBookingCheckin(bookingId) {
        $.ajax({
            url: '<?= site_url('booking/processCheckin') ?>',
            type: 'POST',
            data: {
                idbooking: bookingId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Check-in Berhasil!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                    
                    // Display booking details
                    displayBookingDetails(response.booking);
                    
                    // Refresh the main booking table if it exists
                    if (typeof $('#tabelBooking').DataTable === 'function') {
                        $('#tabelBooking').DataTable().ajax.reload();
                    }
                } else {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Check-in Gagal',
                        text: response.message
                    });
                    
                    // Clear booking details
                    $('#booking-details').html(`
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-circle fa-5x text-danger mb-3"></i>
                            <p>${response.message}</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memproses check-in.'
                });
            }
        });
    }
    
    // Display booking details
    function displayBookingDetails(booking) {
        const statusClass = booking.status === 'diperiksa' ? 'badge-success' : 
                          (booking.status === 'pending' ? 'badge-warning' : 
                          (booking.status === 'ditolak' ? 'badge-danger' : 'badge-info'));
        
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
                        <p><strong>Tanggal:</strong> ${formatDate(booking.tanggal)}</p>
                        <p><strong>Waktu:</strong> ${booking.waktu_mulai.substr(0, 5)} - ${booking.waktu_selesai.substr(0, 5)}</p>
                        <p><strong>Status:</strong> <span class="badge ${statusClass}">${capitalizeFirstLetter(booking.status)}</span></p>
                    </div>
                </div>
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i> Pasien telah berhasil check-in dan siap untuk diperiksa.
                </div>
            </div>
        `;
        
        $('#booking-details').html(html);
    }
    
    // Helper functions
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
    }
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
});
</script>
<?= $this->endSection() ?> 