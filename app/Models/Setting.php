<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'stop_percentage',
        'stop_message',
        'target_user_id',
    ];

    protected function casts(): array
    {
        return [
            'stop_percentage' => 'integer',
        ];
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
