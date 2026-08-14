<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('documents')) {
            Schema::create('documents', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('document_number')->nullable();
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->string('type')->default('notice'); // notice, certificate, guide, etc.
                $table->string('category')->nullable();
                $table->string('file_path')->nullable();
                $table->string('file_name')->nullable();
                $table->bigInteger('file_size')->nullable();
                $table->string('file_type')->nullable();
                $table->date('issue_date')->nullable();
                $table->date('valid_upto')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('download_count')->default(0);
                $table->integer('views')->default(0);
                $table->string('department')->nullable();
                $table->string('issued_by')->nullable();
                $table->string('language')->default('English');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
