<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home')
            ->with('totalUsers', User::all()->count())
            ->with('totalCarparks', Carpark::all()->count())
            ->with('totalVehicles', Vehicle::all()->count());
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function register()
    {
        return view('admin.auth.register');
    }
}
