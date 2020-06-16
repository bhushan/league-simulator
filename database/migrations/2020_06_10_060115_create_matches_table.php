<?php

declare(strict_types=1);

use Illuminate\{Support\Facades\Schema, Database\Schema\Blueprint, Database\Migrations\Migration};

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_team');
            $table->unsignedBigInteger('away_team');
            $table->unsignedBigInteger('week_id');
            $table->integer('home_team_score')->default(0);
            $table->integer('away_team_score')->default(0);
            $table->boolean('is_played')->default(false);
            $table->timestamps();

            $table->foreign('home_team')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('week_id')->references('id')->on('weeks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
}
