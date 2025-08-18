<?php

namespace Modules\SupportTicket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupportTicketMessage extends Model
{
    // use LogsActivity; // Temporarily disabled for testing

    protected $fillable = [
        'support_ticket_id',
        'user_id',
        'message',
        'is_internal',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the support ticket this message belongs to.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }

    /**
     * Get the user who wrote this message.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for public replies (customer-visible).
     */
    public function scopePublicReplies($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Scope for internal notes (admin-only).
     */
    public function scopeInternalNotes($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope for messages by specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for messages on specific ticket.
     */
    public function scopeForTicket($query, $ticketId)
    {
        return $query->where('support_ticket_id', $ticketId);
    }

    /**
     * Check if message is from customer.
     */
    public function isFromCustomer(): bool
    {
        return $this->author && $this->author->id === $this->ticket->user_id;
    }

    /**
     * Check if message is from staff.
     */
    public function isFromStaff(): bool
    {
        return !$this->isFromCustomer();
    }

    /**
     * Check if message is internal note.
     */
    public function isInternalNote(): bool
    {
        return $this->is_internal;
    }

    /**
     * Check if message is public reply.
     */
    public function isPublicReply(): bool
    {
        return !$this->is_internal;
    }

    /**
     * Get formatted message with line breaks.
     */
    public function getFormattedMessageAttribute(): string
    {
        return nl2br(e($this->message));
    }

    /**
     * Get truncated message.
     */
    public function getTruncatedMessageAttribute(): string
    {
        return \Str::limit($this->message, 100);
    }

    /**
     * Get author name.
     */
    public function getAuthorNameAttribute(): string
    {
        return $this->author ? $this->author->name : 'Unknown';
    }

    /**
     * Get author role badge.
     */
    public function getAuthorBadgeAttribute(): string
    {
        if ($this->isFromCustomer()) {
            return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Customer</span>';
        }

        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Staff</span>';
    }

    /**
     * Get message type badge.
     */
    public function getTypeBadgeAttribute(): string
    {
        if ($this->is_internal) {
            return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Internal Note</span>';
        }

        return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Public Reply</span>';
    }

    /**
     * Configure activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'support_ticket_id',
                'user_id',
                'is_internal'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->dontLogIfAttributesChangedOnly(['created_at', 'updated_at'])
            ->setDescriptionForEvent(function(string $eventName): string {
                $ticketId = $this->support_ticket_id;
                $messageType = $this->is_internal ? 'internal note' : 'reply';
                $authorName = $this->author ? $this->author->name : 'Unknown';
                
                return match($eventName) {
                    'created' => "New {$messageType} added to ticket #{$ticketId} by {$authorName}",
                    'updated' => "Message updated on ticket #{$ticketId} by {$authorName}",
                    'deleted' => "Message deleted from ticket #{$ticketId}",
                    default => "Message {$eventName} on ticket #{$ticketId}"
                };
            });
    }

    /**
     * Determine if the given event should be logged.
     */
    public function shouldLogEvent(string $eventName): bool
    {
        return in_array($eventName, ['created', 'updated', 'deleted']);
    }

    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Update ticket's updated_at timestamp when message is created
        static::created(function ($message) {
            $message->ticket->touch();
            
            // Auto-update ticket status when customer replies
            if ($message->isFromCustomer() && $message->ticket->status === 'resolved') {
                $message->ticket->update(['status' => 'open']);
            }
        });

        // Update ticket's updated_at timestamp when message is updated
        static::updated(function ($message) {
            $message->ticket->touch();
        });
    }
}