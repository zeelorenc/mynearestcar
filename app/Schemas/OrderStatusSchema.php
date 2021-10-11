<?php

namespace App\Schemas;

use function Symfony\Component\String\s;

class OrderStatusSchema
{
    public const UNPAID = 'unpaid';
    public const PAID = 'paid';
    public const COMPLETED = 'complete';

    /**
     * @param string $status
     * @return string
     */
    public static function asCssClass(string $status): string
    {
        return [
            self::COMPLETED => 'success',
            self::PAID => 'success',
            self::UNPAID => 'danger',
        ][$status] ?? '';
    }

    /**
     * All order statuses as an array
     *
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::UNPAID,
            self::PAID,
            self::COMPLETED,
        ];
    }
}
