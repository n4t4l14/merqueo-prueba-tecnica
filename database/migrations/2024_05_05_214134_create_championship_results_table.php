<?php

use App\Constants\TeamStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('championship_results', function (Blueprint $table) {
            $table->id();
            $table->integer('championship_code');
            $table->integer('current_round');
            $table->unsignedBigInteger('team_id');
            $table->integer('red_cards')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('goals')->default(0);
            $table->integer('won_games')->default(0);
            $table->integer('lost_games')->default(0);
            $table->enum('team_status', TeamStatus::toArray())->nullable();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('championship_results', function (Blueprint $table) {
            $table->dropForeign(['championship_code']);
            $table->dropForeign(['team_id']);
        });
        Schema::dropIfExists('championship_results');
    }
};
