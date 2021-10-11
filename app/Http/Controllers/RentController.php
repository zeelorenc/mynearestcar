<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index()
    {
        return view('rent')
            ->with('vehicleModels', Vehicle::all()->pluck('model')->unique());
    }
}
