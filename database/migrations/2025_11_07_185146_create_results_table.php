<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');

            // Explicitly reference the jobs table
            $table->foreignId('job_id')
                ->constrained('jobs')
                ->onDelete('cascade');

            $table->text('description')->nullable();
            $table->string('result_link');
            $table->date('result_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('job_id');
            $table->index('result_date');
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign(['job_id']);  // drop FK first
        });

        Schema::dropIfExists('results');
    }
}
