<?php

namespace App\Schemas;

use Illuminate\Support\Collection;

class VehicleStatusSchema
{
    public const AVAILABLE = 'available';
    public const PENDING = 'pending';
    public const BOOKED = 'booked';
    public const RETURNED = 'returned';

    /**
     * All vehicle statuses as an array
     *
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::AVAILABLE,
            self::PENDING,
            self::BOOKED,
            self::RETURNED,
        ];
    }
}
