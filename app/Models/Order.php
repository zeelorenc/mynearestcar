<?php

namespace App\Models;

use App\Schemas\OrderStatusSchema;
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
        'stripe_charge_id',
    ];

    protected $dates = ['from_date', 'to_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function paid()
    {
        return $this->status === OrderStatusSchema::PAID;
    }
}
