<?php

use App\Models\Week;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Week::class, function (Faker $faker) {
    return ['name' => $faker->word];
});
