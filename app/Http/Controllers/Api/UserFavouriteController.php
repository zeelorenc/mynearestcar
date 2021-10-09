<?php

namespace App\Http\Controllers\Api;

use App\Adapters\DistanceAdapter;
use App\Models\Carpark;
use App\Models\User;
use App\Models\UserFavourite;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserFavouriteController extends \Illuminate\Routing\Controller
{
    public function index(User $user)
    {
        return $user->favourites->toArray();
    }

    public function store(User $user, Vehicle $vehicle)
    {
        if ($favourite = UserFavourite::where('user_id', $user->id)->where('vehicle_id', $vehicle->id)->first()) {
            $success = $favourite->delete();
            return ['success' => $success, 'message' => "Removed favourite for {$vehicle->id}"];
        }
        $favourite = UserFavourite::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
        ]);
        return [
            'success' => true,
            'message' => $favourite,
        ];
    }
}
