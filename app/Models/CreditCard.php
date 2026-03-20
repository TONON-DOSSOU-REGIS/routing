<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder_name',
        'card_number',
        'card_type',
        'expiry_date',
        'is_visible_to_user',
    ];

    protected $dates = ['expiry_date'];

    protected $casts = [
        'expiry_date' => 'date',
        'is_visible_to_user' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mask card number for display
    public function getMaskedCardNumberAttribute()
    {
        $cardNumber = preg_replace('/\s+/', '', (string) $this->card_number);

        if ($cardNumber === '') {
            return '';
        }

        return '**** **** **** ' . substr($cardNumber, -4);
    }

    public function getFormattedCardNumberAttribute()
    {
        $cardNumber = preg_replace('/\s+/', '', (string) $this->card_number);

        if ($cardNumber === '') {
            return '';
        }

        return trim(chunk_split($cardNumber, 4, ' '));
    }
}
