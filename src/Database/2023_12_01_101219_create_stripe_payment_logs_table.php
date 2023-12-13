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
        Schema::create('stripe_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('type',['subscription','charge'])->default('subscription')->nullable();
            $table->enum('refunded',['0','1'])->default('0')->nullable();
            $table->string('invoice_id')->nullable()->index();
            $table->text('invoice_pdf')->nullable();
            $table->text('hosted_invoice_url')->nullable();
            $table->text('receipt_url')->nullable();
            $table->string('charge_id')->nullable()->comment('of type charge');
            $table->string('amount_paid')->nullable();
            $table->string('subscription')->nullable()->comment('The stripe_subscriptions.stripe_id');
            $table->string('subscription_item')->nullable()->comment('The subscription_items.stripe_id');
            $table->string('paid')->nullable()->comment("True or False");
            $table->string('invoice_number')->nullable()->comment("The number from the invoice payload");
            $table->string('billing_reason');
            $table->text('description')->nullable();
            $table->json('payload')->nullable();
            $table->json('refund_payload')->nullable()->comment("The refund payload which holds important info like the refund receipt to show to a customer");
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_payment_logs');
    }
};
