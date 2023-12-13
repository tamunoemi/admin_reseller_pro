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
        Schema::create('paddle_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('refunded',['0','1'])->default('0')->nullable();
            $table->string('checkout_id');
            $table->string('order_id');
            $table->string('product_id_or_subscription_plan_id')->nullable()->nullable()->comment('This could be subscription_plan_id or product_id depending on the alert_name type of paddle webhook');
            $table->string('product_or_plan_name')->nullable()->comment('This could be plan_name or product_name depending on the alert_name type of paddle webhook');
            $table->string('earnings');
            $table->string('status')->nullable();
            $table->string('subscription_id')->nullable()->comment("This value corresponds to the paddle_id in the paddle_subscriptions table which can be used to get the details of a subscription");
            $table->string('alert_name');
            $table->string('country')->nullable();
            $table->text('receipt_url');
            $table->json('payload')->nullable();
            $table->json('refund_payload')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_off_payment_logs');
    }
};
