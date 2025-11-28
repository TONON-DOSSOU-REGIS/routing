<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'kyc_verification_id',
        'type',
        'path',
        'mime_type',
        'size',
        'checksum',
        'extracted_data',
        'verified',
        'verified_at',
    ];

    protected $casts = [
        'size' => 'integer',
        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'extracted_data' => 'array',
    ];

    public function kycVerification()
    {
        return $this->belongsTo(KycVerification::class);
    }
}

