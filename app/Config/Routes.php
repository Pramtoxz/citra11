<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



// Auth Routes
$routes->get('/', 'Home::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Register dengan OTP
$routes->get('auth/register', 'Auth::registerForm');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/verify-register-otp', 'Auth::verifyRegisterOTP');

// Forgot Password dengan OTP
$routes->get('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/forgot-password', 'Auth::forgotPassword');
$routes->post('auth/verify-forgot-password-otp', 'Auth::verifyForgotPasswordOTP');
$routes->post('auth/reset-password', 'Auth::resetPassword');

// Resend OTP
$routes->post('auth/resend-otp', 'Auth::resendOTP');

// Online Booking Routes (for users) - Protected by auth filter and role user
$routes->group('online', ['filter' => 'auth'], function ($routes) {
    $routes->get('lengkapi-data', 'OnlineController::lengkapiData');
    $routes->post('simpan-data-tamu', 'OnlineController::simpanDataTamu');
    $routes->get('/', 'OnlineController::index'); // Dashboard booking utama
    $routes->get('dashboard', 'OnlineController::index'); // Alias untuk dashboard
    $routes->get('booking', 'OnlineController::booking'); // Form booking kamar
    $routes->post('booking/save', 'OnlineController::saveBooking'); // Simpan booking
    $routes->get('booking/check-availability', 'OnlineController::checkAvailability'); // Cek ketersediaan kamar
    $routes->get('booking/occupied-dates', 'OnlineController::getOccupiedDates'); // Ambil tanggal terisi
    $routes->get('booking/history', 'OnlineController::bookingHistory'); // History booking
    $routes->get('booking/detail/(:any)', 'OnlineController::bookingDetail/$1'); // Detail booking
    $routes->get('booking/faktur/(:any)', 'OnlineController::bookingFaktur/$1'); // Faktur booking
    $routes->post('booking/cancel/(:any)', 'OnlineController::cancelBooking/$1'); // Cancel booking
    $routes->get('booking/payment/(:any)', 'OnlineController::paymentUpload/$1'); // Upload pembayaran
    $routes->post('booking/payment/save/(:any)', 'OnlineController::savePayment/$1'); // Simpan bukti pembayaran
    $routes->get('profile', 'OnlineController::profile'); // Profile user
    $routes->post('profile/update', 'OnlineController::updateProfile'); // Update profile
    $routes->get('profile/get-data', 'OnlineController::getProfile'); // Get profile data for modal
    $routes->post('profile/update-complete', 'OnlineController::updateProfileComplete'); // Update complete profile
});

// Admin & Dokter & Pimpinan dashboard (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});


$routes->group('tamu', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'TamuController::index');
    $routes->get('viewTamu', 'TamuController::viewTamu');
    $routes->post('detail', 'TamuController::getTamuDetail');
    $routes->get('formtambah', 'TamuController::formtambah');
    $routes->post('save', 'TamuController::save');
    $routes->get('formedit/(:segment)', 'TamuController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'TamuController::updatedata/$1');
    $routes->get('detail/(:segment)', 'TamuController::detail/$1');
    $routes->post('delete', 'TamuController::delete');
    $routes->post('createUser/(:segment)', 'TamuController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'TamuController::updatePassword/$1');
});

$routes->group('kamar', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'KamarController::index');
    $routes->get('viewKamar', 'KamarController::viewKamar');
    $routes->get('formtambah', 'KamarController::formtambah');
    $routes->post('save', 'KamarController::save');
    $routes->get('formedit/(:segment)', 'KamarController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'KamarController::updatedata/$1');
    $routes->post('delete', 'KamarController::delete');
    $routes->get('detail/(:segment)', 'KamarController::detail/$1');
});

$routes->group('pengeluaran', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PengeluaranController::index');
    $routes->get('viewPengeluaran', 'PengeluaranController::viewPengeluaran');
    $routes->get('formtambah', 'PengeluaranController::formtambah');
    $routes->post('save', 'PengeluaranController::save');
    $routes->get('formedit/(:segment)', 'PengeluaranController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PengeluaranController::updatedata/$1');
    $routes->post('delete', 'PengeluaranController::delete');
    $routes->get('detail/(:segment)', 'PengeluaranController::detail/$1');
});

$routes->group('reservasi', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'ReservasiController::index');
    $routes->get('viewreservasi', 'ReservasiController::viewReservasi');
    $routes->get('formtambah', 'ReservasiController::formtambah');
    $routes->post('save', 'ReservasiController::save');
    $routes->get('formedit/(:segment)', 'ReservasiController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'ReservasiController::updatedata/$1');
    $routes->get('detail/(:segment)', 'ReservasiController::detail/$1');
    $routes->get('gettamu', 'ReservasiController::getTamu');
    $routes->get('getkamar', 'ReservasiController::getKamar');
    $routes->post('delete', 'ReservasiController::delete');
    $routes->get('viewgettamu', 'ReservasiController::viewGetTamu');
    $routes->get('viewgetkamar', 'ReservasiController::viewGetKamar');
    $routes->post('viewgetkamar', 'ReservasiController::viewGetKamar');
    $routes->get('cekbukti/(:segment)', 'ReservasiController::cekbukti/$1');
    $routes->post('updatestatus', 'ReservasiController::updatestatus');

});

$routes->post('reservasi/debugNewId', 'ReservasiController::debugNewId');
$routes->get('reservasi/detail/(:any)', 'ReservasiController::detail/$1');
$routes->post('reservasi/cancel/(:any)', 'ReservasiController::cancel/$1');
$routes->get('reservasi/cekin/(:any)', 'ReservasiController::cekin/$1');

$routes->group('checkin', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'CheckinController::index');
    $routes->get('viewcheckin', 'CheckinController::viewCheckin');
    $routes->get('formtambah', 'CheckinController::formtambah');
    $routes->post('save', 'CheckinController::save');
    $routes->get('formedit/(:segment)', 'CheckinController::formedit/$1');
    $routes->post('updateCheckin', 'CheckinController::updateCheckin');
    $routes->get('detail/(:segment)', 'CheckinController::detail/$1');
    $routes->get('faktur/(:segment)', 'CheckinController::faktur/$1');
    $routes->get('getreservasi', 'CheckinController::getReservasi');
    $routes->get('viewgetreservasi', 'CheckinController::viewGetReservasi');
    $routes->get('gettamu', 'CheckinController::getTamu');
    $routes->get('getkamar', 'ReservasiController::getKamar');
    $routes->post('delete', 'ReservasiController::delete');
    $routes->get('viewgettamu', 'ReservasiController::viewGetTamu');
    $routes->get('viewgetkamar', 'ReservasiController::viewGetKamar');
    $routes->post('viewgetkamar', 'ReservasiController::viewGetKamar');
});



$routes->group('checkout', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'CheckoutController::index');
    $routes->get('viewcheckout', 'CheckoutController::viewCheckout');
    $routes->get('formtambah', 'CheckoutController::formtambah');
    $routes->post('save', 'CheckoutController::save');
    $routes->get('getcheckin', 'CheckoutController::getCheckin');
    $routes->get('viewgetcheckin', 'CheckoutController::viewGetCheckin');
    $routes->post('delete', 'CheckoutController::delete');
    $routes->get('detail/(:segment)', 'CheckoutController::detail/$1');
    $routes->get('faktur/(:segment)', 'CheckoutController::faktur/$1');
    $routes->get('formedit/(:segment)', 'CheckoutController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'CheckoutController::updatedata/$1');
});



//Laporan
$routes->group('laporan-wisma', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('tamu', 'Laporan\LaporanUsers::LaporanTamu');
    $routes->get('tamu/view', 'Laporan\LaporanUsers::viewallLaporanTamu');
    $routes->get('kamar', 'Laporan\LaporanUsers::LaporanKamar');
    $routes->get('kamar/view', 'Laporan\LaporanUsers::viewallLaporanKamar');
    $routes->get('pengeluaran', 'Laporan\LaporanUsers::LaporanPengeluaran');
    $routes->post('pengeluaran/viewallpengeluarantanggal', 'Laporan\LaporanUsers::viewallLaporanPengeluaranTanggal');
    $routes->post('pengeluaran/viewallpengeluarantahun', 'Laporan\LaporanUsers::viewallLaporanPengeluaranTahun');
    $routes->get('reservasi', 'Laporan\LaporanTransaksi::LaporanReservasi');
    $routes->post('reservasi/viewallreservasitanggal', 'Laporan\LaporanTransaksi::viewallLaporanReservasiTanggal');
    $routes->post('reservasi/viewallreservasibulan', 'Laporan\LaporanTransaksi::viewallLaporanReservasiBulan');
    $routes->get('checkin', 'Laporan\LaporanTransaksi::LaporanCheckin');
    $routes->post('checkin/viewallcheckintanggal', 'Laporan\LaporanTransaksi::viewallLaporanCheckinTanggal');
    $routes->post('checkin/viewallcheckinbulan', 'Laporan\LaporanTransaksi::viewallLaporanCheckinBulan');
    $routes->get('checkout', 'Laporan\LaporanTransaksi::LaporanCheckout');
    $routes->post('checkout/viewallcheckouttanggal', 'Laporan\LaporanTransaksi::viewallLaporanCheckoutTanggal');
    $routes->post('checkout/viewallcheckoutbulan', 'Laporan\LaporanTransaksi::viewallLaporanCheckoutBulan');
    $routes->get('pendapatan', 'Laporan\LaporanTransaksi::LaporanPendapatan');
    $routes->post('pendapatan/viewallpendapatantanggal', 'Laporan\LaporanTransaksi::viewallLaporanPendapatanTanggal');
    $routes->post('pendapatan/viewallpendapatantahun', 'Laporan\LaporanTransaksi::viewallLaporanPendapatanTahun');
});





// $routes->post('checkin/debugNewId', 'CheckinController::debugNewId');
// $routes->post('online/debugNewId', 'OnlineController::debugNewId');
// $routes->get('online/debugDatabase', 'OnlineController::debugDatabase');