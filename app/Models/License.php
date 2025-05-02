<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_key',
        'status',
        'created_time',
        'expires_at',
        'lifetime',
        'domain',
        'max_domains',
        'ip_restrictions',
        'notes',
    ];
    protected $table = 'licenses';
    protected $primaryKey = 'id';

    protected $casts = [
        'expires_at' => 'datetime',
        'last_check_at' => 'datetime',
        'meta_data' => 'array',
    ];
    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at > now();
    }
    public function isExpired()
    {
        return $this->status === 'expired' || $this->expires_at <= now();
    }
    public function isSuspended()
    {
        return $this->status === 'suspended';
    }
    public function isValidForDomain($domain)
    {
        return $this->domain === $domain && $this->isActive();
    }
    public function incrementUsageCount()
    {
        $this->increment('usage_count');
    }
    public function decrementUsageCount()
    {
        $this->decrement('usage_count');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('expires_at', '>', now());
    }
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')->orWhere('expires_at', '<=', now());
    }
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
    public function scopeWithDomain($query, $domain)
    {
        return $query->where('domain', $domain);
    }
    public function scopeWithKey($query, $key)
    {
        return $query->where('key', $key);
    }
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function scopeWithMetaData($query, $metaData)
    {
        return $query->where('meta_data', 'LIKE', '%' . $metaData . '%');
    }
}
