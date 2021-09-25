<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Schemas\OrderStatusSchema;

use App\Schemas\VehicleStatusSchema;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        return view('order.show')
            ->with('order', $order);
    }

    public function history()
    {
        $orders = auth()->user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.history')
            ->with('orders', $orders);
    }

    public function showCurrentOrder()
    {
        $order = auth()->user()->orders()->where('status', 'paid')->first();
        return view('order.show')
        ->with('order', $order);

    }
}
