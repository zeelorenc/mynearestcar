<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class OrderUber extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'route_data',
    ];

    protected $casts = [
        'route_data' => 'array',
    ];

    protected $appends = [
        'total',
        'distance',
    ];

    /**
     * Get the total of the uber cost based off the distance
     *
     * @return float
     */
    public function getTotalAttribute(): float
    {
        return 5 + ($this->distance / 1000) * 2.5;
    }

    /**
     * Get distance of the uber order based off route
     *
     * @return int
     */
    public function getDistanceAttribute(): int
    {
        return Arr::get($this->route_data, 'routes.0.legs.0.distance.value', 0);
    }
}
