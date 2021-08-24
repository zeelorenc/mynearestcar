<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class OrderController extends \Illuminate\Routing\Controller
{
    use ValidatesRequests;

    public function create(Request $request)
    {
        $this->validate($request, [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'from_date' => ['required', 'date', 'before:to_date'],
            'to_date' => ['required', 'date', 'after:from_date'],
            'uber_pickup' => ['required', 'boolean'],
        ]);

        $total = 100; // @todo

        $order = Order::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $request->get('vehicle_id'),
            'from_date' => Carbon::parse($request->get('from_date')),
            'to_date' => Carbon::parse($request->get('to_date')),
            'uber_pickup' => $request->get('uber_pickup'),
            'total' => $total,
            'status' => OrderStatusSchema::UNPAID,
        ]);
        return $order;
    }
}
