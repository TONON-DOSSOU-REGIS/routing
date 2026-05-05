<?php

namespace App\Support;

class PhoneNumber
{
    public const E164_PATTERN = '/^\+[1-9]\d{7,14}$/';

    public static function sanitize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        $hasLeadingPlus = str_starts_with($trimmed, '+');
        $digits = preg_replace('/\D+/', '', $trimmed) ?? '';

        if ($digits === '') {
            return null;
        }

        return ($hasLeadingPlus ? '+' : '') . $digits;
    }

    public static function normalize(?string $value): ?string
    {
        $sanitized = self::sanitize($value);

        if ($sanitized === null || !self::isValid($sanitized)) {
            return null;
        }

        return $sanitized;
    }

    public static function isValid(?string $value): bool
    {
        if ($value === null || $value === '') {
            return false;
        }

        return preg_match(self::E164_PATTERN, $value) === 1;
    }
}
