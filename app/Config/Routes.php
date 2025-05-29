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

$routes->get('product-category', 'ProdukCategoryController::index', ['as' => 'product-category']);

$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);

$routes->get('contact', 'FaqController::index', ['filter' => 'auth']);
$routes->get('faq', 'FaqController::index', ['filter' => 'auth']);
$routes->get('profil', 'FaqController::index', ['filter' => 'auth']);
