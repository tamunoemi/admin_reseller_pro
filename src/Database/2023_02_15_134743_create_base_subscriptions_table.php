<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('base_subscriptions')) {
            Schema::create('base_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->enum('type',['jvzoo','warriorplus','clickbank','custom','paddle','stripe'])->default('custom')->comment("Paddle and stripe references subscriptions and followed by the subscription_id column for tracing on their respective tables");
                $table->integer('user_id');
                $table->integer('package_id');
                $table->integer('paddle_payment_logs_id')->nullable()->comment('Reference payment payload from paddle for reference purpose');
                $table->enum('is_active',['0','1'])->default('1');
                $table->string('amount');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('transactionId')->nullable();
                $table->dateTime('expires')->nullable();
                $table->json('payment_Data')->nullable();
                $table->string('paddle_or_stripe_subscription_id')->nullable()->comment('Paddle or stripe subscription table id');

                $table->enum('is_cancelled',['0','1'])->default('0')->nullable();
                $table->enum('is_refunded',['0','1'])->default('0')->nullable();
                $table->enum('is_expired',['0','1'])->default('0')->nullable();
                $table->timestamp('cancelled_date')->nullable();

                $table->timestamps();

            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_subscriptions');
    }
}
