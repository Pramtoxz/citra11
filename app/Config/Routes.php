<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



// Auth Routes
$routes->get('/', 'Auth::index');
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

});

// Tambahkan route untuk debug ID reservasi
$routes->post('reservasi/debugNewId', 'ReservasiController::debugNewId');
// Tambahkan route untuk detail reservasi dan cancel
$routes->get('reservasi/detail/(:any)', 'ReservasiController::detail/$1');
$routes->post('reservasi/cancel/(:any)', 'ReservasiController::cancel/$1');
$routes->get('reservasi/cekin/(:any)', 'ReservasiController::cekin/$1');

$routes->group('checkin', ['filter' => ['auth', 'role:admin']], function ($routes) {
    $routes->get('/', 'CheckinController::index');
    $routes->get('viewcheckin', 'CheckinController::viewCheckin');
    $routes->get('formtambah', 'CheckinController::formtambah');
    $routes->post('save', 'ReservasiController::save');
    $routes->get('formedit/(:segment)', 'ReservasiController::formedit/$1');
    $routes->post('updatedata/(:segment)', 'CheckinController::updatedata/$1');
    $routes->get('detail/(:segment)', 'CheckinController::detail/$1');
    $routes->get('gettamu', 'CheckinController::getTamu');
    $routes->get('getkamar', 'ReservasiController::getKamar');
    $routes->post('delete', 'ReservasiController::delete');
    $routes->get('viewgettamu', 'ReservasiController::viewGetTamu');
    $routes->get('viewgetkamar', 'ReservasiController::viewGetKamar');
    $routes->post('viewgetkamar', 'ReservasiController::viewGetKamar');

});
