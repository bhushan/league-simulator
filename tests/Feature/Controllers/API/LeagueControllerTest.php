<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use Tests\TestCase;
use App\Models\{Team, Match};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\{TeamRepository, MatchRepository};
use App\Services\{StatisticsService, PredictionService};

class LeagueControllerTest extends TestCase
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

        $this->statisticsService = new StatisticsService(
            new MatchRepository(new Match()),
            new TeamRepository(new Team()),
            new PredictionService()
        );
    }

    /**
     * Test Verifies Guest Can Send Request To League Table Api Route.
     *
     * @return void
     */
    public function testVerifiesGuestCanSendRequestToLeagueTableApiRoute(): void
    {
        $this->get(route('api.league-table.index'))->assertOk();
    }

    /**
     * Test Verifies League Table Api Route Returns Total Teams Statistics For The Week.
     *
     * @return void
     */
    public function testVerifiesLeagueTableApiRouteReturnsTotalTeamsStatisticsForTheWeek(): void
    {
        $weekId = 2;

        $response = $this->getJson(route('api.league-table.index', ['week' => $weekId]))->json();

        $data = $this->statisticsService->getData($weekId);

        $this->assertEquals($data[0]['records'], $response[0]['records']);
        $this->assertEquals($data[0]['weeklyMatches'], $response[0]['weeklyMatches']);
        $this->assertEquals($data[0]['predictions'], $response[0]['predictions']);
    }
}
