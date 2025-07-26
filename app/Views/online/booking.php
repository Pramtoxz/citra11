<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kamar - Wisma Citra Sabaleh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                            950: '#500724',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(50px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 25%, #9333ea  50%, #7c3aed 75%, #6b21a8 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .step-active {
            background: linear-gradient(135deg, #ec4899, #be185d);
        }
        .step-completed {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        
        /* Calendar Styles */
        .calendar {
            max-width: 100%;
            margin: 0 auto;
        }
        
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 0 1rem;
        }
        
        .calendar-nav {
            background: rgba(99, 102, 241, 0.8);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .calendar-nav:hover {
            background: rgba(99, 102, 241, 0.9);
            transform: scale(1.05);
        }
        
        .calendar-title {
            color: #1f2937;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0 1rem;
            min-width: 200px;
            text-align: center;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            background: rgba(229, 231, 235, 0.5);
            padding: 1rem;
            border-radius: 1rem;
        }
        
        .calendar-day-header {
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-weight: 600;
            color: #d97706;
            background: rgba(251, 191, 36, 0.3);
            border-radius: 0.5rem;
            font-size: 0.9rem;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            cursor: default;
            transition: all 0.2s ease;
            position: relative;
            font-weight: 500;
            min-height: 40px;
        }
        
        .calendar-day:hover {
            transform: scale(1.05);
            z-index: 10;
        }
        
        /* Calendar Day States */
        .calendar-day.other-month {
            color: rgba(156, 163, 175, 0.6);
            background: rgba(243, 244, 246, 0.5);
            cursor: not-allowed;
        }
        
        .calendar-day.past {
            color: rgba(156, 163, 175, 0.7);
            background: rgba(209, 213, 219, 0.3);
            cursor: not-allowed;
        }
        
        .calendar-day.available {
            color: #065f46;
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            font-weight: 600;
        }
        
        .calendar-day.available:hover {
            color: white;
            background: rgba(34, 197, 94, 0.6);
            box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3);
        }
        
        .calendar-day.occupied {
            color: #991b1b;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            cursor: not-allowed;
            font-weight: 600;
        }
        
        .calendar-day.checkin-selected {
            color: white;
            background: rgba(59, 130, 246, 0.8);
            border: 2px solid #3b82f6;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
            font-weight: 700;
        }
        
        .calendar-day.checkout-selected {
            color: white;
            background: rgba(147, 51, 234, 0.8);
            border: 2px solid #9333ea;
            box-shadow: 0 4px 20px rgba(147, 51, 234, 0.4);
            font-weight: 700;
        }
        
        .calendar-day.in-range {
            color: #92400e;
            background: rgba(251, 191, 36, 0.3);
            border: 1px solid rgba(251, 191, 36, 0.5);
            font-weight: 600;
        }
        
        .calendar-day.today {
            border: 2px solid #ec4899;
            font-weight: 700;
            color: #1f2937;
        }
        
        /* Tooltip for occupied dates */
        .calendar-day[title] {
            position: relative;
        }
        
        .calendar-day[title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .calendar-grid {
                gap: 1px;
                padding: 0.5rem;
            }
            
            .calendar-day {
                font-size: 0.9rem;
                min-height: 35px;
            }
            
            .calendar-day-header {
                padding: 0.5rem 0.25rem;
                font-size: 0.8rem;
            }
            
            .calendar-title {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 25%, #9333ea 50%, #7c3aed 75%, #6b21a8 100%); backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-white font-bold text-2xl animate-fade-in">
                    <i class="fas fa-hotel mr-2"></i>Citra Sabaleh
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= site_url('/') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-home mr-1"></i> Homepage
                    </a>
                    <a href="<?= site_url('online') ?>" class="text-white hover:text-pink-200 transition duration-300">
                        <i class="fas fa-dashboard mr-1"></i> Dashboard
                    </a>
                    <div class="text-white">
                        <i class="fas fa-user mr-2"></i>
                        <?= session()->get('name') ?? session()->get('username') ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 pb-10">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="text-center mb-12 animate-slide-up">
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-4">
                    Booking Kamar
                </h1>
                <p class="text-xl text-pink-100">
                    Pilih kamar impian Anda dengan mudah dan cepat
                </p>
            </div>

            <!-- Step Indicator -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="flex items-center justify-between">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div id="step1-indicator" class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold step-active">
                            1
                        </div>
                        <span class="text-gray-800 text-sm mt-2">Pilih Tanggal</span>
                    </div>
                    <div class="flex-1 h-1 bg-white/20 mx-4"></div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div id="step2-indicator" class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold bg-white/20">
                            2
                        </div>
                        <span class="text-gray-800 text-sm mt-2">Pilih Kamar</span>
                    </div>
                    <div class="flex-1 h-1 bg-white/20 mx-4"></div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div id="step3-indicator" class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold bg-white/20">
                            3
                        </div>
                        <span class="text-gray-800 text-sm mt-2">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="max-w-6xl mx-auto">
                <!-- Step 1: Date Selection -->
                <div id="step1" class="glass-effect rounded-3xl p-8 mb-8 animate-slide-up">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Pilih Tanggal Menginap
                    </h2>
                    
                    <!-- Calendar Legend -->
                    <div class="flex flex-wrap justify-center gap-4 mb-6">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-400 rounded mr-2"></div>
                            <span class="text-gray-700 text-sm">Tersedia</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-400 rounded mr-2"></div>
                            <span class="text-gray-700 text-sm">Terisi</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-400 rounded mr-2"></div>
                            <span class="text-gray-700 text-sm">Check-in</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-purple-400 rounded mr-2"></div>
                            <span class="text-gray-700 text-sm">Check-out</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-yellow-400 rounded mr-2"></div>
                            <span class="text-gray-700 text-sm">Range Dipilih</span>
                        </div>
                    </div>
                    
                    <!-- Date Selection Form -->
                    <form id="dateForm" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Check-in Date -->
                        <div class="space-y-2">
                            <label class="block text-gray-800 font-semibold">
                                <i class="fas fa-calendar-plus mr-2 text-primary-500"></i>
                                Tanggal Check-in
                            </label>
                            <input type="date" 
                                   id="checkin_date" 
                                   name="checkin_date"
                                   required
                                   min="<?= date('Y-m-d') ?>"
                                   onchange="updateCalendarView()"
                                   class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        
                        <!-- Check-out Date -->
                        <div class="space-y-2">
                            <label class="block text-gray-800 font-semibold">
                                <i class="fas fa-calendar-minus mr-2 text-primary-500"></i>
                                Tanggal Check-out
                            </label>
                            <input type="date" 
                                   id="checkout_date" 
                                   name="checkout_date"
                                   required
                                   min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                   onchange="updateCalendarView()"
                                   class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                        
                        <!-- Payment Type -->
                        <div class="space-y-2">
                            <label class="block text-gray-800 font-semibold">
                                <i class="fas fa-credit-card mr-2 text-primary-500"></i>
                                Tipe Pembayaran
                            </label>
                            <select id="tipe_bayar" 
                                    name="tipe_bayar"
                                    onchange="calculatePayment()"
                                    class="w-full px-4 py-3 rounded-xl bg-white border border-gray-300 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="dp" class="text-gray-800">DP (Uang Muka)</option>
                                <option value="lunas" class="text-gray-800">Lunas</option>
                            </select>
                        </div>
                    </form>
                    
                    <!-- Calendar as Visual Guide -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Panduan Ketersediaan Kamar
                        </h3>
                        <div id="calendar-container" class="max-w-4xl mx-auto">
                            <!-- Calendar akan di-generate oleh JavaScript -->
                        </div>
                    </div>
                    
                    <div class="text-center mt-8">
                        <button onclick="searchRooms()" 
                                class="bg-white text-primary-600 px-12 py-4 rounded-xl font-bold text-xl hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                            <i class="fas fa-search mr-2"></i>
                            Cari Kamar Tersedia
                        </button>
                    </div>
                </div>

                <!-- Step 2: Room Selection -->
                <div id="step2" class="glass-effect rounded-3xl p-8 mb-8 animate-slide-up hidden">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-bed mr-2"></i>
                        Pilih Kamar
                    </h2>
                    
                    <div id="available-rooms" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Room cards will be loaded here -->
                    </div>
                    
                    <div class="text-center mt-8">
                        <button onclick="goToStep(1)" class="bg-gray-200 text-gray-800 px-8 py-3 rounded-xl font-semibold hover:bg-gray-300 transition duration-300 mr-4">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </button>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div id="step3" class="glass-effect rounded-3xl p-8 mb-8 animate-slide-up hidden">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Konfirmasi Booking
                    </h2>
                    
                    <div id="booking-summary" class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mb-8">
                        <!-- Booking summary will be loaded here -->
                    </div>
                    
                    <div class="text-center">
                        <button onclick="goToStep(2)" class="bg-gray-200 text-gray-800 px-8 py-3 rounded-xl font-semibold hover:bg-gray-300 transition duration-300 mr-4">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </button>
                        <button onclick="confirmBooking()" class="bg-white text-primary-600 px-12 py-4 rounded-xl font-bold text-xl hover:bg-pink-50 transform hover:scale-105 transition duration-300 shadow-xl">
                            <i class="fas fa-credit-card mr-2"></i>
                            Konfirmasi Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let currentStep = 1;
        let selectedRoom = null;
        let bookingData = {};

        // Set default dates and load initial rooms
        document.addEventListener('DOMContentLoaded', function() {
            // Set timezone to Asia/Jakarta
            const today = new Date();
            const jakartaOffset = 7 * 60; // GMT+7 in minutes
            const utc1 = today.getTime() + (today.getTimezoneOffset() * 60000);
            const jakartaTime = new Date(utc1 + (jakartaOffset * 60000));
            
            const tomorrow = new Date(jakartaTime);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            // Format dates as YYYY-MM-DD for input date
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            document.getElementById('checkin_date').value = formatDate(jakartaTime);
            document.getElementById('checkout_date').value = formatDate(tomorrow);
            
            // Update minimum dates
            document.getElementById('checkin_date').min = formatDate(jakartaTime);
            document.getElementById('checkout_date').min = formatDate(tomorrow);
            
            // Show initial rooms for debugging
            console.log('Initial kamar data from PHP:', <?= $kamar_json ?>);
        });

        // Date input initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date for inputs
            const today = new Date().toISOString().split('T')[0];
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            document.getElementById('checkin_date').min = today;
            document.getElementById('checkout_date').min = tomorrow.toISOString().split('T')[0];
        });

        // Load available rooms (data from database)
        function loadAvailableRooms(availableRooms = null) {
            const roomsContainer = document.getElementById('available-rooms');
            
            // Use provided rooms or fallback to all rooms from database
            const rooms = availableRooms || <?= $kamar_json ?>;
            
            // Debug: Log room data
            console.log('Room data:', rooms);

            roomsContainer.innerHTML = '';
            
            if (!rooms || rooms.length === 0) {
                roomsContainer.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-bed text-6xl text-pink-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Kamar Tersedia</h3>
                        <p class="text-gray-600">Coba ubah tanggal atau kriteria pencarian Anda</p>
                    </div>
                `;
                return;
            }
            
            rooms.forEach(room => {
                // Debug: Log each room's cover URL
                console.log(`Room ${room.nama} cover URL:`, room.cover);
                
                const roomCard = `
                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200 hover:scale-105 transform transition duration-300">
                        <div class="relative">
                            <img src="${room.cover}" 
                                 alt="${room.nama}" 
                                 class="w-full h-48 object-cover"
                                 onload="console.log('Image loaded for ${room.nama}:', this.src);"
                                 onerror="console.log('Image failed for ${room.nama}:', this.src); this.src='https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=500&h=300'; this.onerror=null;">
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <i class="fas fa-check mr-1"></i>Available
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">${room.nama}</h3>
                            <p class="text-gray-600 mb-4 text-sm">${room.deskripsi}</p>
                            <div class="mb-4">
                                <div class="text-gray-800 mb-2">
                                    <span class="text-2xl font-bold">Rp ${room.harga.toLocaleString()}</span>
                                    <span class="text-gray-600">/malam</span>
                                </div>
                                ${room.dp > 0 ? `
                                <div class="text-gray-600 text-sm">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    DP: Rp ${room.dp.toLocaleString()}
                                </div>
                                ` : ''}
                            </div>
                            <button onclick="selectRoom('${room.id}', '${room.nama}', ${room.harga}, ${room.dp})" 
                                    class="w-full bg-primary-500 text-white px-4 py-3 rounded-xl font-bold hover:bg-primary-600 transition duration-300">
                                <i class="fas fa-hand-pointer mr-2"></i>Pilih Kamar
                            </button>
                        </div>
                    </div>
                `;
                roomsContainer.innerHTML += roomCard;
            });
        }

        // Select room
        function selectRoom(roomId, roomName, roomPrice, roomDp) {
            selectedRoom = {
                id: roomId,
                nama: roomName,
                harga: roomPrice,
                dp: roomDp || 0
            };

            bookingData.room = selectedRoom;
            
            // Hitung pembayaran berdasarkan tipe
            calculatePayment();
            
            Swal.fire({
                title: 'Kamar Dipilih!',
                text: `Anda memilih ${roomName}`,
                icon: 'success',
                confirmButtonColor: '#ec4899',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                loadBookingSummary();
                goToStep(3);
            });
        }

        // Calculate payment based on type
        function calculatePayment() {
            if (!selectedRoom) return;
            
            const checkinDate = new Date(bookingData.checkin_date);
            const checkoutDate = new Date(bookingData.checkout_date);
            const nights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24));
            const totalHarga = selectedRoom.harga * nights;
            
            const tipeBayar = document.getElementById('tipe_bayar').value;
            
            if (tipeBayar === 'dp' && selectedRoom.dp > 0) {
                bookingData.total_price = selectedRoom.dp;
                bookingData.sisa_bayar = totalHarga - selectedRoom.dp;
                bookingData.payment_type = 'dp';
            } else {
                bookingData.total_price = totalHarga;
                bookingData.sisa_bayar = 0;
                bookingData.payment_type = 'lunas';
            }
            
            bookingData.nights = nights;
            bookingData.total_harga = totalHarga;
        }

        // Load booking summary
        function loadBookingSummary() {
            const summaryContainer = document.getElementById('booking-summary');
            const checkinDate = new Date(bookingData.checkin_date);
            const checkoutDate = new Date(bookingData.checkout_date);
            
            // Re-calculate untuk memastikan data terbaru
            calculatePayment();

            const paymentInfo = bookingData.payment_type === 'dp' ? 
                `<p class="text-green-600 font-semibold"><i class="fas fa-credit-card mr-2"></i> DP (Uang Muka)</p>
                 <p class="text-gray-600 text-sm">Sisa bayar saat check-in: Rp ${bookingData.sisa_bayar.toLocaleString()}</p>` :
                `<p class="text-blue-600 font-semibold"><i class="fas fa-check-circle mr-2"></i> Pembayaran Lunas</p>`;

            summaryContainer.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Detail Kamar</h4>
                        <div class="space-y-2 text-gray-700">
                            <p><i class="fas fa-bed mr-2"></i> ${selectedRoom.nama}</p>
                            <p><i class="fas fa-money-bill mr-2"></i> Rp ${selectedRoom.harga.toLocaleString()}/malam</p>
                            ${selectedRoom.dp > 0 ? `<p><i class="fas fa-percentage mr-2"></i> DP: Rp ${selectedRoom.dp.toLocaleString()}</p>` : ''}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Detail Booking</h4>
                        <div class="space-y-2 text-gray-700">
                            <p><i class="fas fa-calendar-plus mr-2"></i> Check-in: ${checkinDate.toLocaleDateString('id-ID')}</p>
                            <p><i class="fas fa-calendar-minus mr-2"></i> Check-out: ${checkoutDate.toLocaleDateString('id-ID')}</p>
                            <p><i class="fas fa-moon mr-2"></i> ${bookingData.nights} Malam</p>
                            <p><i class="fas fa-calculator mr-2"></i> Subtotal: Rp ${bookingData.total_harga.toLocaleString()}</p>
                            ${paymentInfo}
                            <div class="border-t border-gray-300 pt-3 mt-3">
                                <p class="text-xl font-bold text-green-600">
                                    <i class="fas fa-money-check mr-2"></i> 
                                    Bayar Sekarang: Rp ${bookingData.total_price.toLocaleString()}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Confirm booking
        function confirmBooking() {
            Swal.fire({
                title: 'Konfirmasi Booking',
                text: 'Apakah Anda yakin ingin melanjutkan booking ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ec4899',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Booking!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processBooking();
                }
            });
        }

        // Process booking
        function processBooking() {
            Swal.fire({
                title: 'Memproses Booking...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Prepare data untuk dikirim ke server
            const bookingDataToSend = {
                checkin_date: bookingData.checkin_date,
                checkout_date: bookingData.checkout_date,
                room_id: selectedRoom.id,
                tipe_bayar: bookingData.payment_type,
                total_price: bookingData.total_price,
                sisa_bayar: bookingData.sisa_bayar || 0,
                is_dp: bookingData.payment_type === 'dp' ? 1 : 0
            };

            // AJAX call to process booking
            fetch('<?= site_url('online/booking/save') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(bookingDataToSend)
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Booking Berhasil!',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                                <p class="text-gray-600 mb-4">Booking Anda telah berhasil diproses!</p>
                                <p class="text-sm text-blue-600 mb-2">ID Booking: <strong>${data.booking_id}</strong></p>
                                <p class="text-sm text-red-600 font-bold">⏰ Silakan upload bukti pembayaran dalam 15 menit</p>
                            </div>
                        `,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Upload Pembayaran',
                        cancelButtonText: 'Nanti Saja',
                        confirmButtonColor: '#ec4899',
                        cancelButtonColor: '#6b7280'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `<?= site_url('online/booking/payment/') ?>${data.booking_id}`;
                        } else {
                            window.location.href = '<?= site_url('online') ?>';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Booking Gagal!',
                        text: data.message || 'Terjadi kesalahan saat memproses booking',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        }

        // Navigation between steps
        function goToStep(step) {
            // Hide all steps
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');

            // Reset step indicators
            document.getElementById('step1-indicator').classList.remove('step-active', 'step-completed');
            document.getElementById('step2-indicator').classList.remove('step-active', 'step-completed');
            document.getElementById('step3-indicator').classList.remove('step-active', 'step-completed');

            // Show current step
            document.getElementById(`step${step}`).classList.remove('hidden');
            document.getElementById(`step${step}-indicator`).classList.add('step-active');

            // Mark previous steps as completed
            for (let i = 1; i < step; i++) {
                document.getElementById(`step${i}-indicator`).classList.add('step-completed');
            }

            currentStep = step;
        }

        // Calendar variables (view-only)
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let occupiedDates = {};
        let viewCheckinDate = null;
        let viewCheckoutDate = null;
        
        // Initialize calendar on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadOccupiedDates();
        });
        
        // Load occupied dates from API
        async function loadOccupiedDates() {
            try {
                const response = await fetch('<?= site_url('online/booking/occupied-dates') ?>');
                const data = await response.json();
                
                if (data.status === 'success') {
                    occupiedDates = data.occupied_dates;
                    console.log('Occupied dates loaded:', occupiedDates);
                    generateCalendar();
                } else {
                    console.error('Failed to load occupied dates:', data.message);
                    generateCalendar(); // Generate anyway
                }
            } catch (error) {
                console.error('Error loading occupied dates:', error);
                generateCalendar(); // Generate anyway
            }
        }
        
        // Generate calendar
        function generateCalendar() {
            const container = document.getElementById('calendar-container');
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const dayNames = ['Ming', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const today = new Date();
            
            let calendarHTML = `
                <div class="calendar">
                    <div class="calendar-header">
                        <button class="calendar-nav" onclick="changeMonth(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="calendar-title">
                            ${monthNames[currentMonth]} ${currentYear}
                        </div>
                        <button class="calendar-nav" onclick="changeMonth(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="calendar-grid">
            `;
            
            // Add day headers
            dayNames.forEach(day => {
                calendarHTML += `<div class="calendar-day-header">${day}</div>`;
            });
            
            // Add empty cells for days before month starts
            for (let i = 0; i < firstDay; i++) {
                calendarHTML += `<div class="calendar-day other-month"></div>`;
            }
            
                         // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(currentYear, currentMonth, day);
                const dateStr = formatDate(date);
                const isPast = date < today.setHours(0, 0, 0, 0);
                const isToday = date.toDateString() === new Date().toDateString();
                const isOccupied = occupiedDates[dateStr] && occupiedDates[dateStr].length > 0;
                const isCheckinSelected = viewCheckinDate && formatDate(viewCheckinDate) === dateStr;
                const isCheckoutSelected = viewCheckoutDate && formatDate(viewCheckoutDate) === dateStr;
                const isInRange = isDateInRange(date);
                
                let classes = ['calendar-day'];
                let title = '';
                
                if (isPast) {
                    classes.push('past');
                    title = 'Tanggal sudah lewat';
                } else if (isOccupied) {
                    classes.push('occupied');
                    
                    // Create tooltip with occupied room info
                    const rooms = occupiedDates[dateStr].map(r => r.kamar_nama).join(', ');
                    title = `Terisi: ${rooms}`;
                } else {
                    classes.push('available');
                    title = 'Tersedia untuk booking';
                }
                
                if (isToday) classes.push('today');
                if (isCheckinSelected) classes.push('checkin-selected');
                if (isCheckoutSelected) classes.push('checkout-selected');
                if (isInRange) classes.push('in-range');
                
                calendarHTML += `
                    <div class="${classes.join(' ')}" 
                         ${title ? `title="${title}"` : ''}>
                        ${day}
                    </div>
                `;
            }
            
            calendarHTML += `
                    </div>
                </div>
            `;
            
            container.innerHTML = calendarHTML;
        }
        
        // Change month
        function changeMonth(direction) {
            currentMonth += direction;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar();
        }
        
        // Update calendar view based on input date changes
        function updateCalendarView() {
            const checkinInput = document.getElementById('checkin_date').value;
            const checkoutInput = document.getElementById('checkout_date').value;
            
            viewCheckinDate = checkinInput ? new Date(checkinInput) : null;
            viewCheckoutDate = checkoutInput ? new Date(checkoutInput) : null;
            
            // Update calendar visual
            generateCalendar();
        }
        
        // Check if date is in selected range (visual only)
        function isDateInRange(date) {
            if (!viewCheckinDate || !viewCheckoutDate) return false;
            return date > viewCheckinDate && date < viewCheckoutDate;
        }
        
        // Format date as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        // Format date in Indonesian
        function formatDateIndonesian(date) {
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            const dayName = days[date.getDay()];
            const day = date.getDate();
            const month = months[date.getMonth()];
            const year = date.getFullYear();
            
            return `${dayName}, ${day} ${month} ${year}`;
        }

        // Search rooms using input date
        function searchRooms() {
            const checkinDate = document.getElementById('checkin_date').value;
            const checkoutDate = document.getElementById('checkout_date').value;
            const tipeBayar = document.getElementById('tipe_bayar').value;

            if (!checkinDate || !checkoutDate) {
                Swal.fire({
                    title: 'Data Tidak Lengkap',
                    text: 'Silakan pilih tanggal check-in dan check-out terlebih dahulu',
                    icon: 'warning',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }

            if (new Date(checkinDate) >= new Date(checkoutDate)) {
                Swal.fire({
                    title: 'Tanggal Tidak Valid',
                    text: 'Tanggal check-out harus setelah tanggal check-in',
                    icon: 'warning',
                    confirmButtonColor: '#ec4899'
                });
                return;
            }

            bookingData = {
                checkin_date: checkinDate,
                checkout_date: checkoutDate,
                tipe_bayar: tipeBayar
            };

            // Update calendar view to show selected dates
            updateCalendarView();

            // Show loading
            Swal.fire({
                title: 'Mencari Kamar...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX call to check availability
            fetch(`<?= site_url('online/booking/check-availability') ?>?checkin_date=${checkinDate}&checkout_date=${checkoutDate}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                
                if (data.status === 'success') {
                    if (data.available_rooms && data.available_rooms.length > 0) {
                        loadAvailableRooms(data.available_rooms);
                        goToStep(2);
                    } else {
                        Swal.fire({
                            title: 'Tidak Ada Kamar Tersedia',
                            text: 'Maaf, tidak ada kamar yang tersedia untuk tanggal yang dipilih. Silakan pilih tanggal lain.',
                            icon: 'info',
                            confirmButtonColor: '#ec4899'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat mencari kamar',
                        icon: 'error',
                        confirmButtonColor: '#ec4899'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonColor: '#ec4899'
                });
            });
        }

        // Update step indicator colors
        document.getElementById('step1-indicator').classList.add('bg-white/20');
        document.getElementById('step2-indicator').classList.add('bg-white/20');
        document.getElementById('step3-indicator').classList.add('bg-white/20');
    </script>
</body>
</html> 