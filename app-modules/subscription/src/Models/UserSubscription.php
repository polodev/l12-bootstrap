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
        'activated_at',
        'cancelled_at',
        'paid_amount',
        'currency',
        'coupon_id',
        'discount_amount',
        'coupon_code',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'activated_at' => 'datetime',
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
     * Get the dynamic status based on payment and dates
     */
    public function getStatusAttribute(): string
    {
        // If manually cancelled
        if ($this->cancelled_at && $this->cancelled_at <= now()) {
            return 'cancelled';
        }

        // If no payment or payment is not completed
        if (!$this->payment_id || !$this->payment || $this->payment->status !== 'completed') {
            return 'pending';
        }

        // Check date-based status
        $now = now();
        
        if ($this->starts_at > $now) {
            return 'upcoming'; // Extension that will start in future
        }
        
        if ($this->ends_at <= $now) {
            return 'expired';
        }
        
        return 'active';
    }

    /**
     * Scope for active subscriptions (currently running)
     */
    public function scopeActive($query)
    {
        return $query->whereHas('payment', function($q) {
                        $q->where('status', 'completed');
                    })
                    ->where('starts_at', '<=', now())
                    ->where('ends_at', '>', now())
                    ->where(function($q) {
                        $q->whereNull('cancelled_at')
                          ->orWhere('cancelled_at', '>', now());
                    });
    }

    /**
     * Scope for pending subscriptions (unpaid)
     */
    public function scopePending($query)
    {
        return $query->whereDoesntHave('payment')
                    ->orWhereHas('payment', function($q) {
                        $q->where('status', '!=', 'completed');
                    });
    }

    /**
     * Scope for upcoming subscriptions (extensions that will start in future)
     */
    public function scopeUpcoming($query)
    {
        return $query->whereHas('payment', function($q) {
                        $q->where('status', 'completed');
                    })
                    ->where('starts_at', '>', now())
                    ->where(function($q) {
                        $q->whereNull('cancelled_at')
                          ->orWhere('cancelled_at', '>', now());
                    });
    }

    /**
     * Scope for expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where('ends_at', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('cancelled_at')
                          ->orWhere('cancelled_at', '>', now());
                    });
    }

    /**
     * Scope for cancelled subscriptions
     */
    public function scopeCancelled($query)
    {
        return $query->whereNotNull('cancelled_at')
                    ->where('cancelled_at', '<=', now());
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
        return $this->status === 'active';
    }

    /**
     * Check if subscription is expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->status === 'expired';
    }

    /**
     * Check if subscription is cancelled
     */
    public function getIsCancelledAttribute(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if subscription is pending payment
     */
    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if subscription is upcoming (future extension)
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->status === 'upcoming';
    }

    /**
     * Get days remaining
     */
    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_expired || $this->is_cancelled) {
            return 0;
        }
        
        return (int) now()->diffInDays($this->ends_at, false);
    }

    /**
     * Get days remaining until expiry for a user (static helper)
     */
    public static function getDaysRemainingForUser($userId): int
    {
        $subscription = static::forUser($userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->orderBy('ends_at', 'desc')
            ->first();

        if (!$subscription) {
            return 0;
        }

        return $subscription->days_remaining;
    }

    /**
     * Check if user can purchase more subscription (not more than 500 days remaining)
     */
    public static function canUserPurchase($userId): bool
    {
        $daysRemaining = static::getDaysRemainingForUser($userId);
        return $daysRemaining <= 500;
    }

    /**
     * Get overall subscription status for user (handles subscription chains)
     */
    public static function getOverallStatusForUser($userId): string
    {
        // Get current active subscription
        $activeSubscription = static::forUser($userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>', now())
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->first();

        // If user has active subscription right now
        if ($activeSubscription) {
            return 'active';
        }

        // Check if user has upcoming subscriptions (extensions)
        $upcomingSubscription = static::forUser($userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where('starts_at', '>', now())
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->first();

        if ($upcomingSubscription) {
            return 'upcoming';
        }

        // Check if user has expired subscriptions
        $expiredSubscription = static::forUser($userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where('ends_at', '<=', now())
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->first();

        if ($expiredSubscription) {
            return 'expired';
        }

        return 'none';
    }

    /**
     * Get subscription period info for user (handles subscription chains)
     */
    public static function getSubscriptionPeriodForUser($userId): ?array
    {
        // Get earliest start date and latest end date for complete period
        $subscriptions = static::forUser($userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->orderBy('starts_at', 'asc')
            ->get();

        if ($subscriptions->isEmpty()) {
            return null;
        }

        $earliestStart = $subscriptions->first()->starts_at;
        $latestEnd = $subscriptions->max('ends_at');

        return [
            'starts_at' => $earliestStart,
            'ends_at' => $latestEnd,
            'total_subscriptions' => $subscriptions->count(),
        ];
    }

    /**
     * Get complete subscription info for user (single efficient function)
     * Returns all data needed for display in one query
     */
    public static function getCompleteSubscriptionInfo($userId): array
    {
        // Get all user subscriptions with payment info
        $subscriptions = static::forUser($userId)
            ->with('subscriptionPlan')
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->where(function($q) {
                $q->whereNull('cancelled_at')
                  ->orWhere('cancelled_at', '>', now());
            })
            ->orderBy('starts_at', 'asc')
            ->get();

        if ($subscriptions->isEmpty()) {
            return [
                'has_subscription' => false,
                'overall_status' => 'none',
                'display_subscription' => null,
                'subscription_period' => null,
                'days_remaining' => 0,
                'total_subscriptions' => 0,
                'is_expiring_soon' => false,
                'is_expired' => false,
            ];
        }

        // Calculate period info
        $earliestStart = $subscriptions->first()->starts_at;
        $latestEnd = $subscriptions->max('ends_at');
        $totalSubscriptions = $subscriptions->count();

        // Calculate days remaining
        $daysRemaining = $latestEnd->isFuture() ? (int) now()->diffInDays($latestEnd, false) : 0;

        // Determine overall status
        $now = now();
        $activeSubscription = $subscriptions->first(function($sub) use ($now) {
            return $sub->starts_at <= $now && $sub->ends_at > $now;
        });

        if ($activeSubscription) {
            $overallStatus = 'active';
            $displaySubscription = $activeSubscription;
        } else {
            $upcomingSubscription = $subscriptions->first(function($sub) use ($now) {
                return $sub->starts_at > $now;
            });
            
            if ($upcomingSubscription) {
                $overallStatus = 'upcoming';
                $displaySubscription = $upcomingSubscription;
            } else {
                $overallStatus = 'expired';
                $displaySubscription = $subscriptions->sortByDesc('ends_at')->first();
            }
        }

        // Calculate status flags
        $isExpiringSoon = $daysRemaining <= 30 && $daysRemaining > 0;
        $isExpired = $daysRemaining === 0;

        return [
            'has_subscription' => true,
            'overall_status' => $overallStatus,
            'display_subscription' => $displaySubscription,
            'subscription_period' => [
                'starts_at' => $earliestStart,
                'ends_at' => $latestEnd,
                'total_subscriptions' => $totalSubscriptions,
            ],
            'days_remaining' => $daysRemaining,
            'total_subscriptions' => $totalSubscriptions,
            'is_expiring_soon' => $isExpiringSoon,
            'is_expired' => $isExpired,
        ];
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
            case 'upcoming':
                return 'primary';
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
        ]);
        
        return true;
    }

    /**
     * Activate the subscription (called when payment is completed)
     */
    public function activate(): bool
    {
        $this->update([
            'activated_at' => now(),
        ]);
        
        return true;
    }

    /**
     * Auto-update status is now handled by the accessor
     * This method is kept for backward compatibility but does nothing
     */
    public function updateStatus(): bool
    {
        // Status is now calculated dynamically via accessor
        // No database update needed
        return true;
    }
}