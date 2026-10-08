<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RoomBookingModel;
use App\Models\VehicleBookingModel;
use App\Models\VisitorModel;
use App\Models\MaintenanceRequestModel;
use App\Models\SupplyModel;
use App\Traits\RoleScopeTrait;

class DashboardController extends ResourceController
{
    use RoleScopeTrait;
    protected $format = 'json';

    public function getCalendarEvents()
    {
        $events = [];

        // Room Bookings
        $rbModel = new RoomBookingModel();
        $roomBookings = $rbModel->where('status', 'approved')->findAll();
        foreach ($roomBookings as $rb) {
            $events[] = [
                'id'    => 'room_' . $rb['id'],
                'title' => 'Room: ' . $rb['event_name'],
                'start' => $rb['start_time'],
                'end'   => $rb['end_time'],
                'color' => '#007bff', // blue
                'type'  => 'room_booking'
            ];
        }

        // Vehicle Bookings
        $vbModel = new VehicleBookingModel();
        $vehicleBookings = $vbModel->where('status', 'approved')->findAll();
        foreach ($vehicleBookings as $vb) {
            $events[] = [
                'id'    => 'vehicle_' . $vb['id'],
                'title' => 'Vehicle Trip: ' . $vb['destination'],
                'start' => $vb['departure_time'],
                'end'   => $vb['return_time'], // could be null
                'color' => '#28a745', // green
                'type'  => 'vehicle_booking'
            ];
        }

        return $this->respond($events);
    }

    public function getBookedSlots()
    {
        $roomId = $this->request->getVar('room_id');
        $vehicleId = $this->request->getVar('vehicle_id');
        
        $events = [];

        if ($roomId) {
            $rbModel = new RoomBookingModel();
            $roomBookings = $rbModel->where('room_id', $roomId)
                                    ->whereIn('status', ['approved', 'pending'])
                                    ->findAll();
            foreach ($roomBookings as $rb) {
                $events[] = [
                    'title' => 'Booked',
                    'start' => $rb['start_time'],
                    'end'   => $rb['end_time'],
                    'color' => '#dc3545',
                ];
            }
        }

        if ($vehicleId) {
            $vbModel = new VehicleBookingModel();
            $vehicleBookings = $vbModel->where('vehicle_id', $vehicleId)
                                       ->whereIn('status', ['approved', 'pending'])
                                       ->findAll();
            foreach ($vehicleBookings as $vb) {
                $events[] = [
                    'title' => 'Booked',
                    'start' => $vb['departure_time'],
                    'end'   => $vb['return_time'],
                    'color' => '#dc3545',
                ];
            }
        }

        return $this->respond($events);
    }

    public function getStatistics()
    {
        $stats = [];

        // Pending Room Approvals
        $rbModel = new RoomBookingModel();
        $stats['pending_room_approvals'] = $rbModel->where('status', 'pending')->countAllResults();

        // Pending Vehicle Approvals
        $vbModel = new VehicleBookingModel();
        $stats['pending_vehicle_approvals'] = $vbModel->where('status', 'pending')->countAllResults();

        // Active Visitors Today
        $vModel = new VisitorModel();
        $stats['active_visitors'] = $vModel->where('status', 'checked_in')
                                           ->like('check_in', date('Y-m-d'))
                                           ->countAllResults();

        // In Progress Maintenance
        $mModel = new MaintenanceRequestModel();
        $stats['in_progress_maintenance'] = $mModel->where('status', 'in_progress')->countAllResults();

        // Supplies Warning (stock < min_stock)
        $sModel = new SupplyModel();
        $suppliesWarning = $sModel->where('stock < min_stock')->findAll();
        $stats['supplies_warning_count'] = count($suppliesWarning);
        $stats['supplies_warning_items'] = $suppliesWarning;

        return $this->respond($stats);
    }
}

