<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RoomModel;
use App\Models\VehicleModel;
use App\Models\DriverModel;
use App\Models\SupplyModel;
use App\Models\RoomBookingModel;
use App\Models\VehicleBookingModel;

class AdminMasterController extends BaseController
{
    use ResponseTrait;

    // --- ROOMS CRUD ---
    public function getRooms()
    {
        $model = new RoomModel();
        return $this->respond($model->findAll());
    }

    public function createRoom()
    {
        $model = new RoomModel();
        $data = $this->request->getJSON(true);
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Room created', 'id' => $model->getInsertID()]);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function updateRoom($id)
    {
        $model = new RoomModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Room updated']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteRoom($id)
    {
        $model = new RoomModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Room deleted']);
        }
        return $this->fail('Failed to delete room');
    }

    // --- VEHICLES CRUD ---
    public function getVehicles()
    {
        $model = new VehicleModel();
        return $this->respond($model->findAll());
    }

    public function createVehicle()
    {
        $model = new VehicleModel();
        $data = $this->request->getJSON(true);
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Vehicle created', 'id' => $model->getInsertID()]);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function updateVehicle($id)
    {
        $model = new VehicleModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Vehicle updated']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteVehicle($id)
    {
        $model = new VehicleModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Vehicle deleted']);
        }
        return $this->fail('Failed to delete vehicle');
    }

    // --- DRIVERS CRUD ---
    public function getDrivers()
    {
        $model = new DriverModel();
        return $this->respond($model->findAll());
    }

    public function createDriver()
    {
        $model = new DriverModel();
        $data = $this->request->getJSON(true);
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Driver created', 'id' => $model->getInsertID()]);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function updateDriver($id)
    {
        $model = new DriverModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Driver updated']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteDriver($id)
    {
        $model = new DriverModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Driver deleted']);
        }
        return $this->fail('Failed to delete driver');
    }

    // --- SUPPLIES CRUD ---
    public function getSupplies()
    {
        $model = new SupplyModel();
        return $this->respond($model->findAll());
    }

    public function createSupply()
    {
        $model = new SupplyModel();
        $data = $this->request->getJSON(true);
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Supply created', 'id' => $model->getInsertID()]);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function updateSupply($id)
    {
        $model = new SupplyModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Supply updated']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteSupply($id)
    {
        $model = new SupplyModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Supply deleted']);
        }
        return $this->fail('Failed to delete supply');
    }

    // --- TRANSACTIONAL CRUD & APPROVAL ---
    public function updateRoomBooking($id)
    {
        $model = new RoomBookingModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Room booking updated by Admin']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteRoomBooking($id)
    {
        $model = new RoomBookingModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Room booking deleted by Admin']);
        }
        return $this->fail('Failed to delete room booking');
    }

    public function updateVehicleBooking($id)
    {
        $model = new VehicleBookingModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Vehicle booking updated by Admin']);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function deleteVehicleBooking($id)
    {
        $model = new VehicleBookingModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Vehicle booking deleted by Admin']);
        }
        return $this->fail('Failed to delete vehicle booking');
    }
}

