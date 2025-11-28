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
    ];

    protected $dates = ['expiry_date'];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mask card number for display
    public function getMaskedCardNumberAttribute()
    {
        return '**** **** **** ' . substr($this->card_number, -4);
    }
}

