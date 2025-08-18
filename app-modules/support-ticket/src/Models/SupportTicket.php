<?php

namespace Modules\SupportTicket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupportTicket extends Model
{
    // use LogsActivity; // Temporarily disabled for testing

    protected $fillable = [
        'user_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'category',
        'closed_at',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user assigned to the ticket.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all messages for this ticket.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(SupportTicketMessage::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get public replies (customer-visible messages).
     */
    public function replies(): HasMany
    {
        return $this->messages()->where('is_internal', false);
    }

    /**
     * Get public messages (alias for replies, used in customer views).
     */
    public function publicMessages(): HasMany
    {
        return $this->messages()->where('is_internal', false);
    }

    /**
     * Get internal notes (admin-only messages).
     */
    public function internalNotes(): HasMany
    {
        return $this->messages()->where('is_internal', true);
    }

    /**
     * Get the latest message for this ticket.
     */
    public function latestMessage(): BelongsTo
    {
        return $this->belongsTo(SupportTicketMessage::class, 'id', 'support_ticket_id')
                    ->latest('created_at')
                    ->limit(1);
    }

    /**
     * Scope for tickets with specific status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for tickets with specific priority.
     */
    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope for tickets with specific category.
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for open tickets (new, open, in_progress).
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['new', 'open', 'in_progress']);
    }

    /**
     * Scope for closed tickets (resolved, closed).
     */
    public function scopeClosed($query)
    {
        return $query->whereIn('status', ['resolved', 'closed']);
    }

    /**
     * Scope for tickets assigned to specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope for unassigned tickets.
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    /**
     * Scope for tickets by customer.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'new' => __('messages.ticket_status_new'),
            'open' => __('messages.ticket_status_open'),
            'in_progress' => __('messages.ticket_status_in_progress'),
            'resolved' => __('messages.ticket_status_resolved'),
            'closed' => __('messages.ticket_status_closed'),
        ];
    }

    /**
     * Get available priorities.
     */
    public static function getAvailablePriorities(): array
    {
        return [
            'low' => __('messages.ticket_priority_low'),
            'normal' => __('messages.ticket_priority_normal'),
            'high' => __('messages.ticket_priority_high'),
            'urgent' => __('messages.ticket_priority_urgent'),
        ];
    }

    /**
     * Get available categories.
     */
    public static function getAvailableCategories(): array
    {
        return [
            'general' => __('messages.ticket_category_general'),
            'technical' => __('messages.ticket_category_technical'),
            'billing' => __('messages.ticket_category_billing'),
            'feature_request' => __('messages.ticket_category_feature_request'),
            'bug_report' => __('messages.ticket_category_bug_report'),
            'account' => __('messages.ticket_category_account'),
        ];
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'open' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'closed' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        $name = self::getAvailableStatuses()[$this->status] ?? ucfirst($this->status);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get priority badge HTML.
     */
    public function getPriorityBadgeAttribute(): string
    {
        $colors = [
            'low' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
            'normal' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'high' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
        ];

        $color = $colors[$this->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        $name = self::getAvailablePriorities()[$this->priority] ?? ucfirst($this->priority);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get category badge HTML.
     */
    public function getCategoryBadgeAttribute(): string
    {
        if (!$this->category) {
            return '<span class="text-gray-500 dark:text-gray-400">Not specified</span>';
        }

        $colors = [
            'general' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'technical' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'billing' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'feature_request' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'bug_report' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'account' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        ];

        $color = $colors[$this->category] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        $name = self::getAvailableCategories()[$this->category] ?? ucfirst(str_replace('_', ' ', $this->category));

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get last answered badge HTML.
     */
    public function getLastAnsweredBadgeAttribute(): string
    {
        return $this->getLastAnsweredBadge('customer');
    }

    /**
     * Get last answered badge for specific context.
     */
    public function getLastAnsweredBadge(string $context = 'customer'): string
    {
        $latestMessage = $this->messages()
            ->where('is_internal', false)
            ->with('author')
            ->latest('created_at')
            ->first();

        if (!$latestMessage) {
            $text = $context === 'admin' ? 'No conversation yet' : 'No messages yet';
            return sprintf(
                '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">%s</span>',
                $text
            );
        }

        $isFromCustomer = $latestMessage->isFromCustomer();
        
        // Determine status text based on context
        if ($context === 'admin') {
            $status = $isFromCustomer ? 'Customer asked' : 'Customer Care responded';
            $colorClass = $isFromCustomer 
                ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200'  // Customer asked - needs attention
                : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';     // We responded - good
        } else {
            $status = $isFromCustomer ? 'You asked' : 'Customer Care responded';
            $colorClass = $isFromCustomer 
                ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'         // You asked - waiting
                : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';    // They responded - good
        }

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $colorClass,
            $status
        );
    }

    /**
     * Get truncated description.
     */
    public function getTruncatedDescriptionAttribute(): string
    {
        return \Str::limit($this->description, 100);
    }

    /**
     * Check if ticket is open.
     */
    public function isOpen(): bool
    {
        return in_array($this->status, ['new', 'open', 'in_progress']);
    }

    /**
     * Check if ticket is closed.
     */
    public function isClosed(): bool
    {
        return in_array($this->status, ['resolved', 'closed']);
    }

    /**
     * Mark ticket as closed.
     */
    public function markAsClosed(): bool
    {
        return $this->update([
            'status' => 'closed',
            'closed_at' => now()
        ]);
    }

    /**
     * Mark ticket as resolved.
     */
    public function markAsResolved(): bool
    {
        return $this->update([
            'status' => 'resolved',
            'closed_at' => now()
        ]);
    }

    /**
     * Assign ticket to user.
     */
    public function assignTo(User $user): bool
    {
        return $this->update(['assigned_to' => $user->id]);
    }

    /**
     * Unassign ticket.
     */
    public function unassign(): bool
    {
        return $this->update(['assigned_to' => null]);
    }

    /**
     * Get message count.
     */
    public function getMessageCountAttribute(): int
    {
        return $this->messages()->count();
    }

    /**
     * Get reply count (public messages only).
     */
    public function getReplyCountAttribute(): int
    {
        return $this->replies()->count();
    }

    /**
     * Configure activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'status',
                'priority',
                'category',
                'assigned_to',
                'closed_at'
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
        return in_array($eventName, ['created', 'updated', 'deleted']);
    }

    /**
     * Get description for activity log.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return match($eventName) {
            'created' => "Support ticket #{$this->id} created: {$this->title}",
            'updated' => "Support ticket #{$this->id} updated: {$this->title}",
            'deleted' => "Support ticket #{$this->id} deleted: {$this->title}",
            default => "Support ticket {$eventName}: {$this->title}"
        };
    }

    /**
     * Get the last answered status for listing display.
     * Returns different text based on viewer context (admin vs customer).
     * 
     * @param string $context 'admin' or 'customer'
     * @return string
     */
    public function getLastAnsweredStatus(string $context = 'admin'): string
    {
        // Get the latest public message (exclude internal notes)
        $latestMessage = $this->messages()
            ->where('is_internal', false)
            ->with('author')
            ->latest('created_at')
            ->first();

        if (!$latestMessage) {
            return $context === 'admin' ? 'No conversation yet' : 'No messages yet';
        }

        $isFromCustomer = $latestMessage->isFromCustomer();

        if ($context === 'admin') {
            return $isFromCustomer ? 'Customer asked' : 'Customer Care responded';
        } else { // customer context
            return $isFromCustomer ? 'You asked' : 'Customer Care responded';
        }
    }

    /**
     * Get the last answered status with timestamp.
     * 
     * @param string $context 'admin' or 'customer'
     * @return array
     */
    public function getLastAnsweredDetails(string $context = 'admin'): array
    {
        $latestMessage = $this->messages()
            ->where('is_internal', false)
            ->with('author')
            ->latest('created_at')
            ->first();

        if (!$latestMessage) {
            return [
                'status' => $context === 'admin' ? 'No conversation yet' : 'No messages yet',
                'timestamp' => null,
                'formatted_time' => 'Never'
            ];
        }

        $isFromCustomer = $latestMessage->isFromCustomer();
        
        $status = $context === 'admin' 
            ? ($isFromCustomer ? 'Customer asked' : 'Customer Care responded')
            : ($isFromCustomer ? 'You asked' : 'Customer Care responded');

        return [
            'status' => $status,
            'timestamp' => $latestMessage->created_at,
            'formatted_time' => $latestMessage->created_at->diffForHumans()
        ];
    }
}