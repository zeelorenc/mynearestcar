<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // $order_id = request()->get("id");
        $order->status = "returned";
        $order->save();

        return back()->with('message', 'Vehicle returned successfully!');
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
