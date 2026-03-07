<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Landing::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'role:admin'], function($routes){
    $routes->get('dashboard', 'Admin\Dashboard::index');
     // CRUD USER
    $routes->get('users', 'Admin\User::index');
    $routes->get('users/create', 'Admin\User::create');
    $routes->post('users/store', 'Admin\User::store');
    $routes->get('users/edit/(:num)', 'Admin\User::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\User::update/$1');
    $routes->post('users/nonaktif/(:num)', 'Admin\User::nonaktif/$1');

    // CRUD KATEGORI
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->get('kategori/create', 'Admin\Kategori::create');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/update/(:num)', 'Admin\Kategori::update/$1');
    $routes->post('kategori/nonaktif/(:num)', 'Admin\Kategori::nonaktif/$1');

    // CRUD ALAT
    $routes->get('alat', 'Admin\Alat::index');
    $routes->get('alat/create', 'Admin\Alat::create');
    $routes->post('alat/store', 'Admin\Alat::store');
    $routes->get('alat/edit/(:num)', 'Admin\Alat::edit/$1');
    $routes->post('alat/update/(:num)', 'Admin\Alat::update/$1');
    $routes->post('alat/nonaktif/(:num)', 'Admin\Alat::nonaktif/$1');

});

$routes->group('petugas', ['filter' => 'role:petugas'], function($routes){
    // Dashboard Petugas
    $routes->get('dashboard', 'Petugas\Dashboard::index');
    // Daftar peminjaman untuk diverifikasi
    $routes->get('peminjaman', 'Petugas\Peminjaman::index');
    // detail pengajuan
    $routes->get('peminjaman/detail/(:num)', 'Petugas\Peminjaman::detail/$1');
    // aksi
    $routes->get('peminjaman/setuju/(:num)', 'Petugas\Peminjaman::setuju/$1');
    $routes->get('peminjaman/tolak/(:num)', 'Petugas\Peminjaman::tolak/$1');
    // Daftar pengembalian untuk diverifikasi
    $routes->get('pengembalian', 'Petugas\Pengembalian::index');
    $routes->get('pengembalian/detail/(:num)', 'Petugas\Pengembalian::detail/$1');
    $routes->post('pengembalian/verifikasi/(:num)', 'Petugas\Pengembalian::verifikasi/$1');
});

$routes->group('peminjam', ['filter' => 'role:peminjam'], function($routes){

    $routes->get('dashboard', 'Peminjam\Dashboard::index');

    // daftar alat
    $routes->get('alat', 'Peminjam\Alat::index');

    // submit peminjaman
    $routes->post('peminjaman/ajukan', 'Peminjam\Peminjaman::ajukan');

    // riwayat
    $routes->get('riwayat', 'Peminjam\Peminjaman::riwayat');
    // Pinjaman Aktif & Pengembalian
    $routes->get('pinjaman', 'Peminjam\Peminjaman::aktif'); // Ganti ke /peminjam/pinjaman
    $routes->post('pengembalian/(:num)', 'Peminjam\Peminjaman::ajukanPengembalian/$1'); // Ganti ke /peminjam/pengembalian/ID
});

