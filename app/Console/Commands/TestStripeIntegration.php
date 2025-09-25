<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SaasPlans;
use App\Models\User;

class TestStripeIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:test {--mock : Run in mock mode without real API calls}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Stripe integration functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Stripe Integration...');
        
        // Test 1: Check SaaS Plans
        $this->testSaasPlans();
        
        // Test 2: Mock Stripe Product Creation
        if ($this->option('mock')) {
            $this->mockStripeProducts();
        }
        
        // Test 3: Test User Stripe Methods
        $this->testUserStripeMethods();
        
        // Test 4: Test Billing Routes
        $this->testBillingRoutes();
        
        $this->info('✅ All tests completed!');
    }
    
    private function testSaasPlans()
    {
        $this->info('📦 Testing SaaS Plans...');
        
        $plans = SaasPlans::all();
        
        if ($plans->isEmpty()) {
            $this->error('❌ No SaaS plans found!');
            return;
        }
        
        $this->info("✅ Found {$plans->count()} SaaS plans:");
        
        foreach ($plans as $plan) {
            $this->line("   - {$plan->name}: R$ {$plan->monthly_price}/mês");
            $this->line("     Stripe Product ID: " . ($plan->stripe_product_id ?: 'Not set'));
            $this->line("     Monthly Price ID: " . ($plan->stripe_monthly_price_id ?: 'Not set'));
            $this->line("     Yearly Price ID: " . ($plan->stripe_yearly_price_id ?: 'Not set'));
        }
    }
    
    private function mockStripeProducts()
    {
        $this->info('🎭 Mocking Stripe Product Creation...');
        
        $plans = SaasPlans::all();
        
        foreach ($plans as $plan) {
            // Simulate Stripe product creation
            $productId = 'prod_mock_' . strtolower(str_replace(' ', '_', $plan->name));
            $monthlyPriceId = 'price_mock_' . $plan->id . '_monthly';
            $yearlyPriceId = 'price_mock_' . $plan->id . '_yearly';
            
            $plan->update([
                'stripe_product_id' => $productId,
                'stripe_monthly_price_id' => $monthlyPriceId,
                'stripe_yearly_price_id' => $yearlyPriceId,
                'stripe_metadata' => [
                    'mock' => true,
                    'created_at' => now()->toISOString(),
                ]
            ]);
            
            $this->info("✅ Mocked Stripe product for: {$plan->name}");
            $this->comment("   Product ID: {$productId}");
            $this->comment("   Monthly Price: {$monthlyPriceId}");
            $this->comment("   Yearly Price: {$yearlyPriceId}");
        }
    }
    
    private function testUserStripeMethods()
    {
        $this->info('👤 Testing User Stripe Methods...');
        
        $user = User::first();
        
        if (!$user) {
            $this->warn('⚠️  No users found to test');
            return;
        }
        
        $this->info("Testing with user: {$user->email}");
        
        // Test Stripe customer ID generation
        try {
            $customerId = $user->getStripeCustomerId();
            $this->info("✅ Stripe Customer ID: {$customerId}");
        } catch (\Exception $e) {
            $this->error("❌ Error getting Stripe Customer ID: {$e->getMessage()}");
        }
        
        // Test subscription status methods
        $this->info("Subscription Status Methods:");
        $this->line("   - hasActiveSubscription(): " . ($user->hasActiveSubscription() ? 'Yes' : 'No'));
        $this->line("   - hasActiveStripeSubscription(): " . ($user->hasActiveStripeSubscription() ? 'Yes' : 'No'));
        $this->line("   - needsBillingInfo(): " . ($user->needsBillingInfo() ? 'Yes' : 'No'));
    }
    
    private function testBillingRoutes()
    {
        $this->info('🔗 Testing Billing Routes...');
        
        $routes = [
            'billing.index' => 'Billing Dashboard',
            'billing.plans' => 'Plan Selection',
            'billing.info' => 'Billing Information',
            'billing.success' => 'Payment Success',
            'billing.cancel' => 'Payment Canceled',
            'billing.portal' => 'Billing Portal',
        ];
        
        foreach ($routes as $routeName => $description) {
            try {
                $url = route($routeName);
                $this->info("✅ {$description}: {$url}");
            } catch (\Exception $e) {
                $this->error("❌ {$description}: Route not found");
            }
        }
    }
}
