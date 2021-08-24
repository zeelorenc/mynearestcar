<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'from_date',
        'to_date',
        'uber_pickup',
        'total',
        'status',
    ];

    protected $dates = ['from_date', 'to_date'];
}
