<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page routes
$routes->get('/', 'Home::index');
$routes->get('online/booking', 'BookingController::booking');
$routes->post('online/simpanbooking', 'BookingController::simpanbooking');
$routes->get('online/bukti', 'BookingController::bukti');
$routes->get('online/bukti/(:segment)', 'BookingController::bukti/$1');
$routes->get('online/uploadBukti/(:segment)', 'BookingController::uploadBukti/$1');
$routes->post('online/prosesUploadBukti', 'BookingController::prosesUploadBukti');
$routes->get('online/faktur/(:segment)', 'BookingController::faktur/$1');
$routes->post('booking/checkDayMatch', 'BookingController::checkDayMatch');
$routes->post('booking/findAvailableSlot', 'BookingController::findAvailableSlot');
$routes->get('online/lengkapi_data', 'BookingController::lengkapi_data');
$routes->post('booking/simpan_data_pasien', 'BookingController::simpan_data_pasien');

// Auth Routes
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

// Dashboard Pasien Routes
$routes->group('pasien', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'PasienDashboardController::index');
    $routes->get('histori', 'PasienDashboardController::histori');
    $routes->get('edit-profil', 'PasienDashboardController::editProfil');
    $routes->post('update-profil', 'PasienDashboardController::updateProfil');
    $routes->get('booking/(:segment)', 'PasienDashboardController::detailBooking/$1');
    $routes->get('faktur/(:segment)', 'PasienDashboardController::detailBooking/$1');
});

// Admin & Dokter & Pimpinan dashboard (protected by auth filter)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
});

// Pasien routes (protected by auth filter and role filter)
$routes->group('pasien', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'PasienController::index');
    $routes->get('view', 'PasienController::viewPasien');
    $routes->post('detail', 'PasienController::getPasienDetail');
    $routes->get('formtambah', 'PasienController::formtambah');
    $routes->post('save', 'PasienController::save');
    $routes->get('formedit/(:segment)', 'PasienController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PasienController::updatedata/$1');
    $routes->get('detail/(:segment)', 'PasienController::detail/$1');
    $routes->post('delete', 'PasienController::delete');
    $routes->post('createUser/(:segment)', 'PasienController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'PasienController::updatePassword/$1');
});


// Dokter routes (protected by auth filter and role filter)
$routes->group('dokter', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'DokterController::index');
    $routes->get('view', 'DokterController::viewDokter');
    $routes->post('detail', 'DokterController::getDokterDetail');
    $routes->get('formtambah', 'DokterController::formtambah');
    $routes->post('save', 'DokterController::save');
    $routes->get('formedit/(:segment)', 'DokterController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'DokterController::updatedata/$1');
    $routes->get('detail/(:segment)', 'DokterController::detail/$1');
    $routes->post('delete', 'DokterController::delete');
    $routes->post('createUser/(:segment)', 'DokterController::createUser/$1');
    $routes->post('updatePassword/(:segment)', 'DokterController::updatePassword/$1');
});

// Jadwal routes (protected by auth filter and role filter)
$routes->group('jadwal', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'JadwalController::index');
    $routes->get('view', 'JadwalController::viewJadwal');
    $routes->get('formtambah', 'JadwalController::formtambah');
    $routes->post('save', 'JadwalController::save');
    $routes->get('formedit/(:segment)', 'JadwalController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'JadwalController::updatedata/$1');
    $routes->get('detail/(:segment)', 'JadwalController::detail/$1');
    $routes->post('delete', 'JadwalController::delete');
    $routes->post('toggleStatus', 'JadwalController::toggleStatus');
    $routes->get('getdokter', 'JadwalController::getdokter');
    $routes->get('viewGetDokter', 'JadwalController::viewGetDokter');
});

// Jadwal routes (protected by auth filter and role filter)
$routes->group('jenis', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'JenisController::index');
    $routes->get('view', 'JenisController::viewJenis');
    $routes->get('formtambah', 'JenisController::formtambah');
    $routes->post('save', 'JenisController::save');
    $routes->get('formedit/(:segment)', 'JenisController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'JenisController::updatedata/$1');
    $routes->get('detail/(:segment)', 'JenisController::detail/$1');
    $routes->post('delete', 'JenisController::delete');
});

// Obat routes (protected by auth filter and role filter)
$routes->group('obat', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'ObatController::index');
    $routes->get('view', 'ObatController::viewObat');
    $routes->get('formtambah', 'ObatController::formtambah');
    $routes->post('save', 'ObatController::save');
    $routes->get('formedit/(:segment)', 'ObatController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'ObatController::updatedata/$1');
    $routes->get('detail/(:segment)', 'ObatController::detail/$1');
    $routes->post('delete', 'ObatController::delete');
});

// Obat Masuk routes (protected by auth filter and role filter)
$routes->group('obatmasuk', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'ObatMasukController::index');
    $routes->get('view', 'ObatMasukController::view');
    $routes->get('formtambah', 'ObatMasukController::formtambah');
    $routes->get('getobat', 'ObatMasukController::getobat');
    $routes->get('viewtemp', 'ObatMasukController::viewTemp');
    $routes->post('addtemp', 'ObatMasukController::addTemp');
    $routes->post('deletetemp', 'ObatMasukController::deleteTemp', ['as' => 'obatmasuk.deletetemp']);
    $routes->post('deletetemp/(:num)', 'ObatMasukController::deleteTemp/$1', ['as' => 'obatmasuk.deletetempnum']);
    $routes->post('deletealltemp', 'ObatMasukController::deleteAllTemp', ['as' => 'obatmasuk.deletealltemp']);
    $routes->post('save', 'ObatMasukController::save');
    $routes->get('edit/(:segment)', 'ObatMasukController::formedit/$1');
    $routes->post('updatedata', 'ObatMasukController::updatedata');
    $routes->post('delete', 'ObatMasukController::delete', ['as' => 'obatmasuk.delete']);
    $routes->get('detail/(:segment)', 'ObatMasukController::DetailObatMasuk/$1');
});

// Booking routes (protected by auth filter and role filter)
$routes->group('booking', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'BookingController::index');
    $routes->get('view', 'BookingController::viewBooking');
    $routes->get('formtambah', 'BookingController::formtambah');
    $routes->post('save', 'BookingController::save');
    $routes->get('formedit/(:segment)', 'BookingController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'BookingController::updatedata/$1');
    $routes->get('detail/(:segment)', 'BookingController::detail/$1');
    $routes->post('delete', 'BookingController::delete');
    $routes->post('updateStatus', 'BookingController::updateStatus');
    $routes->post('checkSlotAvailability', 'BookingController::checkSlotAvailability');
    $routes->post('findAvailableSlot', 'BookingController::findAvailableSlot');
    $routes->post('checkDayMatch', 'BookingController::checkDayMatch'); // New route
    $routes->get('getPasien', 'BookingController::getPasien');
    $routes->get('viewGetPasien', 'BookingController::viewGetPasien');
    $routes->get('getJadwal', 'BookingController::getJadwal');
    $routes->get('viewGetJadwal', 'BookingController::viewGetJadwal');
    // Check-in routes
    $routes->get('checkin', 'BookingController::checkin');
    $routes->get('checkin/(:segment)', 'BookingController::checkin/$1');
    $routes->post('processCheckin', 'BookingController::processCheckin');
    $routes->get('getBuktiBooking/(:segment)', 'BookingController::getBuktiBooking/$1');
    $routes->post('updateStatusBukti/(:segment)', 'BookingController::updateStatusBukti/$1');
    // Pembayaran routes
    $routes->get('uploadBukti/(:segment)', 'BookingController::uploadBukti/$1');
    $routes->post('prosesUploadBukti', 'BookingController::prosesUploadBukti');
    $routes->get('faktur/(:segment)', 'BookingController::faktur/$1');
});

// Perawatan routes (protected by auth filter and role filter)
$routes->group('perawatan', ['filter' => ['auth', 'role:admin,dokter,pimpinan']], function ($routes) {
    $routes->get('/', 'PerawatanController::index');
    $routes->get('view', 'PerawatanController::viewPerawatan');
    $routes->get('formtambah', 'PerawatanController::formtambah');
    $routes->get('getperawatan', 'PerawatanController::getperawatan');
    $routes->get('viewgetperawatan', 'PerawatanController::viewgetperawatan');
    $routes->get('getobat', 'PerawatanController::getobat');
    $routes->get('viewgetobat', 'PerawatanController::viewgetobat');
    $routes->get('getpasien', 'PerawatanController::getpasien');
    $routes->get('viewgetpasien', 'PerawatanController::viewgetpasien');
    $routes->get('detail/(:segment)', 'PerawatanController::detail/$1');
    $routes->get('viewtemp', 'PerawatanController::viewTemp');
    $routes->post('addtemp', 'PerawatanController::addtemp');
    $routes->post('deletetemp/(:num)', 'PerawatanController::deleteTemp/$1', ['as' => 'perawatan.deletetempnum']);
    $routes->post('deletetempall', 'PerawatanController::deleteAllTemp');
    $routes->post('save', 'PerawatanController::save');
    $routes->get('formedit/(:segment)', 'PerawatanController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'PerawatanController::updatedata/$1');
    $routes->post('delete', 'PerawatanController::delete');
});


$routes->group('laporan-obat', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('/', 'Laporan\LaporanObat::LaporanObat');
    $routes->get('view', 'Laporan\LaporanObat::viewallLaporanObat');
    $routes->get('masuk', 'Laporan\LaporanObat::LaporanObatMasuk');
    $routes->get('masuk/view', 'Laporan\LaporanObat::viewallLaporanObatMasuk');
    $routes->post('masuk/viewtanggal', 'Laporan\LaporanObat::viewallLaporanObatMasukTanggal');
    $routes->post('masuk/viewbulan', 'Laporan\LaporanObat::viewallLaporanObatMasukBulan');
});


$routes->group('laporan-users', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('pasien', 'Laporan\LaporanUsers::LaporanPasien');
    $routes->get('pasien/view', 'Laporan\LaporanUsers::viewallLaporanPasien');
    $routes->get('dokter', 'Laporan\LaporanUsers::LaporanDokter');
    $routes->get('dokter/view', 'Laporan\LaporanUsers::viewallLaporanDokter');
});


$routes->group('laporan-jenis', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('/', 'Laporan\LaporanObat::LaporanJenis');
    $routes->get('view', 'Laporan\LaporanObat::viewallLaporanJenis');
});
$routes->group('laporan-jadwal', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('/', 'Laporan\LaporanObat::LaporanJadwal');
    $routes->get('view', 'Laporan\LaporanObat::viewallLaporanJadwal');
});

$routes->group('laporan-transaksi', ['filter' => ['auth', 'role:admin,pimpinan']], function ($routes) {
    $routes->get('booking', 'Laporan\LaporanTransaksi::LaporanBooking');
    $routes->get('booking/view', 'Laporan\LaporanTransaksi::viewallLaporanBooking');
    $routes->post('booking/viewtanggal', 'Laporan\LaporanTransaksi::viewallLaporanBookingTanggal');
    $routes->post('booking/viewbulan', 'Laporan\LaporanTransaksi::viewallLaporanBookingBulan');
});


