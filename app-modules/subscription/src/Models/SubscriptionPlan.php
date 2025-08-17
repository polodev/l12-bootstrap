<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class SubscriptionPlan extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'plan_title',
        'price',
        'duration_months',
        'currency',
        'is_active',
        'features',
        'sort_order',
    ];

    protected $translatable = [
        'plan_title',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'plan_title' => 'array',
        'features' => 'array',
        'duration_months' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get user subscriptions for this plan
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get active user subscriptions for this plan
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->userSubscriptions()->where('status', 'active');
    }

    /**
     * Scope for active plans only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('duration_months');
    }

    /**
     * Get formatted price with currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0) . ' ' . $this->currency;
    }

    /**
     * Get price per month for comparison
     */
    public function getPricePerMonthAttribute(): float
    {
        return $this->price / $this->duration_months;
    }

    /**
     * Get savings compared to monthly plan
     */
    public function getSavingsAttribute(): ?float
    {
        $monthlyPlan = static::where('duration_months', 1)->first();
        if (!$monthlyPlan || $this->duration_months <= 1) {
            return null;
        }
        
        $regularPrice = $monthlyPlan->price * $this->duration_months;
        return $regularPrice - $this->price;
    }

    /**
     * Get savings percentage
     */
    public function getSavingsPercentageAttribute(): ?int
    {
        $savings = $this->savings;
        if (!$savings) {
            return null;
        }
        
        $monthlyPlan = static::where('duration_months', 1)->first();
        $regularPrice = $monthlyPlan->price * $this->duration_months;
        
        return round(($savings / $regularPrice) * 100);
    }

    /**
     * Get duration in human readable format
     */
    public function getDurationTextAttribute(): string
    {
        if ($this->duration_months == 1) {
            return '1 Month';
        } elseif ($this->duration_months == 3) {
            return '3 Months';
        } elseif ($this->duration_months == 6) {
            return '6 Months';
        } elseif ($this->duration_months == 12) {
            return '1 Year';
        }
        
        return $this->duration_months . ' Months';
    }
}