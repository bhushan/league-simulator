<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\PredictionService;

class PredictionServiceTest extends TestCase
{

    /**
     * Test Verifies Predictions.
     *
     * @return void
     */
    public function testVerifiesPredictions(): void
    {
        $predictionService = new PredictionService();

        $records = [
            0 => [
                'teamName' => 'Liverpool',
                'playedCount' => 6,
                'winCount' => 5,
                'drawCount' => 1,
                'lostCount' => 0,
                'goalDifference' => 18,
                'points' => 16
            ],
            1 => [
                'teamName' => 'Arsenal',
                'playedCount' => 6,
                'winCount' => 3,
                'drawCount' => 0,
                'lostCount' => 3,
                'goalDifference' => 2,
                'points' => 9
            ]
        ];

        $correctResult = ['Liverpool' => 49.69, 'Arsenal' => 50.31];

        $this->assertEquals($correctResult, $predictionService->getPredictions($records));
    }
}
