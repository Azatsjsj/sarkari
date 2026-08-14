<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedToMultipleTables extends Migration
{
    public function up()
    {
        $tables = ['jobs', 'results', 'admit_cards', 'answer_keys', 'admissions'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'is_featured')) {
                Schema::table($table, function (Blueprint $schema) use ($table) {
                    $schema->boolean('is_featured')->default(false)->after('is_active');
                    $schema->index('is_featured');
                });
            }
        }
    }

    public function down()
    {
        $tables = ['jobs', 'results', 'admit_cards', 'answer_keys', 'admissions'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'is_featured')) {
                Schema::table($table, function (Blueprint $schema) use ($table) {
                    $schema->dropColumn('is_featured');
                });
            }
        }
    }
}