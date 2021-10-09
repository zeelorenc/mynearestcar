<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Date;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        //
    }

    public function search(Request $request)
    {
        $orders = Order::query();

        if (filled($query = $request->get('query'))) {
            $orders->orWhereHas('vehicle', function ($vehicle) use ($query) {
                $vehicle->where('name', 'like', "%{$query}%");
            });
            $orders->orWhereHas('user', function ($user) use ($query) {
                $user->where('name', 'like', "%{$query}%");
            });
        }

        $orders = $orders
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.order.search')
            ->with('orders', $orders);
    }

    public function update(Order $order, Request $request)
    {
        if ($order->vehicle->status === VehicleStatusSchema::RETURNED) {
            $order->update([
                'status' => OrderStatusSchema::COMPLETED,
            ]);
            $order->vehicle->update([
                'status' => VehicleStatusSchema::AVAILABLE,
            ]);
            return back()->with('message', 'The vehicle return processed successfully and order is now completed!');
        } else {
            return back()->with('error', 'Order has not been marked as confirmed as its vehicle is not returned.');
        }
    }

    public function forceUpdate(Order $order, Request $request)
    {
        if ($order->status === OrderStatusSchema::PAID) {
            $order->update([
                'status' => OrderStatusSchema::COMPLETED,
            ]);
            $order->vehicle->update([
                'status' => VehicleStatusSchema::AVAILABLE,
            ]);
            return back()->with('message', 'The vehicle return processed successfully and order is now completed!');
        } else {
            return back()->with('error', 'Order has not been marked as confirmed as its vehicle is not returned.');
        }
    }
    public function edit()
    {
        // @todo create edit page and handling
    }

    public function store(Request $request)
    {
        //
    }
}
