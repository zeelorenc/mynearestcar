<?php

namespace App\Http\Controllers\Api;

use App\Adapters\DistanceAdapter;
use App\Models\Carpark;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

        $carparks = Carpark::withCount('vehicles')->get();
        return $this->getNearestCarparks($carparks, $request);
    }

    public function filter(Request $request)
    {
        $carparks = Carpark::withCount('vehicles');

        if (filled($vehicleModel = $request->get('vehicle_model'))) {
            $carparks->whereHas('vehicles', function ($query) use ($vehicleModel) {
                $query->where('model', $vehicleModel);
            });
        }

        $carparks = $carparks->get();
        if ($request->has(['lat', 'lng'])) {
            return $this->getNearestCarparks($carparks, $request);
        } else {
            return $carparks;
        }
    }

    /**
     * @param Collection $carparks
     * @param Request $request
     * @return Collection
     */
    private function getNearestCarparks(Collection $carparks, Request $request): Collection
    {
        $latitude = $request->get('lat');
        $longitude = $request->get('lng');
        return $carparks
            ->map(function ($e) use ($latitude, $longitude) {
                $e['distance'] = DistanceAdapter::calculate($latitude, $longitude, $e->lat, $e->lng);
                return $e;
            })
            ->sortBy('distance')
            ->values();
    }
}
