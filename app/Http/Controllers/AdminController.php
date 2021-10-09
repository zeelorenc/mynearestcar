<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Order;
use App\Schemas\OrderStatusSchema;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::query()
        ->where('to_date', '<', date('Y-m-d', time()))
        ->Where(function($query) {
            $query->where('status', OrderStatusSchema::PAID)
                  ->orWhere('status', OrderStatusSchema::UNPAID);
        });


        $orders = $orders
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.home')
            ->with('totalUsers', User::all()->count())
            ->with('totalCarparks', Carpark::all()->count())
            ->with('totalVehicles', Vehicle::all()->count())
            ->with('delayedOrders', $orders);
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
