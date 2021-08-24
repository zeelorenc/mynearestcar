<?php

namespace App\Schemas;

class OrderStatusSchema
{
    public const UNPAID = 'unpaid';
    public const PAID = 'paid';

    /**
     * @param string $status
     * @return string
     */
    public static function asCssClass(string $status): string
    {
        return [
            self::PAID => 'text-success',
            self::UNPAID => 'text-danger',
        ][$status] ?? '';
    }
}
