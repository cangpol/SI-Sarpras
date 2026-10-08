<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

// Dashboard Routes
$routes->group('api', ['filter' => 'auth'], function ($routes) {
    // Security
    $routes->get('visitors/active', 'Api\SecurityController::getActiveVisitors');
    $routes->post('visitors/checkin', 'Api\SecurityController::visitorCheckIn');
    $routes->post('visitors/checkout/(:num)', 'Api\SecurityController::visitorCheckOut/');
    $routes->post('lost-found', 'Api\SecurityController::reportLostFound');
    $routes->post('lost-found/claim/(:num)', 'Api\SecurityController::claimLostFound/');

    // Room Bookings
    $routes->get('rooms/bookings', 'Api\RoomBookingController::index');
    $routes->post('rooms/bookings', 'Api\RoomBookingController::create');
    $routes->post('rooms/bookings/(:num)/approve', 'Api\RoomBookingController::approve/');
    $routes->post('rooms/bookings/(:num)/reject', 'Api\RoomBookingController::reject/');

    // Maintenance
    $routes->get('maintenance', 'Api\MaintenanceController::index');
    $routes->post('maintenance', 'Api\MaintenanceController::create');
    $routes->post('maintenance/(:num)/assign', 'Api\MaintenanceController::assignTechnician/');
    $routes->post('maintenance/(:num)/status', 'Api\MaintenanceController::updateStatus/');

    // Vehicles
    $routes->get('vehicles/bookings', 'Api\VehicleBookingController::index');
    $routes->post('vehicles/bookings', 'Api\VehicleBookingController::create');
    $routes->post('vehicles/bookings/(:num)/approve', 'Api\VehicleBookingController::approve/');
    $routes->post('vehicles/bookings/(:num)/complete', 'Api\VehicleBookingController::completeTrip/');

    // Supplies
    $routes->get('supplies', 'Api\SupplyController::index');
    $routes->post('supplies/request', 'Api\SupplyController::requestSupplies');
    $routes->post('supplies/requests/(:num)/approve', 'Api\SupplyController::approve/');

    // Dashboard
    $routes->get('dashboard/calendar', 'Api\DashboardController::getCalendarEvents');
    $routes->get('calendar-events', 'Api\DashboardController::getCalendarEvents');
    $routes->get('dashboard/statistics', 'Api\DashboardController::getStatistics');

    // Admin Master CRUD
    $routes->group('admin', function ($routes) {
        $routes->get('rooms', 'Api\AdminMasterController::getRooms');
        $routes->post('rooms', 'Api\AdminMasterController::createRoom');
        $routes->put('rooms/(:num)', 'Api\AdminMasterController::updateRoom/$1');
        $routes->delete('rooms/(:num)', 'Api\AdminMasterController::deleteRoom/$1');

        $routes->get('vehicles', 'Api\AdminMasterController::getVehicles');
        $routes->post('vehicles', 'Api\AdminMasterController::createVehicle');
        $routes->put('vehicles/(:num)', 'Api\AdminMasterController::updateVehicle/$1');
        $routes->delete('vehicles/(:num)', 'Api\AdminMasterController::deleteVehicle/$1');

        $routes->get('drivers', 'Api\AdminMasterController::getDrivers');
        $routes->post('drivers', 'Api\AdminMasterController::createDriver');
        $routes->put('drivers/(:num)', 'Api\AdminMasterController::updateDriver/$1');
        $routes->delete('drivers/(:num)', 'Api\AdminMasterController::deleteDriver/$1');

        $routes->get('supplies', 'Api\AdminMasterController::getSupplies');
        $routes->post('supplies', 'Api\AdminMasterController::createSupply');
        $routes->put('supplies/(:num)', 'Api\AdminMasterController::updateSupply/$1');
        $routes->delete('supplies/(:num)', 'Api\AdminMasterController::deleteSupply/$1');
        
        $routes->put('rooms/bookings/(:num)', 'Api\AdminMasterController::updateRoomBooking/$1');
        $routes->delete('rooms/bookings/(:num)', 'Api\AdminMasterController::deleteRoomBooking/$1');
        $routes->put('vehicles/bookings/(:num)', 'Api\AdminMasterController::updateVehicleBooking/$1');
        $routes->delete('vehicles/bookings/(:num)', 'Api\AdminMasterController::deleteVehicleBooking/$1');
    });

    // Export
    $routes->get('export/excel/(:any)', 'ExportController::exportExcel/$1');
    $routes->get('export/pdf/(:any)', 'ExportController::exportPdf/$1');
});

// Admin Web Routes (with Auth)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    // Master Data
    $routes->get('rooms', 'Admin\RoomsController::index');
    $routes->get('rooms/create', 'Admin\RoomsController::create');
    $routes->post('rooms/store', 'Admin\RoomsController::store');
    $routes->get('rooms/edit/(:num)', 'Admin\RoomsController::edit/$1');
    $routes->post('rooms/update/(:num)', 'Admin\RoomsController::update/$1');
    $routes->get('rooms/delete/(:num)', 'Admin\RoomsController::delete/$1');

    $routes->get('vehicles', 'Admin\VehiclesController::index');
    $routes->get('vehicles/create', 'Admin\VehiclesController::create');
    $routes->post('vehicles/store', 'Admin\VehiclesController::store');
    $routes->get('vehicles/edit/(:num)', 'Admin\VehiclesController::edit/$1');
    $routes->post('vehicles/update/(:num)', 'Admin\VehiclesController::update/$1');
    $routes->get('vehicles/delete/(:num)', 'Admin\VehiclesController::delete/$1');

    $routes->get('drivers', 'Admin\DriversController::index');
    $routes->get('drivers/create', 'Admin\DriversController::create');
    $routes->post('drivers/store', 'Admin\DriversController::store');
    $routes->get('drivers/edit/(:num)', 'Admin\DriversController::edit/$1');
    $routes->post('drivers/update/(:num)', 'Admin\DriversController::update/$1');
    $routes->get('drivers/delete/(:num)', 'Admin\DriversController::delete/$1');

    $routes->get('supplies', 'Admin\SuppliesController::index');
    $routes->get('supplies/create', 'Admin\SuppliesController::create');
    $routes->post('supplies/store', 'Admin\SuppliesController::store');
    $routes->get('supplies/edit/(:num)', 'Admin\SuppliesController::edit/$1');
    $routes->post('supplies/update/(:num)', 'Admin\SuppliesController::update/$1');
    $routes->get('supplies/delete/(:num)', 'Admin\SuppliesController::delete/$1');

    // Transactions & Approvals
    $routes->get('room-bookings', 'Admin\RoomBookingsController::index');
    $routes->get('room-bookings/edit/(:num)', 'Admin\RoomBookingsController::edit/$1');
    $routes->post('room-bookings/update/(:num)', 'Admin\RoomBookingsController::update/$1');
    $routes->post('room-bookings/approve/(:num)', 'Admin\RoomBookingsController::approve/$1');
    $routes->post('room-bookings/reject/(:num)', 'Admin\RoomBookingsController::reject/$1');
    $routes->get('room-bookings/delete/(:num)', 'Admin\RoomBookingsController::delete/$1');

    $routes->get('vehicle-bookings', 'Admin\VehicleBookingsController::index');
    $routes->get('vehicle-bookings/edit/(:num)', 'Admin\VehicleBookingsController::edit/$1');
    $routes->post('vehicle-bookings/update/(:num)', 'Admin\VehicleBookingsController::update/$1');
    $routes->post('vehicle-bookings/approve/(:num)', 'Admin\VehicleBookingsController::approve/$1');
    $routes->post('vehicle-bookings/reject/(:num)', 'Admin\VehicleBookingsController::reject/$1');
    $routes->post('vehicle-bookings/complete/(:num)', 'Admin\VehicleBookingsController::complete/$1');
    $routes->get('vehicle-bookings/delete/(:num)', 'Admin\VehicleBookingsController::delete/$1');

    // Maintenance & Security
    $routes->get('maintenance', 'Admin\MaintenanceController::index');
    $routes->post('maintenance/assign/(:num)', 'Admin\MaintenanceController::assign/$1');
    $routes->post('maintenance/resolve/(:num)', 'Admin\MaintenanceController::resolve/$1');

    $routes->get('security/visitors', 'Admin\SecurityController::visitors');
    $routes->post('security/visitor-checkin', 'Admin\SecurityController::visitorCheckIn');
    $routes->post('security/visitor-checkout/(:num)', 'Admin\SecurityController::visitorCheckOut/$1');
    
    $routes->get('security/lost-found', 'Admin\SecurityController::lostFound');
    $routes->post('security/lost-found/verify/(:num)', 'Admin\SecurityController::verifyClaim/$1');
});

