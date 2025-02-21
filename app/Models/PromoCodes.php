<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PromoCodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'discount_percentage',
        'max_uses',
        'times_used',
        'user_limit',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Get all users who have used this promo code.
     */
    public function usages()
    {
        return $this->hasMany(PromoCodeUsage::class, 'promo_code_id');
    }

    /**
     * Scope to get only active promo codes (not expired and not fully used).
     */
    public function scopeActive($query)
    {
        return $query
            ->where('expires_at', '>', Carbon::now())
            ->whereColumn('times_used', '<', 'max_uses');
    }

    /**
     * Check if the promo code is expired.
     */
    public function isExpired()
    {
        return $this->expires_at && Carbon::now()->gt($this->expires_at);
    }

    /**
     * Check if the promo code has reached its max usage limit.
     */
    public function isFullyUsed()
    {
        return $this->times_used >= $this->max_uses;
    }

    /**
     * Check if a user can use the promo code.
     */
    public function canUserUse($userId)
    {
        // Check if the promo code has expired
        if ($this->expires_at && now()->greaterThan($this->expires_at)) {
            return false;
        }

        // Check if the promo code has reached its maximum usage limit
        if ($this->max_uses !== null) {
            $totalUsage = PromoCodeUsage::where('promo_code_id', $this->id)->count();
            if ($totalUsage >= $this->max_uses) {
                return false;
            }
        }

        // Check if the user has reached their personal usage limit
        $userUsageCount = PromoCodeUsage::where('promo_code_id', $this->id)
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->user_limit;
    }

    // Relationship with Orders (A promo code can be used in multiple orders)
    public function orders()
    {
        return $this->hasMany(Orders::class, 'promo_code_id');
    }
}
