<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe webhook events
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload in Stripe webhook', ['error' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Invalid signature in Stripe webhook', ['error' => $e->getMessage()]);
            return response('Invalid signature', 400);
        }

        Log::info('Stripe webhook received', [
            'type' => $event->type,
            'id' => $event->id,
        ]);

        // Handle the event
        switch ($event->type) {
            case 'customer.subscription.created':
                $this->handleSubscriptionCreated($event->data->object);
                break;

            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            case 'customer.subscription.trial_will_end':
                $this->handleTrialWillEnd($event->data->object);
                break;

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'invoice.upcoming':
                $this->handleUpcomingInvoice($event->data->object);
                break;

            case 'customer.created':
                $this->handleCustomerCreated($event->data->object);
                break;

            case 'customer.updated':
                $this->handleCustomerUpdated($event->data->object);
                break;

            case 'payment_method.attached':
                $this->handlePaymentMethodAttached($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Handle subscription created event
     */
    public function handleSubscriptionCreated($subscription)
    {
        $user = $this->findUserByCustomerId($subscription->customer);
        
        if (!$user) {
            Log::error('User not found for subscription created', ['customer_id' => $subscription->customer]);
            return;
        }

        $user->update([
            'stripe_subscription_id' => $subscription->id,
            'stripe_subscription_status' => $subscription->status,
            'stripe_subscription_current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start),
            'stripe_subscription_current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
            'stripe_subscription_cancel_at_period_end' => $subscription->cancel_at_period_end,
            'is_trial' => $subscription->status === 'trialing',
            'is_active' => true,
        ]);

        Log::info('Subscription created for user', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'status' => $subscription->status,
        ]);
    }

    /**
     * Handle subscription updated event
     */
    public function handleSubscriptionUpdated($subscription)
    {
        $user = $this->findUserByCustomerId($subscription->customer);
        
        if (!$user) {
            Log::error('User not found for subscription updated', ['customer_id' => $subscription->customer]);
            return;
        }

        $user->update([
            'stripe_subscription_status' => $subscription->status,
            'stripe_subscription_current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start),
            'stripe_subscription_current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end),
            'stripe_subscription_cancel_at_period_end' => $subscription->cancel_at_period_end,
            'stripe_subscription_canceled_at' => $subscription->canceled_at ? \Carbon\Carbon::createFromTimestamp($subscription->canceled_at) : null,
            'is_trial' => $subscription->status === 'trialing',
            'is_active' => in_array($subscription->status, ['active', 'trialing']),
        ]);

        Log::info('Subscription updated for user', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'status' => $subscription->status,
        ]);
    }

    /**
     * Handle subscription deleted event
     */
    public function handleSubscriptionDeleted($subscription)
    {
        $user = $this->findUserByCustomerId($subscription->customer);
        
        if (!$user) {
            Log::error('User not found for subscription deleted', ['customer_id' => $subscription->customer]);
            return;
        }

        $user->update([
            'stripe_subscription_status' => 'canceled',
            'stripe_subscription_canceled_at' => now(),
            'is_trial' => false,
            'is_active' => false,
        ]);

        Log::info('Subscription deleted for user', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ]);

        // TODO: Send cancellation email notification
    }

    /**
     * Handle trial will end event
     */
    public function handleTrialWillEnd($subscription)
    {
        $user = $this->findUserByCustomerId($subscription->customer);
        
        if (!$user) {
            Log::error('User not found for trial will end', ['customer_id' => $subscription->customer]);
            return;
        }

        Log::info('Trial will end for user', [
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'trial_end' => $subscription->trial_end,
        ]);

        // TODO: Send trial ending email notification
    }

    /**
     * Handle payment succeeded event
     */
    public function handlePaymentSucceeded($invoice)
    {
        $user = $this->findUserByCustomerId($invoice->customer);
        
        if (!$user) {
            Log::error('User not found for payment succeeded', ['customer_id' => $invoice->customer]);
            return;
        }

        // Update subscription status if needed
        if ($invoice->subscription) {
            $user->update([
                'stripe_subscription_status' => 'active',
                'is_active' => true,
            ]);
        }

        Log::info('Payment succeeded for user', [
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount_paid / 100,
            'currency' => strtoupper($invoice->currency),
        ]);

        // TODO: Send payment success email notification
    }

    /**
     * Handle payment failed event
     */
    public function handlePaymentFailed($invoice)
    {
        $user = $this->findUserByCustomerId($invoice->customer);
        
        if (!$user) {
            Log::error('User not found for payment failed', ['customer_id' => $invoice->customer]);
            return;
        }

        // Update subscription status
        if ($invoice->subscription) {
            $user->update([
                'stripe_subscription_status' => 'past_due',
            ]);
        }

        Log::warning('Payment failed for user', [
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount_due / 100,
            'currency' => strtoupper($invoice->currency),
            'attempt_count' => $invoice->attempt_count,
        ]);

        // TODO: Send payment failed email notification
    }

    /**
     * Handle upcoming invoice event
     */
    public function handleUpcomingInvoice($invoice)
    {
        $user = $this->findUserByCustomerId($invoice->customer);
        
        if (!$user) {
            Log::error('User not found for upcoming invoice', ['customer_id' => $invoice->customer]);
            return;
        }

        Log::info('Upcoming invoice for user', [
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount_due / 100,
            'currency' => strtoupper($invoice->currency),
            'period_start' => $invoice->period_start,
            'period_end' => $invoice->period_end,
        ]);

        // TODO: Send upcoming payment email notification
    }

    /**
     * Handle customer created event
     */
    public function handleCustomerCreated($customer)
    {
        Log::info('Customer created', [
            'customer_id' => $customer->id,
            'email' => $customer->email,
        ]);
    }

    /**
     * Handle customer updated event
     */
    public function handleCustomerUpdated($customer)
    {
        $user = $this->findUserByCustomerId($customer->id);
        
        if (!$user) {
            Log::info('Customer updated but no user found', ['customer_id' => $customer->id]);
            return;
        }

        Log::info('Customer updated for user', [
            'user_id' => $user->id,
            'customer_id' => $customer->id,
        ]);
    }

    /**
     * Handle payment method attached event
     */
    public function handlePaymentMethodAttached($paymentMethod)
    {
        $user = $this->findUserByCustomerId($paymentMethod->customer);
        
        if (!$user) {
            Log::error('User not found for payment method attached', ['customer_id' => $paymentMethod->customer]);
            return;
        }

        $user->update([
            'stripe_payment_method_id' => $paymentMethod->id,
        ]);

        Log::info('Payment method attached for user', [
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethod->id,
            'type' => $paymentMethod->type,
        ]);
    }

    /**
     * Find user by Stripe customer ID
     */
    protected function findUserByCustomerId($customerId)
    {
        return User::where('stripe_customer_id', $customerId)->first();
    }
}
