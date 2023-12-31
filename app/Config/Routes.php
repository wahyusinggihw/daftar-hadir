<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Admin
$routes->group('auth', function ($routes) {
    $routes->match(['get', 'post'], 'login', 'Auth::login', ['filter' => 'islogin']);
    $routes->post('logout', 'Auth::logout');
});

// SLnding page
$routes->get('/', 'Home::index');
$routes->post('/rapat/submit-kode', 'Home::submitKode');
$routes->get('/rapat/daftar-hadir/(:segment)', 'RapatController::formAbsensi/$1');
$routes->post('/rapat/daftar-hadir/store', 'RapatController::absenStore');

// AJAX PESERTA RAPAT
$routes->get('api/peserta/(:segment)', 'Api\UsersControllerAPI::getPeserta/$1');
$routes->get('api/pegawai/(:segment)', 'Api\UsersControllerAPI::getPegawai/$1');
$routes->get('api/pegawai/asn/(:segment)', 'Api\UsersControllerAPI::getPegawaiAsn/$1');
$routes->get('api/pegawai/non-asn/(:segment)', 'Api\UsersControllerAPI::getPegawaiNonAsn/$1');
$routes->post('api/save-signature', 'RapatController::saveSignatureData');


// API Mobile App
$routes->group('api', ['filter' => 'basicAuth'], function ($routes) {
    $routes->post('login', "Api\AuthControllerAPI::login");
    // get agenda rapat berdasarkan instansi user (Home Screen)
    $routes->get('agenda-rapat/get-by-instansi/(:segment)', 'Api\AgendaRapatControllerAPI::index/$1');
    // get agenda rapat berdasarkan id agenda rapat (Scan QR Code)
    $routes->get('agenda-rapat/get-by-id/(:segment)', 'Api\AgendaRapatControllerAPI::getById/$1');
    // post form absen (Qr code result)
    $routes->post('form-absensi-store', 'Api\RapatControllerAPI::absenStore');
});

// berhasil page
$routes->get('berhasil', 'RapatController::berhasil', ['filter' => 'cekkode']);

/**
 * Route for displaying information about a meeting.
 * 
 * $1 The segment containing the meeting ID.
 */
$routes->get('/rapat/informasi/(:segment)', 'Dashboard\AgendaRapat::informasiRapat/$1');

// Dashboard
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard\Dashboard::index', ['filter' => 'admin']);
    $routes->get('agenda-rapat', 'Dashboard\Dashboard::agenda');

    // route khusus super admin untuk melihat agenda rapat berdasarkan instansi (tabel view )
    $routes->get('view-detail-by-instansi/(:segment)', 'Dashboard\Dashboard::viewDetailAgendaRapatByInstansi/$1');

    // CRUD agenda rapat di semua role
    $routes->get('agenda-rapat/daftar-hadir/(:segment)', 'Dashboard\DaftarHadirController::cariDaftarHadir/$1');
    $routes->post('agenda-rapat/daftar-hadir/delete-peserta/(:segment)', 'Dashboard\DaftarHadirController::delete/$1');
    $routes->get('cetak-daftar-hadir/(:segment)', 'Dashboard\DaftarHadirController::generatePdf/$1');

    $routes->get('agenda-rapat/tambah-agenda', 'Dashboard\AgendaRapat::tambahAgenda');
    $routes->post('agenda-rapat/tambah-agenda/store', 'Dashboard\AgendaRapat::store');

    $routes->get('agenda-rapat/view-agenda/(:segment)', 'Dashboard\AgendaRapat::view/$1');


    $routes->get('agenda-rapat/edit-agenda/(:segment)', 'Dashboard\AgendaRapat::edit/$1');
    $routes->post('agenda-rapat/edit-agenda/(:segment)/update', 'Dashboard\AgendaRapat::update/$1');
    $routes->post('delete-agenda/(:segment)', 'Dashboard\AgendaRapat::delete/$1');

    // Route edit profil
    $routes->get('profile', 'Dashboard\UsersController::index');
    $routes->get('profile/edit-profile/(:segment)', 'Dashboard\UsersController::edit/$1');
    $routes->post('profile/edit-profile/(:segment)', 'Dashboard\UsersController::update/$1');
    $routes->get('profile/edit-profilepassword/(:segment)', 'Dashboard\UsersController::editPassword/$1');
    $routes->post('profile/edit-profilepassword/(:segment)', 'Dashboard\UsersController::updatePassword/$1');

    /**
     * Kelola Admin Routes
     * 
     * This group of routes is used to manage the super admin, admin instansi, and operator bidang.
     * 
     * - Super admin -> admin instansi -> operator bidang
     * - Super admin manages Admin instansi
     * - Admin instansi manages bidang and operator of each bidang
     * - Each bidang has 1 operator
     * - kelola-admin/* route is used to manage admin instansi and operator bidang
     */
    $routes->group('kelola-admin', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'Dashboard\AdminController::index');
        // $routes->match(['get', 'post'], 'tambah-admin', 'Dashboard\AdminController::tambahAdmin');
        $routes->get('tambah-admin', 'Dashboard\AdminController::tambahAdmin');
        $routes->post('tambah-admin', 'Dashboard\AdminController::store');
        $routes->get('edit-admin/(:segment)', 'Dashboard\AdminController::edit/$1');
        $routes->post('edit-admin/(:segment)/update', 'Dashboard\AdminController::update/$1');
        $routes->post('delete-admin/(:segment)', 'Dashboard\AdminController::delete/$1');
    });

    // Route untuk kelola bidang di role admin instansi
    $routes->get('kelola-bidang', 'Dashboard\BidangInstansiController::index');
    $routes->match(['get', 'post'], 'kelola-bidang/tambah-bidang', 'Dashboard\BidangInstansiController::tambahBidang');
    $routes->get('kelola-bidang/edit-bidang/(:segment)', 'Dashboard\BidangInstansiController::edit/$1');
    $routes->post('kelola-bidang/edit-bidang/(:segment)/update', 'Dashboard\BidangInstansiController::update/$1');
    $routes->post('kelola-bidang/delete-bidang/(:segment)', 'Dashboard\BidangInstansiController::delete/$1');
});
