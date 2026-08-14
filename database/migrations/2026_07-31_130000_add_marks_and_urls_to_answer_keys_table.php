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
        Schema::table('answer_keys', function (Blueprint $table) {
            if (!Schema::hasColumn('answer_keys', 'answer_key_url')) {
                $table->string('answer_key_url')->nullable()->after('download_link');
            }
            if (!Schema::hasColumn('answer_keys', 'objection_link')) {
                $table->string('objection_link')->nullable()->after('answer_key_url');
            }
            if (!Schema::hasColumn('answer_keys', 'correct_marks')) {
                $table->decimal('correct_marks', 8, 2)->default(1.00)->after('total_marks');
            }
            if (!Schema::hasColumn('answer_keys', 'negative_marks')) {
                $table->decimal('negative_marks', 8, 2)->default(0.25)->after('correct_marks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('answer_keys', function (Blueprint $table) {
            $table->dropColumn(['answer_key_url', 'objection_link', 'correct_marks', 'negative_marks']);
        });
    }
};
