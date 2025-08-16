<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Contact extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'organization',
        'designation',
        'email',
        'mobile',
        'page',
        'topic',
        'department',
        'message',
        'has_reply',
        'remarks',
        'user_id',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'has_reply' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns this contact.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for contacts with replies.
     */
    public function scopeWithReply($query)
    {
        return $query->where('has_reply', true);
    }

    /**
     * Scope for contacts without replies.
     */
    public function scopeWithoutReply($query)
    {
        return $query->where('has_reply', false);
    }

    /**
     * Scope for contacts by department.
     */
    public function scopeByDepartment($query, string $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope for contacts by email.
     */
    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', $email);
    }

    /**
     * Get available departments.
     */
    public static function getAvailableDepartments(): array
    {
        return [
            'general' => __('messages.department_general'),
            'sales' => __('messages.department_sales'),
            'support' => __('messages.department_support'),
            'technical' => __('messages.department_technical'),
            'partnership' => __('messages.department_partnership')
        ];
    }

    /**
     * Get reply status badge.
     */
    public function getReplyStatusBadgeAttribute(): string
    {
        if ($this->has_reply) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Replied</span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>';
    }

    /**
     * Get department badge.
     */
    public function getDepartmentBadgeAttribute(): string
    {
        if (!$this->department) {
            return '<span class="text-gray-500 dark:text-gray-400">Not specified</span>';
        }

        $colors = [
            'general' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'sales' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'support' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'technical' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'billing' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'feedback' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
            'partnership' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'media' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            'careers' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200',
        ];

        $color = $colors[$this->department] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
        $name = self::getAvailableDepartments()[$this->department] ?? ucfirst($this->department);

        return sprintf(
            '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium %s">%s</span>',
            $color,
            $name
        );
    }

    /**
     * Get truncated message.
     */
    public function getTruncatedMessageAttribute(): string
    {
        return \Str::limit($this->message, 100);
    }

    /**
     * Check if contact has been replied to.
     */
    public function isReplied(): bool
    {
        return $this->has_reply;
    }

    /**
     * Mark contact as replied.
     */
    public function markAsReplied(): bool
    {
        return $this->update(['has_reply' => true]);
    }

    /**
     * Mark contact as pending.
     */
    public function markAsPending(): bool
    {
        return $this->update(['has_reply' => false]);
    }

    /**
     * Configure activity logging.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'organization',
                'department',
                'topic',
                'has_reply',
                'remarks'
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
            'created' => "Contact inquiry created from {$this->name} ({$this->email})",
            'updated' => "Contact #{$this->id} updated from {$this->name}",
            'deleted' => "Contact #{$this->id} deleted from {$this->name}",
            default => "Contact {$eventName} from {$this->name}"
        };
    }
}