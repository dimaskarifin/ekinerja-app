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

//Routes Auth
$routes->get('/', 'AuthController::index');
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

    //kinerja
    $routes->get('kelola-ekinerja', 'EkinerjaController::index');
    $routes->post('kelola-ekinerja/store', 'EkinerjaController::store');

    //profileUser
    $routes->get('profile-user', 'ProfileUser::index');

    //Routes Mandor
    $routes->group('mandor', ['filter' => 'MandorFilter'], function ($routes) {
        //Users
        $routes->get('kelola-users', 'UsersController::index');
        $routes->post('kelola-users/store', 'UsersController::store');
        $routes->get('kelola-users/edit', 'UsersController::editMandor');
        $routes->post('kelola-users/update', 'UsersController::updateMandor');
        $routes->get('kelola-users/delete/(:num)', 'UsersController::delete/$1');

        //pengawas
        $routes->get('kelola-pengawas', 'PengawasController::index');
        $routes->post('kelola-pengawas/store', 'PengawasController::store');
        $routes->get('kelola-pengawas/edit', 'PengawasController::edit');
        $routes->post('kelola-pengawas/update', 'PengawasController::update');
        $routes->get('kelola-pengawas/delete/(:num)', 'PengawasController::delete/$1');

        //jabatan
        $routes->get('kelola-jabatan', 'JabatanController::index');
        $routes->post('kelola-jabatan/store', 'JabatanController::store');
        $routes->get('kelola-jabatan/edit', 'JabatanController::edit');
        $routes->post('kelola-jabatan/update', 'JabatanController::update');
        $routes->get('kelola-jabatan/delete/(:num)', 'JabatanController::delete/$1');

        //bidang
        $routes->get('kelola-bidang', 'BidangController::index');
        $routes->post('kelola-bidang/store', 'BidangController::store');
        $routes->get('kelola-bidang/edit', 'BidangController::edit');
        $routes->post('kelola-bidang/update', 'BidangController::update');
        $routes->get('kelola-bidang/delete/(:num)', 'BidangController::delete/$1');
    });

    //Routes Pelaksana
    $routes->group('pelaksana', ['filter' => 'PelaksanaFilter'], function ($routes) {
        //data Tukang
        $routes->get('kelola-tukang', 'UsersController::indexPelaksana');
    });

    //Routes Tukang
    $routes->group('tukang', ['filter' => 'TukangFilter'], function ($routes) {
        //data Tukang
        $routes->get('kelola-kegiatan', 'KegiatanController::index');
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
