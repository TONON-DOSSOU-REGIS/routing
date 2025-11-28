<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanctionsHit extends Model
{
    use HasFactory;

    protected $fillable = [
        'aml_screening_id',
        'list_name',
        'entity_name',
        'dob',
        'country',
        'score',
        'raw',
    ];

    protected $casts = [
        'dob' => 'date',
        'score' => 'decimal:2',
        'raw' => 'array',
    ];

    public function screening()
    {
        return $this->belongsTo(AmlScreening::class, 'aml_screening_id');
    }
}

