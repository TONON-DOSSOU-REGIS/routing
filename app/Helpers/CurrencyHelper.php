<?php

namespace App\Helpers;

use App\Models\User;

class CurrencyHelper
{
    /**
     * Get currency symbol from currency code
     */
    public static function getSymbol($currencyCode)
    {
        $symbols = [
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            'JPY' => '¥',
            'CHF' => 'CHF',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CNY' => '¥',
            'INR' => '₹',
            'BRL' => 'R$',
            'ZAR' => 'R',
            'RUB' => '₽',
            'KRW' => '₩',
            'MXN' => 'MX$',
            'SGD' => 'S$',
            'HKD' => 'HK$',
            'NOK' => 'kr',
            'SEK' => 'kr',
            'DKK' => 'kr',
            'PLN' => 'zł',
            'THB' => '฿',
            'IDR' => 'Rp',
            'HUF' => 'Ft',
            'CZK' => 'Kč',
            'ILS' => '₪',
            'CLP' => 'CLP$',
            'PHP' => '₱',
            'AED' => 'د.إ',
            'COP' => 'COL$',
            'SAR' => 'ر.س',
            'MYR' => 'RM',
            'RON' => 'lei',
            'TRY' => '₺',
            'NZD' => 'NZ$',
            'TWD' => 'NT$',
            'VND' => '₫',
            'ARS' => 'ARS$',
            'EGP' => 'E£',
            'PKR' => '₨',
            'BDT' => '৳',
            'NGN' => '₦',
            'UAH' => '₴',
            'KES' => 'KSh',
            'MAD' => 'د.م.',
            'XOF' => 'CFA',
        ];

        return $symbols[$currencyCode] ?? $currencyCode;
    }

    /**
     * Format amount with currency
     */
    public static function format($amount, $currencyCode = 'EUR')
    {
        $symbol = self::getSymbol($currencyCode);
        $formattedAmount = number_format($amount, 2, ',', ' ');
        
        // For currencies that go before the amount
        $prefixCurrencies = ['USD', 'GBP', 'CAD', 'AUD', 'HKD', 'SGD', 'MXN', 'NZD', 'ARS', 'CLP', 'COP', 'EGP'];
        
        if (in_array($currencyCode, $prefixCurrencies)) {
            return $symbol . $formattedAmount;
        }
        
        return $formattedAmount . ' ' . $symbol;
    }

    /**
     * Format amount for a specific user using their default currency
     */
    public static function formatForUser(User $user, $amount)
    {
        $currency = $user->default_currency ?? 'EUR';
        return self::format($amount, $currency);
    }

    /**
     * Format amount with division by 100 (for amounts stored in cents)
     */
    public static function formatCents($amount, $currencyCode = 'EUR')
    {
        return self::format($amount / 100, $currencyCode);
    }

    /**
     * Format amount in cents for a specific user
     */
    public static function formatCentsForUser(User $user, $amount)
    {
        $currency = $user->default_currency ?? 'EUR';
        return self::formatCents($amount, $currency);
    }
}

