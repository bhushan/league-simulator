<?php

declare(strict_types=1);

namespace Tests\Database\Seeds;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TestTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        factory(Team::class)->create(['name' => 'Chelsea']);
        factory(Team::class)->create(['name' => 'Arsenal']);
        factory(Team::class)->create(['name' => 'Manchester City']);
        factory(Team::class)->create(['name' => 'Liverpool']);
    }
}
