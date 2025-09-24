<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'onboarding_completed',
        'studio_name',
        'phone',
        'saas_plan_id',
        'billing_cycle',
        'trial_ends_at',
        'subscription_ends_at',
        'is_trial',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'onboarding_completed' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'is_trial' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the SaaS plan for this user
     */
    public function saasPlans()
    {
        return $this->belongsTo(SaasPlans::class, 'saas_plan_id');
    }

    /**
     * Check if user is on trial
     */
    public function isOnTrial()
    {
        return $this->is_trial && $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if user's subscription is active
     */
    public function hasActiveSubscription()
    {
        return $this->is_active && (
            $this->isOnTrial() || 
            ($this->subscription_ends_at && $this->subscription_ends_at->isFuture())
        );
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}
