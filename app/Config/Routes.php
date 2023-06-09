<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

//Landingpage
$routes->get('/', 'LandingPageController::index');

//Routes Auth
$routes->get('signin', 'AuthController::index');
$routes->post('postLogin', 'AuthController::postLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('errors', 'AuthController::errors');

$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('dashboard', 'DashboardController');


    //Kegiatan
    $routes->get('kelola-kegiatan', 'KegiatanController::index');
    $routes->post('kelola-kegiatan/store', 'KegiatanController::store');
    $routes->get('kelola-kegiatan/edit', 'KegiatanController::edit');
    $routes->post('kelola-kegiatan/update', 'KegiatanController::update');
    $routes->get('kelola-kegiatan/delete/(:num)', 'KegiatanController::delete/$1');

    //profileUser
    $routes->get('profile-user', 'ProfileUser::index');
    $routes->post('profile-user/(:num)', 'ProfileUser::update/$1');

    //Routes Admin
    $routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
        //kelola pengguna
        $routes->get('kelola-pengguna', 'UsersController::index');
        $routes->post('kelola-pengguna/store', 'UsersController::store');
        $routes->get('kelola-pengguna/edit', 'UsersController::edit');
        $routes->post('kelola-pengguna/update', 'UsersController::update');
        $routes->get('kelola-pengguna/delete/(:num)', 'UsersController::delete/$1');

        //kelola pelaksana
        $routes->get('kelola-pelaksana', 'PelaksanaController::index');
        $routes->post('kelola-pelaksana/store', 'PelaksanaController::store');
        $routes->get('kelola-pelaksana/edit', 'PelaksanaController::edit');
        $routes->post('kelola-pelaksana/update', 'PelaksanaController::update');
        $routes->get('kelola-pelaksana/delete/(:num)', 'PelaksanaController::delete/$1');

        //kelola jabatan
        $routes->get('kelola-jabatan', 'JabatanController::index');
        $routes->post('kelola-jabatan/store', 'JabatanController::store');
        $routes->get('kelola-jabatan/edit', 'JabatanController::edit');
        $routes->post('kelola-jabatan/update', 'JabatanController::update');
        $routes->get('kelola-jabatan/delete/(:num)', 'JabatanController::delete/$1');

        //kelola bidang
        $routes->get('kelola-bidang', 'BidangController::index');
        $routes->post('kelola-bidang/store', 'BidangController::store');
        $routes->get('kelola-bidang/edit', 'BidangController::edit');
        $routes->post('kelola-bidang/update', 'BidangController::update');
        $routes->get('kelola-bidang/delete/(:num)', 'BidangController::delete/$1');
    });

    //Routes Pelaksana
    $routes->group('pelaksana', ['filter' => 'PelaksanaFilter'], function ($routes) {

        //Proyek
        $routes->get('kelola-proyek', 'ProyekController::indexPelaksana');
        $routes->post('kelola-proyek/store', 'ProyekController::storePelaksana');
        $routes->get('kelola-proyek/edit', 'ProyekController::editPelaksana');
        $routes->post('kelola-proyek/update', 'ProyekController::updatePelaksana');
        $routes->get('kelola-proyek/delete/(:num)', 'ProyekController::deletePelaksana/$1');

        //laporan
        $routes->get('laporan', 'LaporanController::indexPelaksana');
        $routes->get('laporan/export-pdf', 'LaporanController::exportPdfPelaksana');
    });

    //Routes Mandor
    $routes->group('mandor', ['filter' => 'MandorFilter'], function ($routes) {

        //proyek
        $routes->get('kelola-proyek', 'ProyekController::indexMandor');
        $routes->get('kelola-proyek/edit', 'ProyekController::editMandor');
        $routes->post('kelola-proyek/update', 'ProyekController::updateMandor');

        //laporan
        $routes->get('laporan', 'LaporanController::indexMandor');
        $routes->get('laporan/export-pdf', 'LaporanController::exportPdfMandor');
    });

    //Routes Tukang
    $routes->group('tukang', ['filter' => 'TukangFilter'], function ($routes) {

        //proyek
        $routes->get('kelola-proyek', 'ProyekController::indexTukang');
        $routes->get('kelola-proyek/edit', 'ProyekController::editTukang');
        $routes->post('kelola-proyek/update', 'ProyekController::updateTukang');

        //laporan
        $routes->get('laporan', 'LaporanController::indexLapTukang');
        $routes->get('laporan/export-pdf', 'LaporanController::exportPdfTukang');

        //timeline
        $routes->get('kelola-timeline-kegiatan', 'TimelineKegiatanController::index');
        $routes->post('kelola-timeline-kegiatan/store', 'TimelineKegiatanController::store');
        $routes->get('kelola-timeline-kegiatan/edit', 'TimelineKegiatanController::edit');
        $routes->post('kelola-timeline-kegiatan/update', 'TimelineKegiatanController::update');
        $routes->get('kelola-timeline-kegiatan/delete/(:num)', 'TimelineKegiatanController::delete/$1');
    });
});




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
