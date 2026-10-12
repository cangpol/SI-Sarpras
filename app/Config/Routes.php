<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Frontend::index');

// Pelaporan
$routes->get('pelaporan/lost-found', 'Frontend::lostFound');
$routes->post('pelaporan/lost-found', 'Frontend::submitLostFound');
$routes->get('pelaporan/visitor', 'Frontend::visitor');
$routes->post('pelaporan/visitor', 'Frontend::submitVisitor');

// Peminjaman
$routes->get('peminjaman/ruangan', 'Frontend::ruangan');
$routes->post('peminjaman/ruangan', 'Frontend::submitRuangan');
$routes->get('peminjaman/kendaraan', 'Frontend::kendaraan');
$routes->post('peminjaman/kendaraan', 'Frontend::submitKendaraan');

// Request
$routes->get('request/maintenance', 'Frontend::maintenance');
$routes->post('request/maintenance', 'Frontend::submitMaintenance');
$routes->get('request/supplies', 'Frontend::supplies');
$routes->post('request/supplies', 'Frontend::submitSupplies');

// Auth & Login
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Auth::dashboard');
$routes->post('dashboard/update-status', 'Auth::updateStatus');

// CRUD Supplies
$routes->post('dashboard/supplies/create', 'Auth::createSupply');
$routes->post('dashboard/supplies/update', 'Auth::updateSupply');
$routes->post('dashboard/supplies/delete', 'Auth::deleteSupply');

// CRUD Users (Settings)
$routes->post('dashboard/users/create', 'Auth::createUser');
$routes->post('dashboard/users/update', 'Auth::updateUser');
$routes->post('dashboard/users/delete', 'Auth::deleteUser');



