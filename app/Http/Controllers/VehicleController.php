<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use App\Schemas\VehicleStatusSchema;
class VehicleController extends Controller
{
    public function search()
    {
        return view('vehicle.search');
    }

}
