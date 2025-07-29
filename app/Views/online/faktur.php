<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    teal: {
                        50: '#fdf2f8',
                        100: '#fde8ef',
                        200: '#fbcfe8',
                        300: '#f9a8d4',
                        400: '#f472b6',
                        500: '#be123c', // maroon utama
                        600: '#9f1239',
                        700: '#881337',
                        800: '#701a32',
                        900: '#4a0326',
                        950: '#2e0512',
                    }
                }
            }
        }
    }
</script>
<!-- Tambahkan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* ========== WEB DISPLAY STYLES ========== */
    .faktur-container {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .print-area {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
    }
    
    .action-buttons {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-print {
        background: linear-gradient(135deg, #881337 0%, #be123c 100%);
        transform: translateY(0);
        transition: all 0.3s ease;
    }
    
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(136, 19, 55, 0.4);
    }
    
    /* ========== PRINT STYLES ========== */
    @media print {
        /* HIDE WEB-ONLY ELEMENTS */
        .no-print,
        .action-buttons,
        button,
        .btn-print,
        nav,
        header,
        footer,
        .web-only {
            display: none !important;
            visibility: hidden !important;
        }
        
        /* RESET PRINT LAYOUT */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
        }
        
        /* PAGE SETTINGS */
        @page {
            size: A4 portrait;
            margin: 10mm 8mm 8mm 8mm;
        }
        
        html, body {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* CONTAINER ADJUSTMENTS */
        .faktur-container {
            background: none !important;
            padding: 0 !important;
            min-height: auto !important;
        }
        
        .max-w-4xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .print-area {
            width: 100% !important;
            height: auto !important;
            page-break-inside: avoid;
            transform: scale(0.88);
            transform-origin: top left;
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
        }
        
        /* COMPACT EVERYTHING FOR PRINT */
        .p-4 {
            padding: 0.4rem !important;
        }
        
        .p-6, .md\:p-8 {
            padding: 0.4rem !important;
        }
        
        .text-2xl {
            font-size: 0.95rem !important;
            line-height: 1.2 !important;
        }
        
        .text-xl {
            font-size: 0.85rem !important;
            line-height: 1.2 !important;
        }
        
        .text-lg {
            font-size: 0.8rem !important;
            line-height: 1.2 !important;
        }
        
        .text-sm {
            font-size: 0.7rem !important;
            line-height: 1.1 !important;
        }
        
        /* COMPACT SPACING */
        .mb-8 {
            margin-bottom: 0.4rem !important;
        }
        
        .mb-4 {
            margin-bottom: 0.25rem !important;
        }
        
        .mb-2 {
            margin-bottom: 0.15rem !important;
        }
        
        .mt-10 {
            margin-top: 0.4rem !important;
        }
        
        .pt-6 {
            padding-top: 0.3rem !important;
        }
        
        .pb-6 {
            padding-bottom: 0.3rem !important;
        }
        
        /* COMPACT HEADER */
        .bg-teal-700 {
            padding: 0.6rem !important;
            -webkit-print-color-adjust: exact !important;
        }
        
        .h-24, .md\:h-30 {
            height: 1.8rem !important;
            width: auto !important;
        }
        
        /* COMPACT TABLES */
        table {
            font-size: 0.7rem !important;
            line-height: 1.1 !important;
        }
        
        th, td {
            padding: 0.15rem 0.25rem !important;
        }
        
        .px-4 {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }
        
        .py-4, .py-3 {
            padding-top: 0.15rem !important;
            padding-bottom: 0.15rem !important;
        }
        
        /* COMPACT GRIDS */
        .grid {
            gap: 0.3rem !important;
        }
        
        .gap-4 {
            gap: 0.3rem !important;
        }
        
        /* COMPACT CARDS */
        .rounded-lg {
            border-radius: 0.2rem !important;
        }
        
        /* ENSURE RESPONSIVE LAYOUT */
        .md\:flex-row {
            flex-direction: row !important;
        }
        
        .md\:text-right {
            text-align: right !important;
        }
        
        .md\:mt-0 {
            margin-top: 0 !important;
        }
        
        .flex {
            display: flex !important;
        }
        
        .justify-between {
            justify-content: space-between !important;
        }
        
        .md\:grid-cols-3 {
            grid-template-columns: repeat(3, 1fr) !important;
        }
        
        /* COMPACT BORDERS */
        .border-b {
            margin-bottom: 0.3rem !important;
            padding-bottom: 0.2rem !important;
        }
        
        /* SIGNATURE AREA */
        .h-24.md\:h-32 {
            height: 1.5rem !important;
            width: auto !important;
        }
        
        /* SHOW PRINT-ONLY ELEMENTS */
        .print-only {
            display: block !important;
        }
        
                 /* ENSURE COLORS PRINT */
         .bg-teal-700,
         .bg-gray-50,
         .bg-yellow-50,
         .bg-blue-50,
         .text-green-700,
         .text-green-600,
         .text-teal-700,
         .text-red-600,
         .bg-yellow-500,
         .bg-green-600,
         .bg-red-600,
         .border-yellow-200 {
             -webkit-print-color-adjust: exact !important;
             color-adjust: exact !important;
             print-color-adjust: exact !important;
         }
         
         /* COMPACT NOTES */
         .bg-yellow-50 {
             padding: 0.3rem !important;
             margin: 0.15rem 0 !important;
         }
         
         /* COMPACT LISTS */
         ul {
             margin: 0.15rem 0 !important;
         }
         
         li {
             margin-bottom: 0.05rem !important;
         }
        
        /* FINAL CLEANUP */
        .web-header,
        .action-buttons,
        .no-print {
            display: none !important;
            visibility: hidden !important;
        }
    }
    
    /* WEB-ONLY STYLES */
    @media screen {
        .print-only {
            display: none !important;
        }
        
        .web-header {
            animation: fadeInDown 0.6s ease-out;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }
</style>
</head>
<body>
    

<?php
$checkin = new DateTime($reservasi['tglcheckin']);
$checkout = new DateTime($reservasi['tglcheckout']);
$interval = $checkin->diff($checkout);
$lamaMenginap = $interval->days;
?>

<div class="container-fluid faktur-container">
    <!-- Web Header - Hidden on Print -->
    <div class="web-header no-print text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Faktur Reservasi Digital</h1>
        <p class="text-gray-600">Wisma Citra Sabaleh - Sistem Manajemen Hotel</p>
    </div>
    
    <div class="max-w-4xl mx-auto">
        <!-- Faktur -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 print-area">
            <!-- Faktur Header -->
            <div class="bg-teal-700 p-4 text-white">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <img src="<?= base_url('/assets/img/citra11.png') ?>" alt="Logo" class="h-16 mr-3">
                        <div>
                            <h1 class="text-xl font-bold">FAKTUR RESERVASI</h1>
                            <p class="opacity-80 text-sm">Wisma Citra Sabaleh</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-4">
                <!-- Faktur Info -->
                <div class="flex flex-col md:flex-row justify-between mb-4 pb-3 border-b border-gray-200">
                    <div>
                        <p class="text-gray-600 text-xs">Faktur untuk:</p>
                        <h2 class="text-lg font-semibold"><?= $tamu['nama'] ?></h2>
                        <p class="text-gray-700 text-sm"><?= $tamu['alamat'] ?></p>
                        <p class="text-gray-700 text-sm"><?= $tamu['nohp'] ?></p>
                        <p class="text-gray-700 text-sm"><?= $tamu['email'] ?></p>
                    </div>
                    <div class="mt-3 md:mt-0 md:text-right">
                        <div class="mb-1">
                            <p class="text-gray-600 text-xs">Nomor Faktur:</p>
                            <p class="font-semibold text-sm"><?= $reservasi['idbooking'] ?></p>
                        </div>
                        <div class="mb-1">
                            <p class="text-gray-600 text-xs">Tanggal Faktur:</p>
                            <p class="font-semibold text-sm"><?= date('d F Y') ?></p>
                        </div>
                        <div class="mb-1">
                            <p class="text-gray-600 text-xs">Status:</p>
                            <span class="inline-block px-2 py-1 rounded-full text-white font-bold text-xs
                                <?php
                                    if ($reservasi['status'] == 'diproses') echo 'bg-yellow-500';
                                    else if ($reservasi['status'] == 'diterima') echo 'bg-green-600';
                                    else if ($reservasi['status'] == 'ditolak') echo 'bg-red-600';
                                    else if ($reservasi['status'] == 'selesai') echo 'bg-green-600';
                                    else echo 'bg-gray-500';
                                ?>">
                                <?= strtoupper($reservasi['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Details -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-teal-700 mb-2">Detail Reservasi</h3>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600 text-xs">ID Booking:</p>
                                <p class="font-medium"><?= $reservasi['idbooking'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Check-in:</p>
                                <p class="font-medium"><?= date('d F Y', strtotime($reservasi['tglcheckin'])) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Check-out:</p>
                                <p class="font-medium"><?= date('d F Y', strtotime($reservasi['tglcheckout'])) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Lama Menginap:</p>
                                <p class="font-medium"><?= $lamaMenginap ?> malam</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Tipe Reservasi:</p>
                                <p class="font-medium"><?= $reservasi['online'] == 1 ? 'Online' : 'Offline' ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Tipe Pembayaran:</p>
                                <p class="font-medium"><?= $reservasi['tipe'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Invoice Items -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-teal-700 mb-2">Rincian Biaya</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 py-2 text-left text-gray-700">Deskripsi</th>
                                    <th class="px-2 py-2 text-right text-gray-700 w-1/3">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-2 py-2">
                                        <p class="font-medium"><?= $kamar['nama'] ?></p>
                                        <p class="text-xs text-gray-600"><?= $lamaMenginap ?> malam x Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></p>
                                    </td>
                                    <td class="px-2 py-2 text-right font-medium">Rp <?= number_format($lamaMenginap * $kamar['harga'], 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-2 py-2 text-right font-semibold">Total</td>
                                    <td class="px-2 py-2 text-right font-bold text-teal-700" id="grandtotal">Rp <?= number_format($lamaMenginap * $kamar['harga'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 text-right font-semibold">Total Bayar (DP)</td>
                                    <td class="px-2 py-2 text-right font-bold text-green-700">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 text-right font-semibold">Sisa Bayar</td>
                                    <td class="px-2 py-2 text-right font-bold text-red-600">Rp <?= number_format($lamaMenginap * $kamar['harga'] - $reservasi['totalbayar'], 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Payment Summary Compact -->
                <div class="mb-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <div class="grid grid-cols-3 gap-2 text-center text-sm">
                            <div>
                                <p class="text-gray-600 text-xs">Total Kamar</p>
                                <p class="font-bold text-teal-700">Rp <?= number_format($lamaMenginap * $kamar['harga'], 0, ',', '.') ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Sudah Dibayar</p>
                                <p class="font-bold text-green-600">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs">Sisa Bayar</p>
                                <p class="font-bold text-red-600">Rp <?= number_format($lamaMenginap * $kamar['harga'] - $reservasi['totalbayar'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Catatan Penting - Compact -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-teal-700 mb-2">Catatan Penting</h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <ul class="list-disc list-inside text-xs text-gray-700 space-y-0">
                            <li>Reservasi ini merupakan booking awal, sisa bayar akan diselesaikan saat check-in</li>
                            <li>Harap datang tepat waktu sesuai jadwal check-in yang telah ditentukan</li>
                            <li>Pembatalan reservasi dapat dilakukan maksimal H-1 sebelum check-in</li>
                            <li>Simpan faktur ini sebagai bukti reservasi yang sah</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Signature -->
                <div class="mt-4 pt-3 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-center md:text-left">
                            <h4 class="font-semibold text-gray-800 text-sm">Wisma Citra Sabaleh</h4>
                            <p class="text-xs text-gray-600">Jl. Kp. Jawa Dalam IV Jl. Kp. Jawa Dalam No.21, Kec. Padang Barat, Kota Padang, Sumatera Barat 52112</p>
                            <p class="text-xs text-gray-600">Telp: +62 812-3456-7890</p>
                        </div>
                        <div class="mt-3 md:mt-0 text-center">
                            <div class="border-b border-gray-300 pb-1 mb-1">
                                <img src="<?= base_url('/assets/img/acc.png') ?>" alt="Tanda Tangan" class="h-16 mx-auto">
                            </div>
                            <p class="font-medium text-xs">Admin Hotel</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Print Footer - Only Visible When Printing -->
            <div class="print-only text-center mt-2" style="display: none;">
                <p class="text-xs text-gray-500">Dokumen ini dicetak secara digital dari Sistem Manajemen Wisma Citra Sabaleh</p>
                <p class="text-xs text-gray-500">Tanggal Cetak: <?= date('d F Y H:i:s') ?> WIB</p>
            </div>
        </div>
        
        <!-- Action Buttons - Web Only -->
        <div class="action-buttons no-print text-center mb-4 p-4 bg-gray-50 rounded-lg">
            <div class="flex flex-wrap justify-center gap-3">
                <button onclick="window.print()" class="btn-print bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors shadow-md">
                    <i class="fas fa-print mr-2"></i> Cetak Faktur
                </button>
                <a href="<?= base_url('online/booking/history') ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#btnCancel').on('click', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Batalkan Reservasi?',
            text: "Reservasi akan dibatalkan dan status kamar akan diperbarui!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('reservasi/cancel') ?>/' + id,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Dibatalkan!',
                                'Reservasi telah dibatalkan.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'Gagal membatalkan reservasi',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan: ' + error,
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
</body>
</html> 
