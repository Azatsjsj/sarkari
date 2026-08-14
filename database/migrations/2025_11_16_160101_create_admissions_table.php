<?php
// database/migrations/2024_01_01_create_admissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('university_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('last_date');
            $table->date('exam_date')->nullable();
            $table->decimal('application_fee', 8, 2)->nullable();
            $table->integer('total_seats')->nullable();
            $table->longText('eligibility')->nullable();
            $table->longText('application_process')->nullable();
            $table->json('important_dates')->nullable();
            $table->json('contact_info')->nullable();
            $table->string('official_website')->nullable();
            $table->string('brochure_url')->nullable();
            $table->string('apply_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'is_featured']);
            $table->index('last_date');
            $table->index(['university_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}