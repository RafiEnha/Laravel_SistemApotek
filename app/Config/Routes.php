<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// obat
$routes->get('/obat', 'ObatController::index');
$routes->get('/obat/create', 'ObatController::create');
$routes->post('/obat/store', 'ObatController::store');
$routes->get('/obat/edit/(:num)', 'ObatController::edit/$1');
$routes->post('/obat/update/(:num)', 'ObatController::update/$1');
$routes->post('/obat/delete/(:num)', 'ObatController::delete/$1');
$routes->get('/obat/(:num)/penjualan','ObatController::detailPenjualan/$1');

// transaksi
$routes->get('/transaksi', 'TransaksiController::index');
$routes->post('/transaksi/store', 'TransaksiController::store');
$routes->get('/transaksi/struk/(:num)', 'TransaksiController::struk/$1');

// laporan
$routes->get('/laporan/penjualan','LaporanController::penjualan');

// api
$routes->post('/api/pemesanan-obat','Api\PemesananObatController::store');
$routes->get('/api/obat/stock','Api\StockObatController::index');
$routes->get('/api/obat/stock/(:num)','Api\StockObatController::show/$1');

// distributor
$routes->get('/distributor', 'DistributorController::index');
$routes->get('/distributor/create', 'DistributorController::create');
$routes->post('/distributor/store', 'DistributorController::store');
$routes->get('/distributor/edit/(:num)', 'DistributorController::edit/$1');
$routes->post('/distributor/update/(:num)', 'DistributorController::update/$1');
$routes->post('/distributor/delete/(:num)', 'DistributorController::delete/$1');