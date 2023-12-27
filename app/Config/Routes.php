<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Auth Admin
$routes->get('login', 'Auth::index', ['filter' => 'islogin']);
$routes->post('login', 'Auth::login');
$routes->group('auth', function ($routes) {
    $routes->match(['get', 'post'], 'change-password', 'Auth::changePassword');
    $routes->post('logout', 'Auth::logout');
    $routes->get('berhasil', 'Auth::berhasil', ['filter' => 'cekkode']);
});

// Landing page
$routes->get('/', 'Home::index');
$routes->post('/rapat/submit-kode', 'Home::submitKode');
$routes->get('/rapat/daftar-hadir/(:segment)', 'Rapat::formAbsensi/$1');
$routes->post('/rapat/daftar-hadir/store', 'Rapat::absenStore');

// berhasil page
$routes->get('berhasil', 'Rapat::berhasilPage', ['filter' => 'cekkode']);

// gagal page
$routes->get('gagal', 'Rapat::gagalPage', ['filter' => 'cekkode']);

//  Route for displaying information about a meeting.
$routes->get('/rapat/informasi/(:segment)', 'Rapat::informasiRapat/$1');

// AJAX PESERTA RAPAT (form daftar hadir)
$routes->get('api/peserta/(:segment)', 'Api\UsersControllerAPI::getPeserta/$1');
$routes->get('api/pegawai/(:segment)', 'Api\UsersControllerAPI::getPegawai/$1');
$routes->get('api/pegawai/asn/(:segment)', 'Api\UsersControllerAPI::getPegawaiAsn/$1');
$routes->get('api/pegawai/non-asn/(:segment)', 'Api\UsersControllerAPI::getPegawaiNonAsn/$1');

// API
$routes->group('api', ['filter' => 'basicAuth'], function ($routes) {
    // login
    $routes->post('login', "API\AuthControllerAPI::login");
    // get agenda rapat berdasarkan instansi user (Home Screen)
    // Tersedia
    $routes->get('agenda-rapat/instansi/(:segment)', 'API\AgendaRapatControllerAPI::getByInstansi/$1');
    // Selesai
    $routes->get('agenda-rapat/instansi/selesai/(:segment)', 'API\AgendaRapatControllerAPI::getByInstansiSelesai/$1');
    // get agenda rapat berdasarkan id agenda rapat (Qr code result)
    $routes->get('agenda-rapat/scan/(:segment)', 'API\AgendaRapatControllerAPI::getAgendaRapat/$1');
    // search
    $routes->get('agenda-rapat/search', 'API\AgendaRapatControllerAPI::getAllAgendaRapat');
    // post form absen
    $routes->post('daftar-hadir/store', 'API\RapatControllerAPI::absenStore');
    $routes->post('change-password', "API\AuthControllerAPI::changePassword");
});

// Dashboard
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index', ['filter' => 'admin']);
    $routes->get('agenda-rapat', 'Admin\AgendaRapat::index');

    // route khusus super admin untuk melihat agenda rapat berdasarkan instansi (tabel view )
    $routes->get('view-detail-by-instansi/(:segment)', 'Admin\Dashboard::viewDetailAgendaRapatByInstansi/$1');

    // CRUD agenda rapat di semua role
    $routes->get('agenda-rapat/daftar-hadir/(:segment)', 'Admin\DaftarHadir::index/$1');
    $routes->post('agenda-rapat/daftar-hadir/delete-peserta/(:segment)', 'Admin\DaftarHadir::delete/$1');
    $routes->get('agenda-rapat/daftar-hadir/cetak/(:segment)', 'Admin\DaftarHadir::generatePdf/$1');

    $routes->get('agenda-rapat/tambah-agenda', 'Admin\AgendaRapat::tambahAgenda');
    $routes->post('agenda-rapat/tambah-agenda/store', 'Admin\AgendaRapat::store');

    $routes->get('agenda-rapat/view-agenda/(:segment)', 'Admin\AgendaRapat::view/$1');

    $routes->get('agenda-rapat/edit-agenda/(:segment)', 'Admin\AgendaRapat::edit/$1');
    $routes->post('agenda-rapat/edit-agenda/(:segment)/update', 'Admin\AgendaRapat::update/$1');
    $routes->post('delete-agenda/(:segment)', 'Admin\AgendaRapat::delete/$1');

    // Route edit profil
    $routes->get('profile', 'Admin\Profile::index');
    $routes->get('profile/edit-profile/(:segment)', 'Admin\Profile::edit/$1');
    $routes->post('profile/edit-profile/(:segment)', 'Admin\Profile::update/$1');
    $routes->get('profile/edit-profilepassword/(:segment)', 'Admin\Profile::editPassword/$1');
    $routes->post('profile/edit-profilepassword/(:segment)', 'Admin\Profile::updatePassword/$1');

    /**
     * Kelola Admin Routes
     * 
     * This group of routes is used to manage admin instansi, and operator bidang.
     * 
     * - Super admin -> admin instansi -> operator bidang
     * - Super admin manages Admin instansi
     * - Admin instansi manages bidang and operator of each bidang
     * - Each bidang has 1 operator
     * - kelola-admin/* route is used to manage admin instansi and operator bidang
     */
    $routes->group('kelola-admin', ['filter' => 'admin'], function ($routes) {
        $routes->get('/', 'Admin\Admin::index');
        // $routes->match(['get', 'post'], 'tambah-admin', 'Admin\Admin::tambahAdmin');
        $routes->get('tambah-admin', 'Admin\Admin::tambahAdmin');
        $routes->post('tambah-admin', 'Admin\Admin::store');
        $routes->get('edit-admin/(:segment)', 'Admin\Admin::edit/$1');
        $routes->post('edit-admin/(:segment)/update', 'Admin\Admin::update/$1');
        $routes->post('delete-admin/(:segment)', 'Admin\Admin::delete/$1');
    });

    // Route untuk kelola bidang di role admin instansi
    $routes->get('kelola-bidang', 'Admin\BidangInstansi::index');
    $routes->get('kelola-bidang/tambah-bidang', 'Admin\BidangInstansi::tambahBidang');
    $routes->post('kelola-bidang/tambah-bidang/store', 'Admin\BidangInstansi::store');

    $routes->get('kelola-bidang/edit-bidang/(:segment)', 'Admin\BidangInstansi::edit/$1');
    $routes->post('kelola-bidang/edit-bidang/(:segment)/update', 'Admin\BidangInstansi::update/$1');
    $routes->post('kelola-bidang/delete-bidang/(:segment)', 'Admin\BidangInstansi::delete/$1');
});
