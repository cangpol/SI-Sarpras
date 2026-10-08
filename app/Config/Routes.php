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
