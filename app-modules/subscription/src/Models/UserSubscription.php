<?php

namespace Modules\Subscription\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Payment\Models\Payment;
use Modules\Coupon\Models\Coupon;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'payment_id',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'status',
        'paid_amount',
        'currency',
        'coupon_id',
        'discount_amount',
        'coupon_code',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'paid_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the payment for this subscription
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the coupon used (if any)
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Scope for active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('starts_at', '<=', now())
                    ->where('ends_at', '>', now());
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'expired')
              ->orWhere('ends_at', '<=', now());
        });
    }

    /**
     * Scope for user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if subscription is currently active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' 
               && $this->starts_at <= now() 
               && $this->ends_at > now()
               && is_null($this->cancelled_at);
    }

    /**
     * Check if subscription is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->ends_at <= now() || $this->status === 'expired';
    }

    /**
     * Check if subscription is cancelled
     */
    public function getIsCancelledAttribute(): bool
    {
        return !is_null($this->cancelled_at) || $this->status === 'cancelled';
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_expired || $this->is_cancelled) {
            return 0;
        }
        
        return now()->diffInDays($this->ends_at, false);
    }

    /**
     * Get formatted paid amount
     */
    public function getFormattedPaidAmountAttribute(): string
    {
        return number_format($this->paid_amount, 0) . ' ' . $this->currency;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        switch ($this->status) {
            case 'active':
                return 'success';
            case 'expired':
                return 'danger';
            case 'cancelled':
                return 'warning';
            case 'pending':
                return 'info';
            default:
                return 'secondary';
        }
    }

    /**
     * Cancel the subscription
     */
    public function cancel(): bool
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
        
        return true;
    }

    /**
     * Extend subscription by duration
     */
    public function extend(int $months): bool
    {
        $newEndDate = $this->ends_at->addMonths($months);
        
        $this->update([
            'ends_at' => $newEndDate,
            'status' => 'active'
        ]);
        
        return true;
    }

    /**
     * Mark subscription as expired
     */
    public function markAsExpired(): bool
    {
        $this->update(['status' => 'expired']);
        return true;
    }

    /**
     * Auto-update status based on dates
     */
    public function updateStatus(): bool
    {
        if ($this->is_cancelled) {
            return true; // Don't change cancelled status
        }
        
        if ($this->ends_at <= now()) {
            $this->update(['status' => 'expired']);
        } elseif ($this->starts_at <= now() && $this->ends_at > now()) {
            $this->update(['status' => 'active']);
        }
        
        return true;
    }
}