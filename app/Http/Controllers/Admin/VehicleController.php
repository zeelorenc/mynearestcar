<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'asc')
            ->paginate(10);

        return view('admin.vehicle.index')
            ->with('vehicles', $vehicles);
    }

    public function create()
    {
        return view('admin.vehicle.create');
    }

    public function edit()
    {
        // @todo create edit page and handling
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'carpark_id' => ['required', 'numeric', 'exists:carparks,id'],
            'status' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'seats' => ['required', 'numeric']
        ]);

        Vehicle::create([
            'name' => $request->get('name'),
            'carpark_id' => $request->get('carpark_id'),
            'status' => $request->get('status'),
            'price' => $request->get('price'),
            'seats' => $request->get('seats')
        ]);

        return back()->with('message', 'Added a vehicle successfully!');
    }
}
