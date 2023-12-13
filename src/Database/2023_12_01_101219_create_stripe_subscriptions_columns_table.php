<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stripe_subscriptions', function (Blueprint $table) {
            $table->string('invoice_id')->nullable()->index()->comment("This is the latest_invoice column in the customer.subscription.updated");
            $table->string('item_id')->nullable()->comment("This is same as the subscription_items.stripe_id as designed by cashier");
            $table->string('current_period_end')->nullable();
            $table->string('current_period_start')->nullable();
            $table->string('discount')->nullable()->comment('The discount applied on the checkout');
            $table->string('interval')->nullable()->comment('yearly or monthly or any other interval');
            $table->integer('interval_count')->nullable()->comment('Number of interval (1,2...etc)');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stripe_subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_id',
                'item_id',
                'current_period_end',
                'current_period_start',
                'discount',
                'interval',
                'interval_count'
            ]);
        });
    }
};
