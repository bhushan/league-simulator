<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\{Team, Week, Match};
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates default setup for this class.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedData();
    }

    /**
     * Test Every Match Has One Home Team.
     *
     * @return void
     */
    public function testEveryMatchHasOneHomeTeam(): void
    {
        $firstMatch = Match::first();

        $this->assertInstanceOf(Team::class, $firstMatch->homeTeam);

        $this->assertEquals($firstMatch->home_team, $firstMatch->homeTeam->id);
    }

    /**
     * Test Every Match Has One Away Team.
     *
     * @return void
     */
    public function testEveryMatchHasOneAwayTeam(): void
    {
        $firstMatch = Match::first();

        $this->assertInstanceOf(Team::class, $firstMatch->awayTeam);

        $this->assertEquals($firstMatch->away_team, $firstMatch->awayTeam->id);
    }

    /**
     * Test Every Match Belongs To Week.
     *
     * @return void
     */
    public function testEveryMatchBelongsToWeek(): void
    {
        $firstMatch = Match::first();

        $this->assertInstanceOf(Week::class, $firstMatch->week);

        $this->assertEquals($firstMatch->week_id, $firstMatch->week->id);
    }
}
