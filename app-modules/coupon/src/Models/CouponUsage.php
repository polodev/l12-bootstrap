<?php

namespace Modules\Coupon\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Subscription\Models\UserSubscription;

class CouponUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'user_id',
        'user_subscription_id',
        'discount_amount',
        'used_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    /**
     * Get the coupon that was used
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the user who used the coupon
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription this coupon was used for
     */
    public function userSubscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class);
    }

    /**
     * Scope for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for a specific coupon
     */
    public function scopeForCoupon($query, $couponId)
    {
        return $query->where('coupon_id', $couponId);
    }

    /**
     * Get formatted discount amount
     */
    public function getFormattedDiscountAmountAttribute(): string
    {
        return number_format($this->discount_amount, 0) . ' BDT';
    }
}