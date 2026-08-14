<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFeaturedToAnswerKeysTable extends Migration
{
    public function up()
    {
        Schema::table('answer_keys', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->index('is_featured');
        });
    }

    public function down()
    {
        Schema::table('answer_keys', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
}