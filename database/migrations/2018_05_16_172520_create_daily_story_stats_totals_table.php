<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyStoryStatsTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_story_stats_totals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('identifier_id');
            $table->date('date');
            $table->int('hits');
            $table->int('uniques');
            $table->float('dwell', 8, 4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_story_stats_totals');
    }
}
