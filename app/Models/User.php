<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'locale',
        'phone',
        'address',
        'country',
        'city',
        'date_of_birth',
        'id_type',
        'id_number',
        'iban',
        'bic',
        'role',
        'balance',
        'default_currency',
        'status',
        'password',
        'activation_code',
        'oauth_provider',
        'oauth_id',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_backup_codes',
        'login_link_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
            'date_of_birth' => 'date',
            'two_factor_enabled' => 'boolean',
            'two_factor_backup_codes' => 'array',
            'two_factor_confirmed_at' => 'datetime',
            'login_link_expires_at' => 'datetime',
            'login_link_used_at' => 'datetime',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function creditCard()
    {
        return $this->hasOne(CreditCard::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSuspended()
    {
        return $this->status === 'suspended';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false)->orderBy('created_at', 'desc');
    }

    /**
     * Get formatted balance with currency symbol
     */
    public function getFormattedBalanceAttribute()
    {
        $currency = $this->default_currency ?? 'EUR';
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
        
        $symbol = $symbols[$currency] ?? $currency;
        $amount = number_format($this->balance, 2, ',', ' ');
        
        // Currencies that go before the amount
        $prefixCurrencies = ['USD', 'GBP', 'CAD', 'AUD', 'HKD', 'SGD', 'MXN', 'NZD', 'ARS', 'CLP', 'COP', 'EGP'];
        
        if (in_array($currency, $prefixCurrencies)) {
            return $symbol . $amount;
        }
        
        return $amount . ' ' . $symbol;
    }

    /**
     * Get currency symbol
     */
    public function getCurrencySymbolAttribute()
    {
        $currency = $this->default_currency ?? 'EUR';
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
        
        return $symbols[$currency] ?? $currency;
    }

    /**
     * Get the user's full name
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->profile_photo_path) {
            return null;
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->profile_photo_path);
    }
}
