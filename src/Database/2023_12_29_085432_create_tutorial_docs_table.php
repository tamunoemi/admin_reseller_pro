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
        Schema::create('tutorial_docs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Full title/name of doc');
            $table->string('name_alias')->comment('Used internally for tracking and cannot be edited.');
            $table->enum('can_edit_name',['0','1'])->default('0')->nullable();
            $table->enum('can_delete',['0','1'])->default('0')->nullable();
            $table->enum('is_published',['0','1'])->default('0')->nullable()->comment("Only published docs are shown to users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorial_docs');
    }
};
