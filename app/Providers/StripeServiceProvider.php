<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('stripe', function ($app) {
            return new \Stripe\StripeClient([
                'api_key' => config('stripe.secret'),
                'stripe_version' => config('stripe.api_version'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set the Stripe API key globally
        Stripe::setApiKey(config('stripe.secret'));
        Stripe::setApiVersion(config('stripe.api_version'));
        
        // Set the application info for better tracking
        Stripe::setAppInfo(
            'PilatesFlow',
            '1.0.0',
            'https://pilatesflow.com',
            'pp_partner_' . config('app.name')
        );
    }
}
