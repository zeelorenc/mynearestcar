<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'seats',
        'price',
        'status',
        'carpark_id',
    ];

    /**
     * Return's the vehicle's carpark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carpark()
    {
        return $this->belongsTo(Carpark::class);
    }
}
