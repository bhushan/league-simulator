<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Services\MatchService;
use App\Services\StatisticsService;
use App\Http\Controllers\Controller;

class LeagueController extends Controller
{
    /**
     * Returns data to display league table.
     *
     * @param StatisticsService $statisticsService
     * @param MatchService $matchService
     * @return array
     */
    public function index(StatisticsService $statisticsService, MatchService $matchService): array
    {
        $weekId = (int) (request()->input('week') ?? 1);

        $matchService->generateUnplayedMatchScores($weekId);

        return $statisticsService->getData($weekId);
    }
}
