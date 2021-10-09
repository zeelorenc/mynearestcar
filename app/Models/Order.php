<?php

namespace App\Models;

use App\Adapters\GoogleMapsAdapter;
use App\Adapters\StripeAdapter;
use App\Schemas\OrderStatusSchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory;
    use Sortable;

    public const SECURITY_DEPOSIT_PERCENT = 20;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'from_date',
        'to_date',
        'total',
        'status',
        'stripe_charge_id',
        'stripe_refund_id',
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
        'security_deposit',
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

    public function getSecurityDepositAttribute(): float
    {
        return $this->grand_total * self::SECURITY_DEPOSIT_PERCENT / 100;
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

    /**
     * Refunds the security deposit and any unused time
     *
     * @return array|null
     */
    public function refund(): ?array
    {
        if (filled($this->stripe_refund_id)) {
            return null;
        }

        /** @var float $daysTillDue */
        $daysTillDue = round(now()->floatDiffInDays($this->to_date, false), 3);
        if ($daysTillDue < 0) {
            return null;
        }

        $unusedDollars = round($this->vehicle->price * $daysTillDue, 2);
        $refund = StripeAdapter::make()
            ->withChargeId($this->stripe_charge_id)
            ->refund($this->security_deposit + $unusedDollars);

        return $this->update(['stripe_refund_id' => $refund['id']])
            ? $refund
            : null;
    }

}
