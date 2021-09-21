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
        'total',
        'status',
        'stripe_charge_id',
        'user_location',
    ];

    protected $casts = [
        'user_location' => 'array',
    ];

    protected $dates = ['from_date', 'to_date'];

    protected $appends = [
        'grand_total',
    ];

    public function getGrandTotalAttribute(): float
    {
        $uberTotal = optional($this->uber)->total ?? 0;
        return round($this->total + $uberTotal, 2);
    }

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

    public function uber()
    {
        return $this->hasOne(OrderUber::class);
    }
}
