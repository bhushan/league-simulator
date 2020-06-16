<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Mockery;
use Tests\TestCase;
use App\Models\{Team, Match};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\{TeamRepository, MatchRepository};
use App\Services\{PredictionService, StatisticsService};

class StatisticsServiceTest extends TestCase
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

       $predictionServiceMock = Mockery::mock(PredictionService::class)
            ->shouldReceive('getPredictions')
            ->once()
            ->andReturn($this->getDummyPredictions())
            ->getMock();

        $this->statisticsService = new StatisticsService(
            new MatchRepository(new Match()),
            new TeamRepository(new Team()),
            $predictionServiceMock
        );
    }

    /**
     * Test Verifies Get Data Returns Proper Data.
     *
     * @return void
     */
    public function testVerifiesGetDataReturnsProperData(): void
    {
        $weekId = 2;

        $correctRecords = [
            0 => [
                'teamName' => 'Chelsea', 'playedCount' => 4, 'winCount' => 0,
                'drawCount' => 4, 'lostCount' => 0, 'goalDifference' => 4, 'points' => 4,
            ],
            1 => [
                'teamName' => 'Arsenal', 'playedCount' => 2, 'winCount' => 0,
                'drawCount' => 2, 'lostCount' => 0, 'goalDifference' => 2, 'points' => 2,
            ],
            2 => [
                'teamName' => 'Manchester City', 'playedCount' => 1, 'winCount' => 0,
                'drawCount' => 1, 'lostCount' => 0, 'goalDifference' => 1, 'points' => 1,
            ],
            3 => [
                'teamName' => 'Liverpool', 'playedCount' => 1, 'winCount' => 0,
                'drawCount' => 1, 'lostCount' => 0, 'goalDifference' => 1, 'points' => 1,
            ],
        ];

        $data = $this->statisticsService->getData($weekId);

        $this->assertEquals($correctRecords, $data[0]['records']);
        $this->assertEquals($this->getDummyPredictions(), $data[0]['predictions']);
    }

    /**
     * Dummy predictions.
     *
     * @return array
     */
    private function getDummyPredictions(): array
    {
        return [
            'Chelsea' => 25.0, 'Arsenal' => 25.0, 'Manchester City' => 25.0, 'Liverpool' => 25.0,
        ];
    }
}
