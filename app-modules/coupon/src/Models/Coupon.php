<?php

namespace Modules\Coupon\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Subscription\Models\SubscriptionPlan;
use Modules\Subscription\Models\UserSubscription;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'applicable_plans',
        'starts_at',
        'expires_at',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'used_count' => 'integer',
        'usage_limit' => 'integer',
        'usage_limit_per_user' => 'integer',
        'applicable_plans' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created this coupon
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get coupon usages
     */
    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Get user subscriptions that used this coupon
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Scope for active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope for coupons by code
     */
    public function scopeByCode($query, string $code)
    {
        return $query->where('code', $code);
    }

    /**
     * Check if coupon is valid for a user and plan
     */
    public function isValidForUser(User $user, SubscriptionPlan $plan, float $amount): array
    {
        // Check if coupon is active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Coupon is not active.'];
        }

        // Check date validity
        if ($this->starts_at && $this->starts_at > now()) {
            return ['valid' => false, 'message' => 'Coupon is not yet valid.'];
        }

        if ($this->expires_at && $this->expires_at <= now()) {
            return ['valid' => false, 'message' => 'Coupon has expired.'];
        }

        // Check minimum amount
        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return ['valid' => false, 'message' => "Minimum purchase amount is {$this->minimum_amount} BDT."];
        }

        // Check plan eligibility
        if ($this->applicable_plans && !in_array($plan->id, $this->applicable_plans)) {
            return ['valid' => false, 'message' => 'Coupon is not applicable to this plan.'];
        }

        // Check total usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Coupon usage limit exceeded.'];
        }

        // Check per-user usage limit
        if ($this->usage_limit_per_user) {
            $userUsageCount = $this->usages()->where('user_id', $user->id)->count();
            if ($userUsageCount >= $this->usage_limit_per_user) {
                return ['valid' => false, 'message' => 'You have already used this coupon the maximum number of times.'];
            }
        }

        return ['valid' => true, 'message' => 'Coupon is valid.'];
    }

    /**
     * Calculate discount amount for given amount
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            $discount = ($this->value / 100) * $amount;
            
            // Apply maximum discount limit if set
            if ($this->maximum_discount && $discount > $this->maximum_discount) {
                $discount = $this->maximum_discount;
            }
            
            return $discount;
        } else {
            // Fixed amount discount
            return min($this->value, $amount); // Don't discount more than the total amount
        }
    }

    /**
     * Apply coupon to user subscription
     */
    public function applyToSubscription(User $user, UserSubscription $subscription): bool
    {
        // Create usage record
        CouponUsage::create([
            'coupon_id' => $this->id,
            'user_id' => $user->id,
            'user_subscription_id' => $subscription->id,
            'discount_amount' => $subscription->discount_amount,
            'used_at' => now(),
        ]);

        // Increment usage count
        $this->increment('used_count');

        return true;
    }

    /**
     * Get formatted discount value
     */
    public function getFormattedDiscountAttribute(): string
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        } else {
            return number_format($this->value, 0) . ' BDT';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        if ($this->starts_at && $this->starts_at > now()) {
            return 'Upcoming';
        }

        if ($this->expires_at && $this->expires_at <= now()) {
            return 'Expired';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'Exhausted';
        }

        return 'Active';
    }

    /**
     * Get remaining uses
     */
    public function getRemainingUsesAttribute(): ?int
    {
        if (!$this->usage_limit) {
            return null; // Unlimited
        }

        return max(0, $this->usage_limit - $this->used_count);
    }

    /**
     * Static method to find and validate coupon
     */
    public static function findAndValidate(string $code, User $user, SubscriptionPlan $plan, float $amount): array
    {
        $coupon = static::byCode($code)->first();

        if (!$coupon) {
            return ['valid' => false, 'message' => 'Invalid coupon code.', 'coupon' => null];
        }

        $validation = $coupon->isValidForUser($user, $plan, $amount);
        $validation['coupon'] = $validation['valid'] ? $coupon : null;

        return $validation;
    }
}