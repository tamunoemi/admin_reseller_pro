

//Generate payment link for stripe
            if ($request->user()->hasDefaultPaymentMethod()) {
                $paymentMethod = $request->user()->defaultPaymentMethod();

                $request->user()->newStripeSubscription(
                    $plan_name, 'price_monthly'
                )->create($paymentMethod);
            }

            
<?php
// webhook.php
//
// Use this sample code to handle webhook events in your integration.
//
// 1) Paste this code into a new file (webhook.php)
//
// 2) Install dependencies
//   composer require stripe/stripe-php
//
// 3) Run the server on http://localhost:4242
//   php -S localhost:4242

require 'vendor/autoload.php';

// The library needs to be configured with your account's secret key.
// Ensure the key is kept out of any version control system you might be using.
$stripe = new \Stripe\StripeClient('sk_test_...');

// This is your Stripe CLI webhook secret for testing your endpoint locally.
$endpoint_secret = 'whsec_c470c70c5e6dc35a767c8c405f5d4f2e00cb1d2bc5ef38e1964b9d1f5b200b90';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  exit();
}

// Handle the event
switch ($event->type) {
  case 'customer.created':
    $customer = $event->data->object;
  case 'customer.deleted':
    $customer = $event->data->object;
  case 'customer.updated':
    $customer = $event->data->object;
  case 'customer.subscription.created':
    $subscription = $event->data->object;
  case 'customer.subscription.deleted':
    $subscription = $event->data->object;
  case 'customer.subscription.paused':
    $subscription = $event->data->object;
  case 'customer.subscription.resumed':
    $subscription = $event->data->object;
  case 'customer.subscription.trial_will_end':
    $subscription = $event->data->object;
  case 'customer.subscription.updated':
    $subscription = $event->data->object;
  case 'invoice.payment_action_required':
    $invoice = $event->data->object;
  case 'invoice.payment_succeeded':
    $invoice = $event->data->object;
  case 'payment_method.card_automatically_updated':
    $paymentMethod = $event->data->object;
  case 'payment_method.updated':
    $paymentMethod = $event->data->object;
  // ... handle other event types
  default:
    echo 'Received unknown event type ' . $event->type;
}

http_response_code(200);







array:1 [▼ // packages/teckipro/admin/src/Domains/PaymentGateways/Stripe/Http/Controller/StripeSubscriptionController.php:207
  0 => array:9 [▼
    "id" => "pm_1OJlktD4TuPSjCa7xTLXu7YE"
    "object" => "payment_method"
    "billing_details" => array:4 [▼
      "address" => array:6 [▼
        "city" => null
        "country" => null
        "line1" => null
        "line2" => null
        "postal_code" => "50024"
        "state" => null
      ]
      "email" => null
      "name" => "Emi Robert"
      "phone" => null
    ]
    "card" => array:12 [▼
      "brand" => "mastercard"
      "checks" => array:3 [▶]
      "country" => "US"
      "exp_month" => 4
      "exp_year" => 2026
      "fingerprint" => "9lOgUgw6b5EPef8g"
      "funding" => "credit"
      "generated_from" => null
      "last4" => "4444"
      "networks" => array:2 [▶]
      "three_d_secure_usage" => array:1 [▶]
      "wallet" => null
    ]
    "created" => 1701733251
    "customer" => "cus_P81wKvn99sN4aT"
    "livemode" => false
    "metadata" => []
    "type" => "card"
  ]
]






<div class="col-xl-12 col-lg-12">
    <hr>
    <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Purchase</button>
  </div>
  

 
<button id="card-button" data-secret="{{ $intent->client_secret }}">
    Update Payment Method
</button>