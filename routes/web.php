<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, API\LeagueController, API\MatchController};

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::get('league-table', [LeagueController::class, 'index'])->name('league-table.index');
    Route::patch('matches', [MatchController::class, 'update'])->name('matches.update');
    Route::patch('matches/reset', [MatchController::class, 'reset'])->name('matches.reset');
});
