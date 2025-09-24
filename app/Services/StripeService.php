<?php

namespace App\Services;

use App\Models\User;
use App\Models\SaasPlans;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;
use Stripe\Price;
use Stripe\Product;
use Illuminate\Support\Facades\Log;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = app('stripe');
        Stripe::setApiKey(config('stripe.secret'));
    }

    /**
     * Create or update Stripe products and prices for SaaS plans
     */
    public function syncPlansWithStripe()
    {
        $plans = SaasPlans::all();
        
        foreach ($plans as $plan) {
            $this->createOrUpdateStripeProduct($plan);
        }
    }

    /**
     * Create or update a Stripe product for a SaaS plan
     */
    public function createOrUpdateStripeProduct(SaasPlans $plan)
    {
        try {
            // Create or update product
            $productData = [
                'name' => $plan->name,
                'description' => $plan->description,
                'metadata' => [
                    'saas_plan_id' => $plan->id,
                    'max_clients' => $plan->max_clients,
                    'max_professionals' => $plan->max_professionals,
                    'max_rooms' => $plan->max_rooms,
                ],
            ];

            if ($plan->stripe_product_id) {
                // Update existing product
                $product = $this->stripe->products->update($plan->stripe_product_id, $productData);
            } else {
                // Create new product
                $product = $this->stripe->products->create($productData);
                $plan->update(['stripe_product_id' => $product->id]);
            }

            // Create prices for monthly and yearly billing
            $this->createPricesForPlan($plan, $product->id);

            return $product;
        } catch (\Exception $e) {
            Log::error('Error syncing plan with Stripe: ' . $e->getMessage(), [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
            ]);
            throw $e;
        }
    }

    /**
     * Create Stripe prices for a plan
     */
    protected function createPricesForPlan(SaasPlans $plan, string $productId)
    {
        // Monthly price
        if (!$plan->stripe_monthly_price_id) {
            $monthlyPrice = $this->stripe->prices->create([
                'product' => $productId,
                'unit_amount' => $plan->monthly_price * 100, // Convert to cents
                'currency' => 'brl',
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => 1,
                ],
                'metadata' => [
                    'saas_plan_id' => $plan->id,
                    'billing_cycle' => 'monthly',
                ],
            ]);
            $plan->update(['stripe_monthly_price_id' => $monthlyPrice->id]);
        }

        // Yearly price
        if (!$plan->stripe_yearly_price_id) {
            $yearlyPrice = $this->stripe->prices->create([
                'product' => $productId,
                'unit_amount' => $plan->yearly_price * 100, // Convert to cents
                'currency' => 'brl',
                'recurring' => [
                    'interval' => 'year',
                    'interval_count' => 1,
                ],
                'metadata' => [
                    'saas_plan_id' => $plan->id,
                    'billing_cycle' => 'yearly',
                ],
            ]);
            $plan->update(['stripe_yearly_price_id' => $yearlyPrice->id]);
        }
    }

    /**
     * Create a checkout session for subscription
     */
    public function createCheckoutSession(User $user, SaasPlans $plan, string $billingCycle = 'monthly')
    {
        $customerId = $user->getStripeCustomerId();
        
        $priceId = $billingCycle === 'yearly' ? $plan->stripe_yearly_price_id : $plan->stripe_monthly_price_id;
        
        if (!$priceId) {
            throw new \Exception("Price ID not found for plan {$plan->name} with {$billingCycle} billing");
        }

        $sessionData = [
            'customer' => $customerId,
            'payment_method_types' => ['card', 'boleto'],
            'line_items' => [
                [
                    'price' => $priceId,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'subscription',
            'success_url' => route('billing.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('billing.cancel'),
            'subscription_data' => [
                'trial_period_days' => config('stripe.subscriptions.trial_days', 14),
                'metadata' => [
                    'user_id' => $user->id,
                    'saas_plan_id' => $plan->id,
                    'billing_cycle' => $billingCycle,
                ],
            ],
            'metadata' => [
                'user_id' => $user->id,
                'saas_plan_id' => $plan->id,
                'billing_cycle' => $billingCycle,
            ],
            'automatic_tax' => [
                'enabled' => true,
            ],
            'tax_id_collection' => [
                'enabled' => true,
            ],
            'locale' => 'pt-BR',
        ];

        // Add PIX payment method for Brazilian customers
        if ($user->address_country === 'BR') {
            $sessionData['payment_method_types'][] = 'pix';
        }

        return $this->stripe->checkout->sessions->create($sessionData);
    }

    /**
     * Create a billing portal session
     */
    public function createBillingPortalSession(User $user, string $returnUrl = null)
    {
        $customerId = $user->getStripeCustomerId();
        
        return $this->stripe->billingPortal->sessions->create([
            'customer' => $customerId,
            'return_url' => $returnUrl ?: route('billing.index'),
        ]);
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(User $user, bool $atPeriodEnd = true)
    {
        if (!$user->stripe_subscription_id) {
            throw new \Exception('User does not have an active Stripe subscription');
        }

        $subscription = $this->stripe->subscriptions->update($user->stripe_subscription_id, [
            'cancel_at_period_end' => $atPeriodEnd,
            'metadata' => [
                'canceled_by_user' => 'true',
                'canceled_at' => now()->toISOString(),
            ],
        ]);

        $user->update([
            'stripe_subscription_cancel_at_period_end' => $atPeriodEnd,
            'stripe_subscription_canceled_at' => $atPeriodEnd ? null : now(),
        ]);

        return $subscription;
    }

    /**
     * Resume a canceled subscription
     */
    public function resumeSubscription(User $user)
    {
        if (!$user->stripe_subscription_id) {
            throw new \Exception('User does not have a Stripe subscription');
        }

        $subscription = $this->stripe->subscriptions->update($user->stripe_subscription_id, [
            'cancel_at_period_end' => false,
        ]);

        $user->update([
            'stripe_subscription_cancel_at_period_end' => false,
            'stripe_subscription_canceled_at' => null,
        ]);

        return $subscription;
    }

    /**
     * Change subscription plan
     */
    public function changeSubscriptionPlan(User $user, SaasPlans $newPlan, string $billingCycle = 'monthly')
    {
        if (!$user->stripe_subscription_id) {
            throw new \Exception('User does not have an active Stripe subscription');
        }

        $newPriceId = $billingCycle === 'yearly' ? $newPlan->stripe_yearly_price_id : $newPlan->stripe_monthly_price_id;
        
        if (!$newPriceId) {
            throw new \Exception("Price ID not found for plan {$newPlan->name} with {$billingCycle} billing");
        }

        // Get current subscription
        $subscription = $this->stripe->subscriptions->retrieve($user->stripe_subscription_id);
        
        // Update subscription with new price
        $updatedSubscription = $this->stripe->subscriptions->update($user->stripe_subscription_id, [
            'items' => [
                [
                    'id' => $subscription->items->data[0]->id,
                    'price' => $newPriceId,
                ],
            ],
            'proration_behavior' => 'create_prorations',
            'metadata' => [
                'previous_plan_id' => $user->saas_plan_id,
                'new_plan_id' => $newPlan->id,
                'changed_at' => now()->toISOString(),
            ],
        ]);

        // Update user's plan
        $user->update([
            'saas_plan_id' => $newPlan->id,
            'billing_cycle' => $billingCycle,
        ]);

        return $updatedSubscription;
    }

    /**
     * Get subscription usage and billing information
     */
    public function getSubscriptionInfo(User $user)
    {
        if (!$user->stripe_subscription_id) {
            return null;
        }

        try {
            $subscription = $this->stripe->subscriptions->retrieve($user->stripe_subscription_id, [
                'expand' => ['latest_invoice', 'customer', 'default_payment_method'],
            ]);

            return [
                'subscription' => $subscription,
                'next_payment_date' => $subscription->current_period_end,
                'amount' => $subscription->items->data[0]->price->unit_amount / 100,
                'currency' => strtoupper($subscription->items->data[0]->price->currency),
                'interval' => $subscription->items->data[0]->price->recurring->interval,
                'status' => $subscription->status,
                'cancel_at_period_end' => $subscription->cancel_at_period_end,
                'trial_end' => $subscription->trial_end,
            ];
        } catch (\Exception $e) {
            Log::error('Error retrieving subscription info: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'subscription_id' => $user->stripe_subscription_id,
            ]);
            return null;
        }
    }

    /**
     * Handle successful checkout session
     */
    public function handleSuccessfulCheckout(string $sessionId)
    {
        try {
            $session = $this->stripe->checkout->sessions->retrieve($sessionId, [
                'expand' => ['subscription', 'customer'],
            ]);

            $userId = $session->metadata->user_id;
            $user = User::find($userId);

            if (!$user) {
                throw new \Exception("User not found: {$userId}");
            }

            // Update user with subscription information
            $subscription = $session->subscription;
            $user->update([
                'stripe_subscription_id' => $subscription->id,
                'stripe_subscription_status' => $subscription->status,
                'stripe_subscription_current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start),
                'stripe_subscription_current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
                'stripe_subscription_cancel_at_period_end' => $subscription->cancel_at_period_end,
                'is_trial' => $subscription->status === 'trialing',
                'is_active' => true,
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Error handling successful checkout: ' . $e->getMessage(), [
                'session_id' => $sessionId,
            ]);
            throw $e;
        }
    }
}
