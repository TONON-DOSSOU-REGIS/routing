<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'action_url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope to get unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope to get read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope to get notifications by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get icon class based on type if not set
     */
    public function getIconAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Default icons based on type
        return match($this->type) {
            'transaction' => 'fa-exchange-alt',
            'message' => 'fa-envelope',
            'alert' => 'fa-exclamation-triangle',
            'account' => 'fa-user',
            'system' => 'fa-cog',
            default => 'fa-bell',
        };
    }

    /**
     * Get color class based on type if not set
     */
    public function getColorAttribute($value)
    {
        if ($value && $value !== 'blue') {
            return $value;
        }

        // Default colors based on type
        return match($this->type) {
            'transaction' => 'green',
            'message' => 'blue',
            'alert' => 'red',
            'account' => 'purple',
            'system' => 'gray',
            default => 'blue',
        };
    }
}

