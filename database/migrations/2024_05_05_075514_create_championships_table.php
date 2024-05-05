<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('championships', function (Blueprint $table) {
            $table->id();
            $table->integer('championship_code');
            $table->integer('round');
            $table->integer('game_id');
            $table->unsignedBigInteger('team_id_a');
            $table->unsignedBigInteger('team_id_b');
            $table->integer('red_card_a');
            $table->integer('red_card_b');
            $table->integer('yellow_card_a');
            $table->integer('yellow_card_b');
            $table->integer('goals_a');
            $table->integer('goals_b');
            $table->unsignedBigInteger('winning_team_id');
            $table->unsignedBigInteger('losing_team_id');
            $table->timestamps();

            $table->foreign('team_id_a')->references('id')->on('teams');
            $table->foreign('team_id_b')->references('id')->on('teams');
            $table->foreign('losing_team_id')->references('id')->on('teams');
            $table->foreign('winning_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('championships', function (Blueprint $table) {
            $table->dropForeign('championships_team_id_a_foreign');
            $table->dropForeign('championships_team_id_b_foreign');
            $table->dropForeign('championships_winning_team_id_foreign');
            $table->dropForeign('championships_losing_team_id_foreign');
        });
        Schema::dropIfExists('championships');
    }
};
