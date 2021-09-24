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

    public function edit()
    {
        // @todo create edit page and handling
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
}
