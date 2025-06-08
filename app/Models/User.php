<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasAppRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
  use App\Mail\StandardEmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasAppRoles,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
        'first_name',
        'last_name',
        'profile_url',
        'email',
        'email_verified_at',
        'password',
        'verification_code',
        'referral_code',
        'referral_source',
        'referral_medium',
        'referral_reward_preference',
        'preferred_currency',
        'status',
        'avatar',

        // Login tracking
        'last_login_at',
        'last_login_ip',
        'password_changed_at',

        // Profile info
        'avatar_url',
        'sex',
        'date_of_birth',
        'phone',

        // Location & language
        'country',
        'state',
        'city',
        'postal_code',
        'address',
        'timezone',
        'language',

        // Optional personal fields
        'bio',
        'website',

        // OAuth / Social login
        'google_id',
        'facebook_id',
        'twitter_id',

        // 2FA
        'two_factor_enabled',
        'two_factor_secret',

        // Marketing
        'newsletter_opt_in',
        'marketing_opt_in',

        // Audit
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'verification_code_expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays (like password fields).
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'verification_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_login_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'date_of_birth' => 'date',
        'two_factor_enabled' => 'boolean',
        'newsletter_opt_in' => 'boolean',
        'marketing_opt_in' => 'boolean',
        'notification_preferences' => 'array',
        'verification_code_expires_at'=>'datetime',

    ];
  


    /**
     * Get the full name of the user (helper accessor).
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function apps()
    {
        return $this->hasMany(App::class);
    }
     // Referrals made by this user (scoped by app if needed)
    public function referralsMade()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class)
                    ->withPivot('used_at')
                    ->withTimestamps();
    }
        public function referralLinks()
        {
            return $this->hasMany(ReferralLink::class);
        }
        // User.php
        public function referrals()
        {
            return $this->hasMany(Referral::class, 'referrer_id');
        }

        public function referralCashPayouts()
        {
            return $this->hasMany(CashPayout::class, 'user_id');
        }




    // Users referred by this user
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
        public function readNotifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }
  

        public function sendPasswordResetNotification($token)
        {
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $this->getEmailForPasswordReset(),
            ], false));

            $title = 'Reset Your Password';
            $mailBody = "We received a request to reset your password. Click the button below to choose a new password.";
            $ctaLabel = 'Reset Password';
            $tip = "If you didn’t request a password reset, no action is needed.";
            $logoPath = public_path('images/v8.png');

            Mail::to($this->email)->send(
                new StandardEmail($title, $mailBody, $resetUrl, $ctaLabel, $tip, $logoPath)
            );
        }


    public function hasRead(Notification $notification)
    {
        return $this->readNotifications()->where('notification_id', $notification->id)->whereNotNull('read_at')->exists();
    }


    /**
     * Relationships to admin creators/editors/approvers.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }
    public function permissions()
{
    return $this->belongsToMany(Permission::class, 'permission_user')->withTimestamps();
}


    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function assignedSubtasks(): HasMany
    {
        return $this->hasMany(Subtask::class, 'assigned_to');
    }

    public function teamMemberships(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProjectManager(): bool
    {
        return $this->role === 'project_manager';
    }
    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(BlogReaction::class);
    }

    public function hasReacted(BlogPost $post, string $type): bool
    {
        return $this->reactions()
            ->where('post_id', $post->id)
            ->where('type', $type)
            ->exists();
    }
}
