<?php

use App\Models\{Team, Week, Match};
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Match::class, function () {
    return [
        'home_team' => factory(Team::class),
        'away_team' => factory(Team::class),
        'week_id' => factory(Week::class),
    ];
});
