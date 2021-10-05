<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carpark;

class CarparkController extends Controller
{
    public function index()
    {
        $carparks = Carpark::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.carpark.index')
            ->with('carparks', $carparks);
    }

    public function create()
    {
        return view('admin.carpark.create');
    }

    public function edit(Carpark $carpark)
    {
        return view('admin.carpark.edit')
            ->with('carpark', $carpark);
    }

    public function destroy(Carpark $carpark)
    {
        $carpark->delete();

        return back()->with('message', 'Deleted Carpark successfully!');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric']
        ]);

        Carpark::create([
            'name' => $request->get('name'),
            'lat' => $request->get('latitude'),
            'lng' => $request->get('longitude'),
        ]);
        return back()->with('message', 'Added carpark location successfully!');
    }

    public function update(Carpark $carpark, Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric']
        ]);

        $carpark->name = $request->get('name');
        $carpark->lat = $request->get('latitude');
        $carpark->lng = $request->get('longitude');
        $carpark->save();

        return back()->with('message', 'Changed information successfully!');
    }
}
