<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Pembayaran - Klinik Gigi</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-area {
                box-shadow: none !important;
                border: 1px solid #ddd;
            }
            body {
                padding: 0;
                margin: 0;
                background: white;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md w-full z-50 no-print">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <a href="<?= base_url() ?>" class="flex items-center space-x-2">
                    <i class="fas fa-tooth text-teal-600 text-3xl"></i>
                    <span class="text-2xl font-bold text-teal-800">KlinikGigi</span>
                </a>
            </div>
            <div>
                <a href="<?= base_url() ?>" class="text-teal-800 hover:text-teal-600 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Faktur -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 print-area">
                <!-- Faktur Header -->
                <div class="bg-teal-700 p-6 text-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold">FAKTUR PEMBAYARAN</h1>
                            <p class="opacity-80 mt-1">Klinik Gigi Sehat Bersinar</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-tooth text-white text-2xl mr-2"></i>
                            <span class="text-xl font-semibold">KlinikGigi</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 md:p-8">
                    <!-- Faktur Info -->
                    <div class="flex flex-col md:flex-row justify-between mb-8 pb-6 border-b border-gray-200">
                        <div>
                            <p class="text-gray-600 text-sm">Faktur untuk:</p>
                            <h2 class="text-xl font-semibold"><?= $booking['pasien_nama'] ?></h2>
                            <p class="text-gray-700"><?= $booking['alamat'] ?></p>
                            <p class="text-gray-700"><?= $booking['nohp'] ?></p>
                        </div>
                        <div class="mt-4 md:mt-0 md:text-right">
                            <div class="mb-2">
                                <p class="text-gray-600 text-sm">Nomor Faktur:</p>
                                <p class="font-semibold"><?= $faktur_id ?></p>
                            </div>
                            <div class="mb-2">
                                <p class="text-gray-600 text-sm">Tanggal Faktur:</p>
                                <p class="font-semibold"><?= date('d F Y', strtotime($tanggal_faktur)) ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Status:</p>
                                <span class="inline-block bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full uppercase">Lunas</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-teal-700 mb-4">Detail Booking</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-600 text-sm">ID Booking:</p>
                                    <p class="font-medium"><?= $booking['idbooking'] ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Tanggal:</p>
                                    <p class="font-medium"><?= date('d F Y', strtotime($booking['tanggal'])) ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Dokter:</p>
                                    <p class="font-medium"><?= $booking['nama_dokter'] ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm">Hari:</p>
                                    <p class="font-medium"><?= $booking['hari'] ?></p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-gray-600 text-sm">Waktu:</p>
                                    <p class="font-medium"><?= substr($booking['waktu_mulai'], 0, 5) ?> - <?= substr($booking['waktu_selesai'], 0, 5) ?></p>
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
                                                <p class="font-medium"><?= $booking['namajenis'] ?></p>
                                                <p class="text-sm text-gray-600">Perawatan gigi dengan dokter <?= $booking['nama_dokter'] ?></p>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-right font-medium">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td class="px-4 py-3 text-right font-semibold">Total</td>
                                        <td class="px-4 py-3 text-right font-bold text-teal-700">Rp <?= number_format($booking['harga'], 0, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Payment Info -->
                    <div class="mb-8 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-teal-700 mb-4">Informasi Pembayaran</h3>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="flex items-start">
                                <div class="text-green-500 mr-3">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-green-800">Pembayaran telah dikonfirmasi</h4>
                                    <p class="text-green-700 text-sm">Terima kasih telah melakukan pembayaran. Silakan datang sesuai jadwal yang telah ditentukan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Notes -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-teal-700 mb-4">Catatan</h3>
                        <ul class="text-sm text-gray-700 space-y-1 list-disc list-inside">
                            <li>Harap datang 15 menit sebelum jadwal yang ditentukan</li>
                            <li>Tunjukkan faktur ini kepada resepsionis saat kunjungan</li>
                            <li>Faktur ini sebagai bukti pembayaran yang sah</li>
                        </ul>
                    </div>
                    
                    <!-- Signature -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-gray-800">Klinik Gigi Sehat Bersinar</h4>
                                <p class="text-sm text-gray-600">Jl. Kesehatan No. 123, Surabaya</p>
                                <p class="text-sm text-gray-600">Telp: +62 812-3456-7890</p>
                            </div>
                            <div class="mt-6 md:mt-0 text-center">
                                <div class="border-b border-gray-300 pb-2 mb-2">
                                    <img src="<?= base_url('public/assets/img/signature.png') ?>" alt="Tanda Tangan" class="h-12 mx-auto">
                                </div>
                                <p class="font-medium">Admin Klinik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4 no-print">
                <button onclick="window.print()" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak Faktur
                </button>
                <a href="<?= base_url() ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center font-medium transition-colors">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-10 no-print">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center items-center mb-4">
                <i class="fas fa-tooth text-teal-400 text-2xl"></i>
                <span class="text-xl font-bold ml-2">KlinikGigi</span>
            </div>
            <p class="text-gray-400">© <?= date('Y') ?> Klinik Gigi Sehat Bersinar. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Automatically show print dialog if URL has print parameter
            if (window.location.search.includes('print=true')) {
                setTimeout(function() {
                    window.print();
                }, 1000);
            }
        });
    </script>
</body>
</html> 