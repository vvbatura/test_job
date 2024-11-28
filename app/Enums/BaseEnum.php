<?php

namespace App\Enums;

trait BaseEnum
{
    public static function toArray(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    public static function toArrayFromOne(): array
    {
        $values = [];
        foreach (self::cases() as $key => $case) {
            $values[$key+1] = $case->value;
        }
        return $values;
    }

    public static function getKey($value): int
    {
        return array_search($value, self::toArray());
    }

    public static function getKeyFromOne($value): int
    {
        return array_search($value, self::toArrayFromOne());
    }
}
