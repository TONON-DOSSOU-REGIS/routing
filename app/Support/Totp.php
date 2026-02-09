<?php

namespace App\Support;

class Totp
{
    private const BASE32_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public static function generateSecret(int $length = 32): string
    {
        $chars = self::BASE32_ALPHABET;
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $secret;
    }

    public static function getOtpAuthUrl(string $issuer, string $email, string $secret): string
    {
        $label = rawurlencode($issuer . ':' . $email);
        $issuerEncoded = rawurlencode($issuer);
        return "otpauth://totp/{$label}?secret={$secret}&issuer={$issuerEncoded}&algorithm=SHA1&digits=6&period=30";
    }

    public static function verifyCode(string $secret, string $code, int $window = 1): bool
    {
        $code = preg_replace('/\s+/', '', $code ?? '');
        if (!preg_match('/^\d{6}$/', $code)) {
            return false;
        }

        $time = time();
        $timeStep = 30;
        $counter = (int) floor($time / $timeStep);

        for ($i = -$window; $i <= $window; $i++) {
            $expected = self::hotp($secret, $counter + $i);
            if (hash_equals($expected, $code)) {
                return true;
            }
        }

        return false;
    }

    private static function hotp(string $secret, int $counter): string
    {
        $key = self::base32Decode($secret);
        $counterBytes = pack('N*', 0) . pack('N*', $counter);
        $hash = hash_hmac('sha1', $counterBytes, $key, true);
        $offset = ord($hash[19]) & 0x0F;
        $binary = ((ord($hash[$offset]) & 0x7F) << 24)
            | ((ord($hash[$offset + 1]) & 0xFF) << 16)
            | ((ord($hash[$offset + 2]) & 0xFF) << 8)
            | (ord($hash[$offset + 3]) & 0xFF);
        $otp = $binary % 1000000;
        return str_pad((string) $otp, 6, '0', STR_PAD_LEFT);
    }

    private static function base32Decode(string $input): string
    {
        $input = strtoupper($input);
        $input = preg_replace('/[^A-Z2-7]/', '', $input);

        $binaryString = '';
        $alphabet = self::BASE32_ALPHABET;
        foreach (str_split($input) as $char) {
            $index = strpos($alphabet, $char);
            if ($index === false) {
                continue;
            }
            $binaryString .= str_pad(decbin($index), 5, '0', STR_PAD_LEFT);
        }

        $bytes = '';
        foreach (str_split($binaryString, 8) as $byte) {
            if (strlen($byte) === 8) {
                $bytes .= chr(bindec($byte));
            }
        }

        return $bytes;
    }
}
