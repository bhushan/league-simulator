<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use App\Models\{Team, Week, Match};

class MatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $teams = Team::all()->pluck('id');

        $matches = $teams->crossJoin($teams)->filter(function ($match) {
            return $match[0] !== $match[1];
        })->toArray();

        $matches = array_values($matches);

        $weekId = 0;

        $matchesCount = count($matches);

        for ($index = 0; $index < $matchesCount; $index++) {
            if ($index % 2 === 0) {
                $weekId = factory(Week::class)->create()->id;
            }

            factory(Match::class)->create([
                'home_team' => $matches[$index][0],
                'away_team' => $matches[$index][1],
                'week_id' => $weekId,
            ]);
        }
    }
}
