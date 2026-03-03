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
});

$routes->group('petugas', ['filter' => 'role:petugas'], function($routes){
    $routes->get('dashboard', 'Petugas\Dashboard::index');
});

$routes->group('peminjam', ['filter' => 'role:peminjam'], function($routes){
    $routes->get('dashboard', 'Peminjam\Dashboard::index');
});

