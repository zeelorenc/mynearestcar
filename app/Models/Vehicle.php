<?php

namespace App\Models;

use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Vehicle extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'name',
        'type',
        'model',
        'brand',
        'seats',
        'price',
        'status',
        'carpark_id',
    ];

    protected $sortable = [
        'name',
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

    public function returned()
    {
        return $this->status === VehicleStatusSchema::RETURNED;
    }

}
