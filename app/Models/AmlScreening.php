<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmlScreening extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'query',
        'status',
        'score',
        'result',
        'screened_at',
        'rescreen_after',
        'last_rescreened_at',
    ];

    protected $casts = [
        'query' => 'array',
        'result' => 'array',
        'score' => 'decimal:2',
        'screened_at' => 'datetime',
        'rescreen_after' => 'datetime',
        'last_rescreened_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hits()
    {
        return $this->hasMany(SanctionsHit::class);
    }
}

