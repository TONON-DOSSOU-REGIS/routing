<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'stop_percentage',
        'stop_message',
        'target_user_id',
        'is_global',
    ];

    protected function casts(): array
    {
        return [
            'stop_percentage' => 'integer',
            'is_global' => 'boolean',
        ];
    }
}
