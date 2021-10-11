<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carpark;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.vehicle.index')
            ->with('vehicles', $vehicles);
    }

    public function create()
    {
        return view('admin.vehicle.create')
            ->with('carparks', Carpark::all());
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicle.edit')
            ->with('vehicle', $vehicle)->with('carparks', Carpark::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'carpark_id' => ['required', 'numeric', 'exists:carparks,id'],
            'status' => ['required', 'string', Rule::in(VehicleStatusSchema::all())],
            'price' => ['required', 'numeric', 'min:0'],
            'seats' => ['required', 'numeric', 'min:1', 'max:24']
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

    public function update(Vehicle $vehicle, Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'carpark_id' => ['required', 'numeric', 'exists:carparks,id'],
            'status' => ['required', 'string', Rule::in(VehicleStatusSchema::all())],
            'price' => ['required', 'numeric', 'min:0'],
            'seats' => ['required', 'numeric', 'min:1', 'max:24']
        ]);

        $vehicle->name = $request->get('name');
        $vehicle->carpark_id = $request->get('carpark_id');
        $vehicle->status = $request->get('status');
        $vehicle->price = $request->get('price');
        $vehicle->seats = $request->get('seats');
        $vehicle->save();

        return back()->with('message', 'Changed information successfully!');
    }
}
