<?php

namespace App\Enums;

enum CurrencyType: string
{
    case Kyat = 'kyat';
    case Baht = 'baht';
    case Yuan = 'yuan';
    case USD  =  'USD';

    public static function values(): array
    {
        return array_map(fn(self $type) => $type->value, self::cases());
    }

    public static function keys(): array
    {
        return array_map(fn(self $type) => $type->name, self::cases());
    }

    public static function keyValuePairs(): array
    {
        return array_combine(
            self::keys(),
            self::values()
        );
    }
}

?>