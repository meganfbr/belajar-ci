<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/produk', 'Home::index', ['filter' => 'auth']);
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filter' => 'Redirect']); 
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    // $routes->get('download/(:any)','ProdukController::download/$1');
    $routes->get('download','ProdukController::download');
});

$routes->group('product-category', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'ProdukCategoryController::index');
    $routes->post('', 'ProdukCategoryController::store');  // ubah dari 'store' ke ''
    $routes->post('edit/(:num)', 'ProdukCategoryController::edit/$1');
    $routes->get('delete/(:num)', 'ProdukCategoryController::delete/$1');
});

$routes->post('keranjang', 'TransaksiController::cart_add'); // <--- ini

// Routes untuk Diskon
$routes->get('diskon', 'DiskonController::index');
$routes->post('diskon', 'DiskonController::create'); // kalau ada proses tambah
$routes->post('diskon/update/(:num)', 'DiskonController::update/$1');
$routes->get('diskon/delete/(:num)', 'DiskonController::delete/$1'); // delete


// Tambah ke keranjang dari form beli
$routes->post('keranjang', 'TransaksiController::cart_add');

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('add', 'TransaksiController::cart_add'); // ✅ INI WAJIB ADA
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});


$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);


$routes->get('pesanan/sukses', 'TransaksiController::sukses', ['filter' => 'auth']);


$routes->get('product-category', 'ProdukCategoryController::index', ['as' => 'product-category']);
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);
// $routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);


$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('contact', 'FaqController::index', ['filter' => 'auth']);
$routes->get('faq', 'FaqController::index', ['filter' => 'auth']);
// $routes->get('profil', 'FaqController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);


