<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carpark;

class CarparkController extends Controller
{
    public function index()
    {
        return view('admin.carpark.index');
    }

    public function create()
    {
        return view('admin.carpark.create');
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
