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
        Schema::create('answer_key_calculations', function (Blueprint $table) {
            $table->id();
            $table->string('answer_key_url');
            $table->string('category', 50);
            $table->string('horizontal_reservation', 50)->default('None');
            $table->string('gender', 20);
            $table->string('state', 100);
            $table->integer('total_questions')->default(100);
            $table->integer('correct_answers')->default(0);
            $table->integer('wrong_answers')->default(0);
            $table->decimal('positive_marks', 8, 2)->default(0.00);
            $table->decimal('negative_marks', 8, 2)->default(0.00);
            $table->decimal('net_score', 8, 2)->default(0.00);
            $table->decimal('normalized_score', 8, 2)->nullable();
            $table->integer('overall_rank')->nullable();
            $table->integer('category_rank')->nullable();
            $table->integer('state_rank')->nullable();
            $table->decimal('percentile', 5, 2)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_key_calculations');
    }
};
