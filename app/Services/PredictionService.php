<?php

declare(strict_types=1);

namespace App\Services;

class PredictionService implements PredictionInterface
{
    /**
     * Get predictions.
     *
     * @param array $teamData
     * @return array
     */
    public function getPredictions(array $teamData): array
    {
        $winPoint = config('simulation.points.win');

        $data = [];

        foreach ($teamData as $team) {
            $winProbability = 1;
            $drawProbability = 1;
            $lostProbability = 1;
            $pointsProbability = 1;

            if ($team['winCount'] > 0) {
                $winProbability = $team['winCount'] / $team['playedCount'];
            }

            if ($team['drawCount'] > 0) {
                $drawProbability = $team['drawCount'] / $team['playedCount'];
            }

            if ($team['lostCount'] > 0) {
                $lostProbability = $team['lostCount'] / $team['playedCount'];
            }

            if ($team['points'] > 0) {
                $pointsProbability = $team['points'] / ($winPoint * $team['playedCount']);
            }

            $data[$team['teamName']] = $winProbability * $drawProbability * $lostProbability * $pointsProbability;
        }

        return $this->getPredictionPercentage($data);
    }

    /**
     * Convert raw predictions into percentage.
     *
     * @param array $data
     * @return array
     */
    private function getPredictionPercentage(array $data): array
    {
        $totalOfPoints = array_sum($data);

        return array_map(function ($teamPoints) use ($totalOfPoints) {
            $predictionPercentage = ($teamPoints / $totalOfPoints) * 100;

            return round($predictionPercentage, 2);
        }, $data);
    }
}
