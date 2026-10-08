<?php

namespace App\Traits;

use App\Models\RoomBookingModel;
use App\Models\VehicleBookingModel;

trait OverlapValidationTrait
{
    /**
     * Check if a resource is already booked for the given time slot.
     *
     * @param int $resourceId ID of the room or vehicle
     * @param string $startTime YYYY-MM-DD HH:MM:SS
     * @param string $endTime YYYY-MM-DD HH:MM:SS
     * @param string $type 'room' or 'vehicle'
     * @param int|null $excludeBookingId (Optional) Booking ID to exclude when updating
     * @return bool True if booked (overlap exists), False if available
     */
    protected function isSlotBooked($resourceId, $startTime, $endTime, $type, $excludeBookingId = null)
    {
        if ($type === 'room') {
            $model = new RoomBookingModel();
            $resourceField = 'room_id';
            $startField = 'start_time';
            $endField = 'end_time';
        } else {
            $model = new VehicleBookingModel();
            $resourceField = 'vehicle_id';
            $startField = 'departure_time';
            $endField = 'return_time';
        }

        $builder = $model->where($resourceField, $resourceId)
                         ->where('status !=', 'rejected')
                         ->where('status !=', 'cancelled');
                         
        if ($excludeBookingId !== null) {
            $builder->where('id !=', $excludeBookingId);
        }

        $conflict = $builder->groupStart()
                                ->where($startField . ' <', $endTime)
                                ->where($endField . ' >', $startTime)
                            ->groupEnd()
                            ->first();

        return $conflict ? true : false;
    }
}

