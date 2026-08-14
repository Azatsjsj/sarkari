<?php
// database/migrations/2024_01_01_000001_create_answer_keys_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerKeysTable extends Migration
{
    public function up()
    {
        Schema::create('answer_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->date('answer_key_date');
            $table->string('exam_name')->nullable();
            $table->date('exam_date')->nullable();
            $table->string('official_website');
            $table->string('download_link');
            $table->string('answer_key_file')->nullable();
            $table->text('instructions')->nullable();
            $table->json('subjects')->nullable(); // Store subjects as JSON
            $table->integer('total_questions')->nullable();
            $table->integer('total_marks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            $table->integer('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'answer_key_date']);
            $table->index('slug');
            $table->index('job_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('answer_keys');
    }
}