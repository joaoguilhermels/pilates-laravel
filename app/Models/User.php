<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\VerifyEmailNotification;
use App\Traits\HasPlanFeatures;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPlanFeatures;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'onboarding_completed',
        'onboarding_skipped',
        'onboarding_completed_at',
        'studio_name',
        'phone',
        'saas_plan_id',
        'billing_cycle',
        'trial_ends_at',
        'subscription_ends_at',
        'is_trial',
        'is_active',
        'stripe_customer_id',
        'stripe_subscription_id',
        'stripe_payment_method_id',
        'stripe_subscription_status',
        'stripe_subscription_current_period_start',
        'stripe_subscription_current_period_end',
        'stripe_subscription_cancel_at_period_end',
        'stripe_subscription_canceled_at',
        'stripe_metadata',
        'tax_id',
        'tax_id_type',
        'company_name',
        'address_line1',
        'address_line2',
        'address_city',
        'address_state',
        'address_postal_code',
        'address_country',
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
        'onboarding_completed_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'is_trial' => 'boolean',
        'is_active' => 'boolean',
        'stripe_subscription_current_period_start' => 'datetime',
        'stripe_subscription_current_period_end' => 'datetime',
        'stripe_subscription_cancel_at_period_end' => 'boolean',
        'stripe_subscription_canceled_at' => 'datetime',
        'stripe_metadata' => 'array',
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
            ($this->subscription_ends_at && $this->subscription_ends_at->isFuture()) ||
            $this->hasActiveStripeSubscription()
        );
    }

    /**
     * Check if user has an active Stripe subscription
     */
    public function hasActiveStripeSubscription()
    {
        return in_array($this->stripe_subscription_status, ['active', 'trialing']);
    }

    /**
     * Check if user's Stripe subscription is past due
     */
    public function hasStripeSubscriptionPastDue()
    {
        return $this->stripe_subscription_status === 'past_due';
    }

    /**
     * Check if user's Stripe subscription is canceled
     */
    public function hasStripeSubscriptionCanceled()
    {
        return in_array($this->stripe_subscription_status, ['canceled', 'unpaid']);
    }

    /**
     * Get the user's Stripe customer ID, creating one if it doesn't exist
     */
    public function getStripeCustomerId()
    {
        if (!$this->stripe_customer_id) {
            $this->createStripeCustomer();
        }
        
        return $this->stripe_customer_id;
    }

    /**
     * Create a Stripe customer for this user
     */
    public function createStripeCustomer()
    {
        $stripe = app('stripe');
        
        $customer = $stripe->customers->create([
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'metadata' => [
                'user_id' => $this->id,
                'studio_name' => $this->studio_name,
                'plan_id' => $this->saas_plan_id,
            ],
            'address' => $this->getStripeAddress(),
            'tax_id_data' => $this->getStripeTaxIdData(),
        ]);

        $this->update(['stripe_customer_id' => $customer->id]);
        
        return $customer;
    }

    /**
     * Get address data for Stripe
     */
    public function getStripeAddress()
    {
        if (!$this->address_line1) {
            return null;
        }

        return [
            'line1' => $this->address_line1,
            'line2' => $this->address_line2,
            'city' => $this->address_city,
            'state' => $this->address_state,
            'postal_code' => $this->address_postal_code,
            'country' => $this->address_country ?? 'BR',
        ];
    }

    /**
     * Get tax ID data for Stripe (Brazilian CPF/CNPJ)
     */
    public function getStripeTaxIdData()
    {
        if (!$this->tax_id || !$this->tax_id_type) {
            return null;
        }

        $type = $this->tax_id_type === 'cpf' ? 'br_cpf' : 'br_cnpj';
        
        return [
            [
                'type' => $type,
                'value' => $this->tax_id,
            ]
        ];
    }

    /**
     * Get formatted tax ID for display
     */
    public function getFormattedTaxId()
    {
        if (!$this->tax_id) {
            return null;
        }

        if ($this->tax_id_type === 'cpf') {
            // Format CPF: 123.456.789-01
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->tax_id);
        } else {
            // Format CNPJ: 12.345.678/0001-90
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $this->tax_id);
        }
    }

    /**
     * Check if user needs to complete billing information
     */
    public function needsBillingInfo()
    {
        return !$this->tax_id || !$this->address_line1;
    }

    /**
     * Check if user is a studio owner
     */
    public function isStudioOwner()
    {
        return $this->hasRole('studio_owner') || 
               ($this->saasPlans && str_contains(strtolower($this->saasPlans->name), 'estúdio'));
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }
}
