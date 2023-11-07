<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaunchSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('launch_subscriptions')) {
            Schema::create('launch_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->enum('type',['jvzoo','warriorplus','clickbank','custom'])->default('custom');
                $table->integer('user_id');
                $table->integer('package_id');
                $table->enum('is_active',['0','1'])->default('1');
                $table->string('amount');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('transactionId')->nullable();
                $table->dateTime('expires')->nullable();
                $table->json('payment_Data')->nullable();

                $table->enum('is_cancelled',['0','1'])->default('0')->nullable();
                $table->enum('is_refunded',['0','1'])->default('0')->nullable();
                $table->enum('is_expired',['0','1'])->default('0')->nullable();

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
        Schema::dropIfExists('launch_subscriptions');
    }
}
