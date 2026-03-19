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

    // PEMINJAMAN
     $routes->get('peminjaman', 'Admin\Peminjaman::index');
    $routes->get('peminjaman/create', 'Admin\Peminjaman::create');
    $routes->post('peminjaman/store', 'Admin\Peminjaman::store');
    $routes->get('peminjaman/detail/(:num)', 'Admin\Peminjaman::detail/$1');
    $routes->get('peminjaman/edit/(:num)', 'Admin\Peminjaman::edit/$1');
    $routes->post('peminjaman/update/(:num)', 'Admin\Peminjaman::update/$1');
    $routes->get('peminjaman/approve/(:num)', 'Admin\Peminjaman::approve/$1');
    $routes->get('peminjaman/reject/(:num)', 'Admin\Peminjaman::reject/$1');
    $routes->get('peminjaman/cancel/(:num)', 'Admin\Peminjaman::cancel/$1');

    // PENGEMBALIAN
    $routes->get('pengembalian', 'Admin\Pengembalian::index');
    $routes->get('pengembalian/detail/(:num)', 'Admin\Pengembalian::detail/$1');
    $routes->get('pengembalian/edit/(:num)', 'Admin\Pengembalian::edit/$1');
    $routes->post('pengembalian/update/(:num)', 'Admin\Pengembalian::update/$1');
    
    // Log Aktivitas
    $routes->get('log-aktivitas', 'Admin\LogAktivitas::index');
    // Pengaturan
    $routes->get('settings', 'Admin\Setting::index');
    $routes->post('settings/update', 'Admin\Setting::update');

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
    // Laporan
    $routes->get('laporan/peminjaman', 'Petugas\Laporan::peminjaman');
    $routes->get('laporan/pengembalian', 'Petugas\Laporan::pengembalian');
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

