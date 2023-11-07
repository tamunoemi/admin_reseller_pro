<?php
return [
    'default_subscription_gateway' => env('DEFAULT_SUBSCRIPTION_GATEWAY', 'paddle'),

    /**
     * Options include one_time_purchase, monthly, yearly
     */
    'plan_interval_option' => env('PLAN_INTERVAL_OPTION', 'yearly'),

    'cashier_currency' => env('CASHIER_CURRENCY', 'usd'),

    'stripe_webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
    'stripe_secret' => env('STRIPE_SECRET', ''),
    'stripe_key' => env('STRIPE_KEY', ''),

    'paddle_sandbox' => env('PADDLE_SANDBOX', false),
    'paddle_public_key' => env('PADDLE_PUBLIC_KEY', ''),
    'paddle_vendor_auth_code' => env('PADDLE_VENDOR_AUTH_CODE', ''),
    'paddle_vendor_id' => env('PADDLE_VENDOR_ID', ''),
];
