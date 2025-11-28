<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'recipient_name',
        'recipient_iban',
        'recipient_bic',
        'bank_name',
        'reason',
        'activation_code',
        'status',
        'progress',
        'message',
        'meta',
        'refunded_at',
        'refunded_by',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'progress' => 'integer',
        'meta' => 'array',
        'refunded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refundedBy()
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }

    public function isRefundable()
    {
        return $this->status === 'success' && $this->type === 'transfer';
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }
}

