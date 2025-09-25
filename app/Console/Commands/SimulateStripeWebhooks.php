<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\StripeWebhookController;
use App\Models\User;
use Illuminate\Http\Request;

class SimulateStripeWebhooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:simulate-webhooks {event? : Specific event to simulate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate Stripe webhook events for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🎭 Simulating Stripe Webhook Events...');
        
        $event = $this->argument('event');
        
        if ($event) {
            $this->simulateEvent($event);
        } else {
            $this->simulateAllEvents();
        }
        
        $this->info('✅ Webhook simulation completed!');
    }
    
    private function simulateAllEvents()
    {
        $events = [
            'customer.subscription.created',
            'customer.subscription.updated', 
            'invoice.payment_succeeded',
            'invoice.payment_failed',
            'customer.subscription.trial_will_end',
        ];
        
        foreach ($events as $eventType) {
            $this->simulateEvent($eventType);
        }
    }
    
    private function simulateEvent($eventType)
    {
        $this->info("🔄 Simulating: {$eventType}");
        
        $user = User::first();
        if (!$user) {
            $this->error('❌ No users found for simulation');
            return;
        }
        
        // Ensure user has a Stripe customer ID
        if (!$user->stripe_customer_id) {
            $user->update(['stripe_customer_id' => 'cus_mock_' . $user->id]);
        }
        
        $mockData = $this->getMockEventData($eventType, $user);
        
        try {
            $controller = new StripeWebhookController();
            
            // Create a mock request
            $request = new Request();
            $request->headers->set('Stripe-Signature', 'mock_signature');
            $request->merge(['type' => $eventType, 'data' => ['object' => $mockData]]);
            
            // Simulate the webhook handling
            $this->handleMockEvent($eventType, $mockData, $controller);
            
            $this->info("✅ Successfully simulated: {$eventType}");
            
        } catch (\Exception $e) {
            $this->error("❌ Error simulating {$eventType}: {$e->getMessage()}");
        }
    }
    
    private function handleMockEvent($eventType, $mockData, $controller)
    {
        switch ($eventType) {
            case 'customer.subscription.created':
                $controller->handleSubscriptionCreated((object) $mockData);
                break;
            case 'customer.subscription.updated':
                $controller->handleSubscriptionUpdated((object) $mockData);
                break;
            case 'invoice.payment_succeeded':
                $controller->handlePaymentSucceeded((object) $mockData);
                break;
            case 'invoice.payment_failed':
                $controller->handlePaymentFailed((object) $mockData);
                break;
            case 'customer.subscription.trial_will_end':
                $controller->handleTrialWillEnd((object) $mockData);
                break;
        }
    }
    
    private function getMockEventData($eventType, $user)
    {
        $baseSubscription = [
            'id' => 'sub_mock_' . $user->id,
            'customer' => $user->stripe_customer_id,
            'status' => 'active',
            'current_period_start' => now()->timestamp,
            'current_period_end' => now()->addMonth()->timestamp,
            'cancel_at_period_end' => false,
            'canceled_at' => null,
            'trial_end' => now()->addDays(14)->timestamp,
        ];
        
        $baseInvoice = [
            'id' => 'in_mock_' . $user->id,
            'customer' => $user->stripe_customer_id,
            'subscription' => 'sub_mock_' . $user->id,
            'amount_paid' => 9700, // R$ 97.00 in cents
            'amount_due' => 9700,
            'currency' => 'brl',
            'period_start' => now()->timestamp,
            'period_end' => now()->addMonth()->timestamp,
            'attempt_count' => 1,
        ];
        
        switch ($eventType) {
            case 'customer.subscription.created':
                return array_merge($baseSubscription, ['status' => 'trialing']);
                
            case 'customer.subscription.updated':
                return array_merge($baseSubscription, ['status' => 'active']);
                
            case 'customer.subscription.trial_will_end':
                return array_merge($baseSubscription, [
                    'status' => 'trialing',
                    'trial_end' => now()->addDays(3)->timestamp
                ]);
                
            case 'invoice.payment_succeeded':
                return $baseInvoice;
                
            case 'invoice.payment_failed':
                return array_merge($baseInvoice, [
                    'amount_paid' => 0,
                    'attempt_count' => 2,
                ]);
                
            default:
                return $baseSubscription;
        }
    }
}
