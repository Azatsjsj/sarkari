<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->longText('content')->nullable();
                $table->string('featured_image')->nullable();
                $table->json('additional_images')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->string('focus_keyphrase')->nullable();
                $table->string('tags')->nullable();
                $table->string('status')->default('draft'); // draft, published
                $table->timestamp('published_at')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_breaking')->default(false);
                $table->boolean('enable_schema')->default(true);
                $table->boolean('enable_breadcrumb')->default(true);
                $table->boolean('enable_faq')->default(false);
                $table->unsignedBigInteger('author_id')->nullable();
                $table->integer('views')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
