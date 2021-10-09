<?php

namespace App\Http\Controllers;

use App\Adapters\GoogleMapsAdapter;
use App\Models\Order;

use App\Schemas\VehicleStatusSchema;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $originOrigin = GoogleMapsAdapter::make(
            Arr::get($order->user_location, 'lat'),
            Arr::get($order->user_location, 'lng')
        )->searchWithDetails();
        return view('order.show')
            ->with('orderOrigin', Arr::get($originOrigin, 'details.formatted_address'))
            ->with('order', $order);
    }

    public function history()
    {
        $orders = auth()->user()->orders()->sortable()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('order.history')
            ->with('orders', $orders);
    }

    public function current()
    {
        $order = auth()->user()->orders()->where('status', 'paid')->first();
        return $this->show($order);
    }

    public function return(Order $order)
    {
        $order->vehicle->update([
            'status' => VehicleStatusSchema::RETURNED,
        ]);
        return back()->with('message', 'Vehicle returned, wait for manager\'s response.');
    }
}
