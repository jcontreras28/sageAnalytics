<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicationIdToDailyStoryStatsTotalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_story_stats_totals', function (Blueprint $table) {
            //
            $table->integer('publication_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_story_stats_totals', function (Blueprint $table) {
            //
            $table->dropColumn('publication_id');
        });
    }
}
