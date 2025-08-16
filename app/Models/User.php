<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Modules\UserData\Models\UserAddress;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'mobile_verified_at',
        'country',
        'country_code',
        'mobile',
        'password',
        'email_login_code',
        'email_login_code_expires_at',
        'google_id',
        'facebook_id',
        'avatar',
        'password_set',
        'role',
        'default_address_id',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'email_login_code_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'password_set' => 'boolean',
        ];
    }
    public function getFullMobileAttribute()
    {
        return $this->country_code . $this->mobile;
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasAnyRole(array|string $roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }
        return in_array($this->role, $roles);
    }

    /**
     * Check if user has all specified roles (only true if exactly one role and user has it)
     */
    public function hasAllRoles(array $roles): bool
    {
        return count($roles) === 1 && $this->hasRole($roles[0]);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user has verified their mobile number
     */
    public function hasVerifiedMobile(): bool
    {
        return !is_null($this->mobile_verified_at);
    }

    /**
     * Get all addresses for the user
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get the user's default address
     */
    public function defaultAddress(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'default_address_id');
    }

    /**
     * Get the activity log options for this model
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'role', 'mobile', 'email_verified_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}")
            ->useLogName('user');
    }

    public function shouldLogEvent(string $eventName): bool
    {
        return $eventName === 'updated';
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Check if user has a password set
     */
    public function hasPassword(): bool
    {
        return $this->password_set && !empty($this->password);
    }

    /**
     * Check if user can login with social providers
     */
    public function hasSocialLogins(): bool
    {
        return !empty($this->google_id) || !empty($this->facebook_id);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    /**
     * Get the user's avatar URL with fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        // Check for uploaded avatar first
        $avatarMedia = $this->getFirstMedia('avatar');
        if ($avatarMedia) {
            return $avatarMedia->getUrl();
        }
        
        // Check for social login avatar
        if ($this->avatar) {
            return $this->avatar;
        }
        
        // Fallback to Gravatar
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
    }
}
