<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
<!-- Tambahkan CDN Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    teal: {
                        50: '#f0fdfa',
                        100: '#ccfbf1',
                        200: '#99f6e4',
                        300: '#5eead4',
                        400: '#2dd4bf',
                        500: '#14b8a6',
                        600: '#0d9488',
                        700: '#0f766e',
                        800: '#115e59',
                        900: '#134e4a',
                        950: '#042f2e',
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
    .faktur-container {
        font-family: 'Poppins', sans-serif;
    }
    @media print {
        .no-print {
            display: none !important;
        }
        .print-area {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        body {
            padding: 0;
            margin: 0;
            background: white;
        }
        /* Pengaturan ukuran kertas A4 yang tepat */
        @page {
            size: A4 portrait;
            margin: 5mm;
        }
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .max-w-4xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .print-area {
            width: 100%;
            height: 100%;
            page-break-inside: avoid;
            page-break-after: always;
        }
        /* Mengurangi ukuran font dan padding untuk menghemat ruang */
        .p-6, .md\:p-8 {
            padding: 0.75rem !important;
        }
        .text-2xl {
            font-size: 1.25rem !important;
        }
        .text-xl {
            font-size: 1.1rem !important;
        }
        .text-lg {
            font-size: 1rem !important;
        }
        .px-4 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
        .py-4, .py-3 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }
        .mb-8 {
            margin-bottom: 0.75rem !important;
        }
        .mb-4 {
            margin-bottom: 0.5rem !important;
        }
        /* Atur tinggi tanda tangan lebih kecil */
        .h-24, .md\:h-32 {
            height: 4rem !important;
        }
        /* Pastikan konten muat dalam satu halaman */
        table {
            font-size: 0.85rem !important;
        }
        
        /* Memastikan layout tetap dua kolom saat dicetak */
        .md\:flex-row {
            flex-direction: row !important;
        }
        .md\:text-right {
            text-align: right !important;
        }
        .md\:mt-0 {
            margin-top: 0 !important;
        }
        .flex-col {
            flex-direction: row !important;
        }
        
        /* Memastikan tata letak konten dalam dua kolom */
        .flex {
            display: flex !important;
        }
        .justify-between {
            justify-content: space-between !important;
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
    <div class="max-w-4xl mx-auto">
        <!-- Faktur -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 print-area">
            <!-- Faktur Header -->
            <div class="bg-teal-700 p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">FAKTUR RESERVASI</h1>
                        <p class="opacity-80 mt-1">Hotel Citra 11</p>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-hotel text-white text-2xl mr-2"></i>
                        <span class="text-xl font-semibold">CITRA 11</span>
                    </div>
                </div>
            </div>
            
            <div class="p-6 md:p-8">
                <!-- Faktur Info -->
                <div class="flex flex-col md:flex-row justify-between mb-8 pb-6 border-b border-gray-200">
                    <div>
                        <p class="text-gray-600 text-sm">Faktur untuk:</p>
                        <h2 class="text-xl font-semibold"><?= $tamu['nama'] ?></h2>
                        <p class="text-gray-700"><?= $tamu['alamat'] ?></p>
                        <p class="text-gray-700"><?= $tamu['nohp'] ?></p>
                        <p class="text-gray-700"><?= $tamu['email'] ?></p>
                    </div>
                    <div class="mt-4 md:mt-0 md:text-right">
                        <div class="mb-2">
                            <p class="text-gray-600 text-sm">Nomor Faktur:</p>
                            <p class="font-semibold"><?= $reservasi['idbooking'] ?></p>
                        </div>
                        <div class="mb-2">
                            <p class="text-gray-600 text-sm">Tanggal Faktur:</p>
                            <p class="font-semibold"><?= date('d F Y') ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Details -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4">Detail Reservasi</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-gray-600 text-sm">ID Booking:</p>
                                <p class="font-medium"><?= $reservasi['idbooking'] ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Check-in:</p>
                                <p class="font-medium"><?= date('d F Y', strtotime($reservasi['tglcheckin'])) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Check-out:</p>
                                <p class="font-medium"><?= date('d F Y', strtotime($reservasi['tglcheckout'])) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Lama Menginap:</p>
                                <p class="font-medium"><?= $lamaMenginap ?> malam</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Tipe Reservasi:</p>
                                <p class="font-medium"><?= $reservasi['online'] == 1 ? 'Online' : 'Offline' ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Tipe Pembayaran:</p>
                                <p class="font-medium"><?= $reservasi['tipe'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Invoice Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4">Rincian Biaya</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-gray-700">Deskripsi</th>
                                    <th class="px-4 py-3 text-right text-gray-700 w-1/4">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4">
                                        <div>
                                            <p class="font-medium"><?= $kamar['nama'] ?></p>
                                            <p class="text-sm text-gray-600"><?= $lamaMenginap ?> malam x Rp <?= number_format($kamar['harga'], 0, ',', '.') ?></p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-right font-medium">Rp <?= number_format($lamaMenginap * $kamar['harga'], 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td class="px-4 py-3 text-right font-semibold">Total</td>
                                    <td class="px-4 py-3 text-right font-bold text-teal-700">Rp <?= number_format($lamaMenginap * $kamar['harga'], 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-right font-semibold">Total Dibayar</td>
                                    <td class="px-4 py-3 text-right font-bold text-green-700">Rp <?= number_format($reservasi['totalbayar'], 0, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                
                <!-- Signature -->
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h4 class="font-semibold text-gray-800">Hotel Citra 11</h4>
                            <p class="text-sm text-gray-600">Jl. Raya Citra No. 11, Surabaya</p>
                            <p class="text-sm text-gray-600">Telp: +62 812-3456-7890</p>
                        </div>
                        <div class="mt-6 md:mt-0 text-center">
                            <div class="border-b border-gray-300 pb-2 mb-2">
                                <img src="<?= base_url('/assets/img/acc.png') ?>" alt="Tanda Tangan" class="h-24 md:h-32 mx-auto">
                            </div>
                            <p class="font-medium">Admin Hotel</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 no-print mb-4">
            <button onclick="window.print()" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                <i class="fas fa-print mr-2"></i> Cetak Faktur
            </button>
            <a href="<?= base_url('reservasi') ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Reservasi
            </a>
            <?php if ($reservasi['status'] == 'diproses' || $reservasi['status'] == 'diterima'): ?>
            <button type="button" id="btnCancel" data-id="<?= $reservasi['idbooking'] ?>" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                <i class="fas fa-times-circle mr-2"></i> Batalkan Reservasi
            </button>
            <?php endif; ?>
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