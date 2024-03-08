<?php

namespace App\Helpers;

class CustomHelpers
{

    public static function sanitize(?string $data): ?string
    {
        if (is_null($data)) {
            return null;
        }
        return self::clear_string($data);
    }

    private static function clear_string(?string $string): ?string
    {
        if (is_null($string)) {
            return null;
        }

        return (string) preg_replace('/[^A-Za-z0-9]/', '', $string);
    }

}
