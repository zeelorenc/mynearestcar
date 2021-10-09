<?php

namespace App\Models;

use App\Adapters\GoogleMapsAdapter;
use App\Schemas\OrderStatusSchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'from_date',
        'to_date',
        'total',
        'status',
        'stripe_charge_id',
        'user_location',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_location' => 'array',
    ];

    protected $dates = ['from_date', 'to_date'];

    protected $appends = [
        'grand_total',
    ];

    protected $sortable = [
        'from_date',
        'to_date',
        'total',
        'status',
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

    /**
     * Return google location information of the order origin
     *
     * @return array|null
     */
    public function origin(): ?array
    {
        $instance = new GoogleMapsAdapter(
            Arr::get($this->user_location, 'lat'),
            Arr::get($this->user_location, 'lng')
        );
        return $instance->searchWithDetails();
    }

}
