<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use Tests\TestCase;
use App\Models\Match;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test To Verify Update Matches WeekId Is Required.
     *
     * @return void
     */
    public function testToVerifyUpdateMatchesWeekIdIsRequired(): void
    {
        $this->withExceptionHandling();

        $this->patch(route('api.matches.update'), ['weekId' => '', 'weeklyMatches' => []])
            ->assertSessionHasErrors('weekId');

        $this->patch(route('api.matches.update'), ['weekId' => null, 'weeklyMatches' => []])
            ->assertSessionHasErrors('weekId');

        $this->patch(route('api.matches.update'), ['weekId' => 'not-a-number', 'weeklyMatches' => []])
            ->assertSessionHasErrors('weekId');

        $this->patch(route('api.matches.update'), ['weekId' => 11, 'weeklyMatches' => []])
            ->assertSessionHasErrors('weekId');
    }

    /**
     * Test In Weekly Matches For Each Array Their Home Team And It's Score And Away Team And It's Score Are Required.
     *
     * @return void
     */
    public function testInWeeklyMatchesForEachArrayTheirHomeTeamAndItsScoreAndAwayTeamAndItsScoreAreRequired(): void
    {
        $this->withExceptionHandling();

        $this->patch(route('api.matches.update'), [
            'weekId' => 1,
            'weeklyMatches' => [
                0 => ['homeTeam' => '', 'homeTeamScore' => '', 'awayTeam' => '', 'awayTeamScore' => ''],
                1 => ['homeTeam' => '', 'homeTeamScore' => '', 'awayTeam' => '', 'awayTeamScore' => '']
            ],
        ])->assertSessionHasErrors([
            'weeklyMatches.0.homeTeam', 'weeklyMatches.1.homeTeam',
            'weeklyMatches.0.homeTeamScore', 'weeklyMatches.1.homeTeamScore',
            'weeklyMatches.0.awayTeam', 'weeklyMatches.1.awayTeam',
            'weeklyMatches.0.awayTeamScore', 'weeklyMatches.1.awayTeamScore',
        ]);

        $this->patch(route('api.matches.update'), [
            'weekId' => 1,
            'weeklyMatches' => [
                0 => [
                    'homeTeam' => 'not-a-team-name', 'homeTeamScore' => 'not-an-integer',
                    'awayTeam' => 'not-a-team-name', 'awayTeamScore' => 'not-an-integer',
                ],
                1 => [
                    'homeTeam' => 'not-a-team-name', 'homeTeamScore' => 'not-an-integer',
                    'awayTeam' => 'not-a-team-name', 'awayTeamScore' => 'not-an-integer',
                ]
            ],
        ])->assertSessionHasErrors([
            'weeklyMatches.0.homeTeam', 'weeklyMatches.1.homeTeam',
            'weeklyMatches.0.homeTeamScore', 'weeklyMatches.1.homeTeamScore',
            'weeklyMatches.0.awayTeam', 'weeklyMatches.1.awayTeam',
            'weeklyMatches.0.awayTeamScore', 'weeklyMatches.1.awayTeamScore',
        ]);
    }

    /**
     * Test Verifies Matches Scores Are Updated Properly.
     *
     * @return void
     */
    public function testVerifiesMatchesScoresAreUpdatedProperly(): void
    {
        $weekId = 1;

        $weeklyMatches = [
            ['homeTeam' => 'Chelsea', 'homeTeamScore' => 5, 'awayTeam' => 'Arsenal', 'awayTeamScore' => 6],
            ['homeTeam' => 'Chelsea', 'homeTeamScore' => 5, 'awayTeam' => 'Manchester City', 'awayTeamScore' => 6],
        ];

        $matches = Match::whereWeekId($weekId)->get()->toArray();

        $this->assertEquals(4, $matches[0]['home_team_score']);
        $this->assertEquals(5, $matches[0]['away_team_score']);
        $this->assertEquals(4, $matches[1]['home_team_score']);
        $this->assertEquals(5, $matches[1]['away_team_score']);

        $this->patch(route('api.matches.update'), ['weekId' => $weekId, 'currentWeek' => $weekId, 'weeklyMatches' => $weeklyMatches]);

        $matches = Match::whereWeekId($weekId)->get()->toArray();

        $this->assertEquals(5, $matches[0]['home_team_score']);
        $this->assertEquals(6, $matches[0]['away_team_score']);
        $this->assertEquals(5, $matches[1]['home_team_score']);
        $this->assertEquals(6, $matches[1]['away_team_score']);
    }

    /**
     * Test Verifies Reset Button Resets All Records For Each Match.
     *
     * @return void
     */
    public function testVerifiesResetButtonResetsAllRecordsForEachMatch(): void
    {
        $this->patch(route('api.matches.reset'))->assertRedirect();

        $matches = Match::all();

        foreach ($matches as $match) {
            $this->assertEquals(0, $match->home_team_score);
            $this->assertEquals(0, $match->away_team_score);
            $this->assertEquals(0, $match->is_played);
        }
    }

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
}
