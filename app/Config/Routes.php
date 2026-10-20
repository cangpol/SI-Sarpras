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
$routes->get('api/calendar-events', 'Frontend::calendarEvents');

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
$routes->get('dashboard/export-pdf', 'Auth::exportPdf');
$routes->get('dashboard/export-pdf/(:segment)', 'Auth::exportPdf/$1');
$routes->get('dashboard/export/(:segment)', 'Auth::exportPdf/$1');
$routes->post('dashboard/update-status', 'Auth::updateStatus');
$routes->post('dashboard/my-request/cancel', 'Auth::cancelMyRequest');

// CRUD Supplies
$routes->post('dashboard/supplies/create', 'Auth::createSupply');
$routes->post('dashboard/supplies/update', 'Auth::updateSupply');
$routes->post('dashboard/supplies/delete', 'Auth::deleteSupply');

// CRUD Users (Settings)
$routes->post('dashboard/users/create', 'Auth::createUser');
$routes->post('dashboard/users/update', 'Auth::updateUser');
$routes->post('dashboard/users/delete', 'Auth::deleteUser');

// CRUD Pelaporan - Lost & Found
$routes->post('dashboard/pelaporan/lost-found/create', 'Auth::createLostFound');
$routes->post('dashboard/pelaporan/lost-found/update', 'Auth::updateLostFound');
$routes->post('dashboard/pelaporan/lost-found/delete', 'Auth::deleteLostFound');

// CRUD Pelaporan - Visitor
$routes->post('dashboard/pelaporan/visitor/create', 'Auth::createVisitor');
$routes->post('dashboard/pelaporan/visitor/update', 'Auth::updateVisitor');
$routes->post('dashboard/pelaporan/visitor/delete', 'Auth::deleteVisitor');

// CRUD Peminjaman - Ruangan
$routes->post('dashboard/peminjaman/ruangan/create', 'Auth::createRoomBooking');
$routes->post('dashboard/peminjaman/ruangan/update', 'Auth::updateRoomBooking');
$routes->post('dashboard/peminjaman/ruangan/delete', 'Auth::deleteRoomBooking');

// CRUD Peminjaman - Kendaraan
$routes->post('dashboard/peminjaman/kendaraan/create', 'Auth::createVehicleBooking');
$routes->post('dashboard/peminjaman/kendaraan/update', 'Auth::updateVehicleBooking');
$routes->post('dashboard/peminjaman/kendaraan/delete', 'Auth::deleteVehicleBooking');

// CRUD Request - Maintenance
$routes->post('dashboard/request/maintenance/create', 'Auth::createMaintenance');
$routes->post('dashboard/request/maintenance/update', 'Auth::updateMaintenance');
$routes->post('dashboard/request/maintenance/delete', 'Auth::deleteMaintenance');

// CRUD Request - Supplies Request
$routes->post('dashboard/request/supplies/create', 'Auth::createSupplyRequest');
$routes->post('dashboard/request/supplies/update', 'Auth::updateSupplyRequest');
$routes->post('dashboard/request/supplies/delete', 'Auth::deleteSupplyRequest');

// Master Data Ruangan
$routes->post('dashboard/master/rooms/create', 'Auth::createRoom');
$routes->post('dashboard/master/rooms/update', 'Auth::updateRoom');
$routes->post('dashboard/master/rooms/delete', 'Auth::deleteRoom');

// Master Data Kendaraan (Mobil)
$routes->post('dashboard/master/vehicles/create', 'Auth::createVehicle');
$routes->post('dashboard/master/vehicles/update', 'Auth::updateVehicle');
$routes->post('dashboard/master/vehicles/delete', 'Auth::deleteVehicle');

// Suspend & Unsuspend User (Spam Management)
$routes->post('dashboard/users/suspend', 'Auth::suspendUser');
$routes->post('dashboard/users/unsuspend', 'Auth::unsuspendUser');

// Biodata Profil Mandiri (User, Admin, Super Admin)
$routes->post('dashboard/profile/update', 'Auth::updateProfile');



