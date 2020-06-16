<?php

declare(strict_types=1);

use Illuminate\{Support\Facades\Schema, Database\Schema\Blueprint, Database\Migrations\Migration};

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('weeks');
    }
}
