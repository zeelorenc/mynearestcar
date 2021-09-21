<?php

namespace App\Http\Controllers\Api;

use App\Adapters\DistanceAdapter;
use App\Models\Carpark;
use Illuminate\Http\Request;

class CarparkController extends \Illuminate\Routing\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Carpark::withCount('vehicles')->get()->toArray();
    }

    public function vehicles(Carpark $carpark)
    {
        return $carpark->vehicles->toArray();
    }

    public function nearest(Request $request)
    {
        $latitude = $request->get('lat');
        $longitude = $request->get('lng');

        return Carpark::withCount('vehicles')
            ->get()
            ->map(function ($e) use ($latitude, $longitude) {
                $e['distance'] = DistanceAdapter::calculate($latitude, $longitude, $e->lat, $e->lng);
                return $e;
            })
            ->sortBy('distance')
            ->values();
    }
}
