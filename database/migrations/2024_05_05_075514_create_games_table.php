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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->integer('championship_code')->comment('Código general del campeonato');
            $table->integer('round')->comment('ronda eliminatoria');
            $table->integer('order')->comment('Orden del partido por ronda');
            $table->unsignedBigInteger('team_id_a');
            $table->unsignedBigInteger('team_id_b');
            $table->integer('red_card_a')->default(0);
            $table->integer('red_card_b')->default(0);
            $table->integer('yellow_card_a')->default(0);
            $table->integer('yellow_card_b')->default(0);
            $table->integer('goals_a')->default(0);
            $table->integer('goals_b')->default(0);
            $table->unsignedBigInteger('winning_team_id')->nullable();
            $table->unsignedBigInteger('losing_team_id')->nullable();
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
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign('games_team_id_a_foreign');
            $table->dropForeign('games_team_id_b_foreign');
            $table->dropForeign('games_winning_team_id_foreign');
            $table->dropForeign('games_losing_team_id_foreign');
        });
        Schema::dropIfExists('games');
    }
};
