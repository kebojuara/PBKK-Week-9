<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ---------------------------------------------------------------
// Halaman publik
// ---------------------------------------------------------------
$routes->get('/', 'Home::index');
$routes->get('about', 'Pages::about');
$routes->get('contact', 'Pages::contact');
$routes->post('contact', 'Pages::kirimPesan');
$routes->get('direktori', 'Direktori::index');
$routes->get('mahasiswa/(:num)', 'Direktori::detail/$1');
$routes->get('program/(:segment)', 'Program::detail/$1');

// ---------------------------------------------------------------
// Autentikasi
// ---------------------------------------------------------------
$routes->get('login', 'Auth::login', ['filter' => 'guest']);
$routes->post('login', 'Auth::attempt', ['filter' => 'guest']);
$routes->post('logout', 'Auth::logout');

// ---------------------------------------------------------------
// Panel admin (wajib login)
// ---------------------------------------------------------------
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');

    // Mahasiswa: admin & staff boleh tambah/ubah, hanya admin yang boleh hapus
    $routes->get('mahasiswa', 'Mahasiswa::index');
    $routes->get('mahasiswa/new', 'Mahasiswa::new');
    $routes->post('mahasiswa', 'Mahasiswa::create');
    $routes->get('mahasiswa/(:num)/edit', 'Mahasiswa::edit/$1');
    $routes->put('mahasiswa/(:num)', 'Mahasiswa::update/$1');
    $routes->delete('mahasiswa/(:num)', 'Mahasiswa::delete/$1', ['filter' => 'role:admin']);

    // Pesan masuk: semua petugas boleh membaca
    $routes->get('pesan', 'Pesan::index');

    // Program studi, kelola user, dan hapus pesan: khusus admin
    $routes->group('', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('program', 'ProgramStudi::index');
        $routes->get('program/new', 'ProgramStudi::new');
        $routes->post('program', 'ProgramStudi::create');
        $routes->get('program/(:num)/edit', 'ProgramStudi::edit/$1');
        $routes->put('program/(:num)', 'ProgramStudi::update/$1');
        $routes->delete('program/(:num)', 'ProgramStudi::delete/$1');

        $routes->get('users', 'Users::index');
        $routes->get('users/new', 'Users::new');
        $routes->post('users', 'Users::create');
        $routes->get('users/(:num)/edit', 'Users::edit/$1');
        $routes->put('users/(:num)', 'Users::update/$1');
        $routes->delete('users/(:num)', 'Users::delete/$1');

        $routes->delete('pesan/(:num)', 'Pesan::delete/$1');
    });
});
