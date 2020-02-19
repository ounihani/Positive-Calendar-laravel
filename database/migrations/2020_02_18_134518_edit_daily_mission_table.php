<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDailyMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_missions', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('image');
            $table->string('challenge_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_missions', function (Blueprint $table) {
            $table->text('description');
            $table->text('image');
            $table->dropColumn('challenge_name');
        });
    }
}
