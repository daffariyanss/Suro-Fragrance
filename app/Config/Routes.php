<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==============================
// PUBLIC
// ==============================
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/login/customer', 'Auth::login/customer');
$routes->get('/login/admin', 'Auth::login/admin');
$routes->post('/login', 'Auth::process');
$routes->post('/login/customer', 'Auth::processCustomerLogin');
$routes->post('/login/admin', 'Auth::processAdminLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/setup-admin', 'Auth::setupAdmin');
$routes->post('/setup-admin', 'Auth::processSetupAdmin');
$routes->get('/logout', 'Auth::logout');

// ==============================
// DASHBOARD & PROFILE
// ==============================
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/pengaturan', 'Pengaturan::index');
$routes->post('/pengaturan/update', 'Pengaturan::update');

// ==============================
// SHOP / CATALOG
// ==============================
$routes->get('/barang', 'SuroFragrance::index');
$routes->get('/barang/kategori/(:num)', 'SuroFragrance::filterKategori/$1');
$routes->get('/transaksi/create', 'Transaksi::create');
$routes->post('/transaksi/store', 'Transaksi::store');
$routes->get('/riwayat-pembelian', 'Transaksi::history');
$routes->get('/riwayat-pembelian/edit/(:num)', 'Transaksi::editHistory/$1');
$routes->post('/riwayat-pembelian/update/(:num)', 'Transaksi::updateHistory/$1');
$routes->post('/riwayat-pembelian/cancel/(:num)', 'Transaksi::cancelHistory/$1');

// ==============================
// ADMIN ONLY CRUD
// ==============================
$routes->group('', ['filter' => 'isAdmin'], static function (RouteCollection $routes) {
    $routes->get('/admin/register', 'Auth::registerAdmin');
    $routes->post('/admin/register', 'Auth::processAdminRegister');

    $routes->get('/test/password', 'Test::password');
    $routes->get('/test/update-password', 'Test::updatePassword');

    $routes->get('/barang/create', 'SuroFragrance::create');
    $routes->post('/barang/store', 'SuroFragrance::store');
    $routes->get('/barang/edit/(:num)', 'SuroFragrance::edit/$1');
    $routes->post('/barang/update/(:num)', 'SuroFragrance::update/$1');
    $routes->get('/barang/delete/(:num)', 'SuroFragrance::delete/$1');
    $routes->get('/barang/demonstrasi', 'SuroFragrance::demonstrasi');

    $routes->get('/kategori', 'Kategori::index');
    $routes->post('/kategori/store', 'Kategori::store');
    $routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
    $routes->post('/kategori/delete/(:num)', 'Kategori::delete/$1');

    $routes->get('/pelanggan', 'Pelanggan::index');
    $routes->get('/pelanggan/create', 'Pelanggan::create');
    $routes->post('/pelanggan/store', 'Pelanggan::store');
    $routes->get('/pelanggan/edit/(:num)', 'Pelanggan::edit/$1');
    $routes->post('/pelanggan/update/(:num)', 'Pelanggan::update/$1');
    $routes->get('/pelanggan/delete/(:num)', 'Pelanggan::delete/$1');

    $routes->get('/transaksi', 'Transaksi::index');
});
