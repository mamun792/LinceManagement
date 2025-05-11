<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class License extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'license_key',
        'domain',
        'status',
        'created_time',
        'expires_at',
        'is_lifetime',
        'max_domains',
        'meta_data',
        'created_at',
        'updated_at',
        'last_verified_at',
        'verification_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'created_time' => 'datetime',
        'last_verified_at' => 'datetime',
        'verification_count' => 'integer',
        'is_lifetime' => 'boolean',
    ];

    /**
     * Hide sensitive attributes from JSON/array output
     */
    protected $hidden = [
        'meta_data',
    ];

    /**
     * Virtual attribute to check if license is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        // Lifetime licenses never expire
        if ($this->is_lifetime) {
            return false;
        }

        return $this->expires_at && now()->gt($this->expires_at);
    }

    /**
     * Get remaining days until expiration
     */
    public function getRemainingDaysAttribute(): ?int
    {
        if ($this->is_lifetime) {
            return -1; // Special value indicating infinite time
        }

        if ($this->is_expired) {
            return 0;
        }

        return now()->diffInDays($this->expires_at);
    }

    /**
     * Get the duration display for the license
     */
    public function getDurationDisplayAttribute(): string
    {
        if ($this->is_lifetime) {
            return 'Lifetime';
        }

        if ($this->is_expired) {
            return 'Expired';
        }

        $days = $this->remaining_days;

        if ($days > 365) {
            $years = floor($days / 365);
            $remainingDays = $days % 365;
            return "{$years}y {$remainingDays}d remaining";
        }

        if ($days > 30) {
            $months = floor($days / 30);
            $remainingDays = $days % 30;
            return "{$months}m {$remainingDays}d remaining";
        }

        return "{$days} days remaining";
    }

    /**
     * Scope for active licenses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for non-expired licenses
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($query) {
            $query->where('is_lifetime', true)
                ->orWhereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope for valid licenses (active and not expired)
     */
    public function scopeValid($query)
    {
        return $query->active()->notExpired();
    }
}
