<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpark extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'lat',
        'lng',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
