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
        Schema::create('team_batches', function (Blueprint $table) {
            $table->integer('team_number')->nullable();
            $table->integer('team_id')->nullable();
            $table->string('team_name')->nullable();
            $table->string('team_flag')->nullable();
            $table->string('team_status')->nullable();
            $table->integer('player_id')->nullable();
            $table->string('player_name')->nullable();
            $table->string('player_nationality')->nullable();
            $table->integer('player_age')->nullable();
            $table->string('player_position')->nullable();
            $table->integer('player_shirt_number')->nullable();
            $table->string('player_photo')->nullable();
            $table->string('player_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_batches');
    }
};
