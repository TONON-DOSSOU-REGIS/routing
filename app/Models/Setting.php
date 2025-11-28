<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'stop_percentage',
        'stop_message',
    ];

    protected function casts(): array
    {
        return [
            'stop_percentage' => 'integer',
        ];
    }
}

