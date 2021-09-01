<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Http\Request;
use App\Models\Order;

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
        $orders = new Order();

        if ($request->has('vehicle_id')) {
            $orders = $orders->where('vehicle_id', $request->get('vehicle_id'));
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
            $order->vehicle->update([
                'status' => VehicleStatusSchema::AVAILABLE,
            ]);
            return back()->with('message', 'Vehicle returned successfully!');
        } else {
            return back()->with('message', 'Vehicle has not been marked as returned.');
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
