<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();

            // Make relationship EXPLICIT to avoid FK guessing errors
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->text('short_description');
            $table->longText('description');
            $table->date('start_date');
            $table->date('last_date');
            $table->string('exam_date')->nullable();
            $table->string('admit_card_date')->nullable();
            $table->string('result_date')->nullable();
            $table->string('official_website');
            $table->string('application_fee')->nullable();
            $table->string('age_limit')->nullable();
            $table->string('qualification')->nullable();
            $table->string('total_post')->nullable();
            $table->string('job_location')->nullable();
            $table->string('application_link');
            $table->string('notification_pdf')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('jobs');
    }
};
