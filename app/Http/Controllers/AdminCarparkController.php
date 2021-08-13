<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carpark;

class AdminCarparkController extends Controller
{
    public function add() {
        return view('admin.carpark.add');
    }

    public function save(Carpark $carpark, Request $request) {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric']
        ]);

        $carpark->name = $request->get('name');
        $carpark->lat = $request->get('latitude');
        $carpark->lng = $request->get('longitude');
        $carpark->save();

        return back()->with('message', 'Added car park location successfully!');
    }
}
