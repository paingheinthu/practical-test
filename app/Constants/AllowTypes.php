<?php

namespace App\Constants;

enum AllowTypes: string
{
    case TEXT = 'text';
    case COMBO = 'combo';
    case DATETIME = 'datetime';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
