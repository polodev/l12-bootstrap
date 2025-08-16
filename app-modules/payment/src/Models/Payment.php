<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Payment extends Model implements HasMedia
{
    use LogsActivity, InteractsWithMedia;
    protected $fillable = [
        'payment_type',
        'created_by',
        'amount',
        'email_address',
        'store_name',
        'status',
        'payment_method',
        'name',
        'mobile',
        'purpose',
        'description',
        'form_data',
        'ip_address',
        'user_agent',
        'transaction_id',
        'gateway_payment_id',
        'gateway_response',
        'gateway_reference',
        'payment_date',
        'processed_at',
        'failed_at',
        'refunded_at',
        'bank_name',
        'notes',
        'admin_notes',
        'receipt_number',
        'payment_details',
        'processed_by'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'form_data' => 'array',
        'gateway_response' => 'array',
        'payment_details' => 'array',
        'payment_date' => 'datetime',
        'processed_at' => 'datetime',
        'failed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];



    /**
     * Scope for payments by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }


    /**
     * Scope for custom payments.
     */
    public function scopeForCustomPayments($query)
    {
        return $query->where('payment_type', 'custom_payment');
    }

    /**
     * Get available payment methods.
     */
    public static function getAvailablePaymentMethods(): array
    {
        return [
            'sslcommerz' => 'SSLCommerz',
            'manual_payment' => 'Manual Payment (Bank transfers, Deposit, MFS transfer, Cash)',
            // 'bkash' => 'bKash',
            // 'nagad' => 'Nagad',
            // 'city_bank' => 'City Bank Gateway',
            // 'brac_bank' => 'BRAC Bank Gateway',
            // 'bank_transfer' => 'Bank Transfer',
            // 'bank_deposit' => 'Bank Deposit',
            // 'cash' => 'Cash Payment',
        ];
    }

    /**
     * Get available payment statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded'
        ];
    }

    /**
     * Get payment status badge.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200',
            'refunded' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get payment method badge.
     */
    public function getPaymentMethodBadgeAttribute(): string
    {
        if (!$this->payment_method) {
            return '<span class="text-gray-500 dark:text-gray-400">Not specified</span>';
        }

        $colors = [
            'sslcommerz' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'bkash' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
            'nagad' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'city_bank' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'brac_bank' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        ];

        $color = $colors[$this->payment_method] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailablePaymentMethods()[$this->payment_method] ?? ucfirst($this->payment_method);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '৳' . number_format($this->amount, 2);
    }

    /**
     * Check if payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if payment is refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Get email address for payment - with fallback hierarchy
     */
    public function getEmailForPaymentAttribute(): string
    {
        // 1. Use email_address column if set
        if (!empty($this->email_address)) {
            return $this->email_address;
        }

        // 2. Try to get email from custom payment
        if ($this->customPayment && !empty($this->customPayment->email)) {
            return $this->customPayment->email;
        }


        // 4. Fall back to config fallback email
        return config('sslcommerz.fallback_email', 'polodev10@gmail.com');
    }

    /**
     * Configure activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'amount',
                'status', 
                'payment_method',
                'transaction_id',
                'gateway_payment_id',
                'payment_date',
                'bank_name',
                'notes',
                'receipt_number'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at']);
    }

    /**
     * Determine if the given event should be logged.
     */
    public function shouldLogEvent(string $eventName): bool
    {
        return in_array($eventName, ['updated', 'deleted']);
    }

    /**
     * Get description for activity log.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        $relatedInfo = '';
        
        if ($this->payment_type === 'custom_payment') {
            $relatedInfo = " for Custom Payment: {$this->name}";
        }

        return match($eventName) {
            'created' => "Payment of {$this->formatted_amount} created{$relatedInfo}",
            'updated' => "Payment #{$this->id} updated{$relatedInfo}",
            'deleted' => "Payment #{$this->id} deleted{$relatedInfo}",
            default => "Payment {$eventName}{$relatedInfo}"
        };
    }

    /**
     * Define media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('payment_attachment')->singleFile();
    }
}