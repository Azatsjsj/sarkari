<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmitCardsTable extends Migration
{
    public function up()
    {
        Schema::create('admit_cards', function (Blueprint $table) {
            $table->id();

            // Explicit reference to avoid mismatched FK errors
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->date('admit_card_date');
            $table->date('exam_date')->nullable();
            $table->string('exam_venue')->nullable();
            $table->string('official_website');
            $table->string('download_link');
            $table->string('admit_card_file')->nullable();
            $table->text('instructions')->nullable();
            $table->text('required_documents')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('download_count')->default(0);
            $table->integer('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'admit_card_date']);
            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::table('admit_cards', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
        });

        Schema::dropIfExists('admit_cards');
    }
}
