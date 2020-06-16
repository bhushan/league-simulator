<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\RedirectResponse;
use App\Services\{MatchService, StatisticsService};
use App\Http\{Requests\MatchRequest, Controllers\Controller};

class MatchController extends Controller
{
    /**
     * Update matches record for particular week.
     *
     * @param MatchRequest $request
     * @param MatchService $matchService
     * @param StatisticsService $statisticsService
     * @return array
     */
    public function update(MatchRequest $request, MatchService $matchService, StatisticsService $statisticsService): array
    {
        $data = $request->validated();

        $matchService->updateMatchesForWeek($data);

        return $statisticsService->getData($data['currentWeek']);
    }

    /**
     * Reset all matches records.
     *
     * @param MatchService $matchService
     * @return RedirectResponse
     */
    public function reset(MatchService $matchService): RedirectResponse
    {
        $matchService->resetData();

        return back();
    }
}
