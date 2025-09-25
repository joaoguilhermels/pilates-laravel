<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SaasPlans;
use App\Services\StripeService;

class SyncStripeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:sync-products {--force : Force sync even if products already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync SaaS plans with Stripe products and prices';

    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        parent::__construct();
        $this->stripeService = $stripeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Stripe products synchronization...');

        try {
            // Get all SaaS plans
            $plans = SaasPlans::all();
            
            if ($plans->isEmpty()) {
                $this->warn('⚠️  No SaaS plans found in database. Please seed the plans first.');
                $this->info('Run: php artisan db:seed --class=SaasPlansSeeder');
                return Command::FAILURE;
            }

            $this->info("📦 Found {$plans->count()} SaaS plans to sync with Stripe");

            $progressBar = $this->output->createProgressBar($plans->count());
            $progressBar->start();

            $synced = 0;
            $errors = 0;

            foreach ($plans as $plan) {
                try {
                    $this->line('');
                    $this->info("🔄 Syncing plan: {$plan->name}");

                    // Check if we should skip if already synced
                    if (!$this->option('force') && $plan->stripe_product_id) {
                        $this->comment("⏭️  Plan already has Stripe product ID: {$plan->stripe_product_id}");
                        $progressBar->advance();
                        continue;
                    }

                    // Sync with Stripe
                    $product = $this->stripeService->createOrUpdateStripeProduct($plan);
                    
                    $this->info("✅ Successfully synced plan: {$plan->name}");
                    $this->comment("   Product ID: {$product->id}");
                    $this->comment("   Monthly Price ID: {$plan->fresh()->stripe_monthly_price_id}");
                    $this->comment("   Yearly Price ID: {$plan->fresh()->stripe_yearly_price_id}");

                    $synced++;
                } catch (\Exception $e) {
                    $this->error("❌ Failed to sync plan: {$plan->name}");
                    $this->error("   Error: {$e->getMessage()}");
                    $errors++;
                }

                $progressBar->advance();
            }

            $progressBar->finish();
            $this->line('');
            $this->line('');

            // Summary
            $this->info('📊 Synchronization Summary:');
            $this->info("✅ Successfully synced: {$synced} plans");
            
            if ($errors > 0) {
                $this->error("❌ Failed to sync: {$errors} plans");
                return Command::FAILURE;
            }

            $this->info('🎉 All plans synchronized successfully with Stripe!');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('💥 Fatal error during synchronization:');
            $this->error($e->getMessage());
            return Command::FAILURE;
        }
    }
}
