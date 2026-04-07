<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'priority',
        'audience',
        'expiry_date',
        'image',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user who created the announcement.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the announcement.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope to get only active announcements.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get announcements that haven't expired.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now());
        });
    }

    /**
     * Scope to get announcements for a specific audience.
     */
    public function scopeForAudience($query, $audience)
    {
        return $query->where('audience', $audience);
    }

    /**
     * Check if the announcement is expired.
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Get the priority color class.
     */
    public function getPriorityColorClass()
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'important' => 'warning',
            default => 'primary'
        };
    }

    /**
     * Get the priority label.
     */
    public function getPriorityLabel()
    {
        return match($this->priority) {
            'urgent' => 'Urgent',
            'important' => 'Important',
            default => 'Normal'
        };
    }

    /**
     * Get the audience label.
     */
    public function getAudienceLabel()
    {
        return match($this->audience) {
            'all' => 'All Users',
            'members' => 'Members Only',
            'leaders' => 'Leaders Only',
            'admins' => 'Admins Only',
            default => ucfirst($this->audience)
        };
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Set default values
        static::creating(function ($announcement) {
            if (!$announcement->created_by) {
                $announcement->created_by = auth()->id();
            }
            if (!$announcement->updated_by) {
                $announcement->updated_by = auth()->id();
            }
        });

        static::updating(function ($announcement) {
            $announcement->updated_by = auth()->id();
        });
    }
}
