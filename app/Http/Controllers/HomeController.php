<?php

namespace App\Http\Controllers;

use App\Models\Carpark;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $user = auth()->user();
        $currentOrder = $user->orders->filter(function ($order) {
            return $order->status === OrderStatusSchema::PAID
                && $order->vehicle->status === VehicleStatusSchema::BOOKED;
        })->first();
        return view('home')
            ->with('orders', $user->orders)
            ->with('totalVehicles', Vehicle::count())
            ->with('totalAvailableVehicles', Vehicle::where('status', VehicleStatusSchema::AVAILABLE)->count())
            ->with('totalCarparks', Carpark::count())
            ->with('currentOrder', $currentOrder);
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('contact');
    }
}
