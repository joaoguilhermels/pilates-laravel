<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Stripe payment processing.
    | You can set your Stripe API keys and other settings here.
    |
    */

    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'webhook_tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),

    /*
    |--------------------------------------------------------------------------
    | Stripe API Version
    |--------------------------------------------------------------------------
    |
    | The Stripe API version to use. This should match the version
    | you're using in your Stripe dashboard.
    |
    */
    'api_version' => '2024-06-20',

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for payments. For Brazilian market, we use BRL.
    |
    */
    'currency' => 'brl',

    /*
    |--------------------------------------------------------------------------
    | Payment Methods
    |--------------------------------------------------------------------------
    |
    | The payment methods to enable for Brazilian customers.
    |
    */
    'payment_methods' => [
        'card',
        'boleto',
        'pix',
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for subscription-based billing.
    |
    */
    'subscriptions' => [
        'trial_days' => 14,
        'grace_period_days' => 3,
        'incomplete_payment_behavior' => 'default_incomplete',
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Events
    |--------------------------------------------------------------------------
    |
    | The webhook events that your application should listen for.
    |
    */
    'webhook_events' => [
        'customer.subscription.created',
        'customer.subscription.updated',
        'customer.subscription.deleted',
        'customer.subscription.trial_will_end',
        'invoice.payment_succeeded',
        'invoice.payment_failed',
        'invoice.upcoming',
        'customer.created',
        'customer.updated',
        'customer.deleted',
        'payment_method.attached',
        'payment_method.detached',
        'setup_intent.succeeded',
        'setup_intent.setup_failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Brazilian Tax Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Brazilian tax handling (PIS/COFINS, etc.)
    |
    */
    'brazil' => [
        'tax_rate' => 0.0965, // 9.65% for SaaS services in Brazil
        'collect_tax_id' => true, // Collect CPF/CNPJ
    ],
];
