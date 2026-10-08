<?php
namespace App\Controllers;
class BookingFrontendController extends BaseController {
    public function room() { return view('booking/room'); }
    public function vehicle() { return view('booking/vehicle'); }
}
