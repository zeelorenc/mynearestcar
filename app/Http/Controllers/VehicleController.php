<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function search()
    {
        return view('vehicle.search');
    }
}
