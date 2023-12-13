<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment("must not have spaces, cannot be changed and only used internally. It is not shown to users.");
            $table->string('name_alias')->comment("The name in a format that will be shown to users.");
            $table->text('description')->nullable();
 

            $table->json('price')->comment("Json prices in the format {per_month:'', per_year: ''}");

            $table->enum('interval', ['day', 'week', 'month', 'year'])->default('month');
            $table->smallInteger('interval_count')->default(1);
            $table->smallInteger('trial_period_days')->nullable();

            $table->string('validity')->default(0)->nullable();

            $table->smallInteger('sort_order')->nullable();

            $table->json('discount')->comment("Json discount in the format {per_month:'', per_year: ''}")->nullable();

            $table->json('coupon')->comment("Json coupon in the format {month:'', year: ''}")->nullable();


            $table->enum('type', ['launch', 'saas','default'])->default('default');
            $table->string('role_ids')->comment("The role ids separated by comma")->nullable();
            $table->text('monthly_limit')->nullable()->comment("Total limit per month usage");
            $table->text('bulk_limit')->nullable()->comment("Overall total limit usage");

            $table->enum('visible', ['0', '1'])->default(0);
            $table->enum('highlight', ['0', '1'])->default(0);
            $table->enum('user_can_resell', ['0', '1'])->default(1)->nullable();;
            $table->enum('deleted', ['0', '1'])->default(0);

            $table->json('jvzoo_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");
            $table->json('warriorplus_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");
            $table->json('paddle_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");
            $table->json('appsumo_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");
            $table->json('clickbank_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");
            $table->json('stripe_id')->nullable()->comment("Json product ids in the format {month:'', year: ''}");

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
