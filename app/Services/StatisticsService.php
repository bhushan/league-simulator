<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\{Team, Match};
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\{TeamRepository, MatchRepository};

class StatisticsService
{
    /**
     * @var MatchRepository
     */
    private $matchRepository;

    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var PredictionService
     */
    private $predictionService;

    /**
     * StatisticsService constructor.
     *
     * @param MatchRepository $matchRepository
     * @param TeamRepository $teamRepository
     * @param PredictionInterface $predictionService
     */
    public function __construct(
        MatchRepository $matchRepository,
        TeamRepository $teamRepository,
        PredictionInterface $predictionService
    ) {
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
        $this->predictionService = $predictionService;
    }

    /**
     * Get all weeks data upto the week id provided
     *
     * @param int $weekId
     * @return array
     */
    public function getData(int $weekId): array
    {
        $data = [];

        for ($index = $weekId; $index >= 1; $index--) {
            $records = $this->getRecordsForWeek($index);

            $weeklyMatches = $this->getWeeklyMatchesStatistics($index);

            $predictions = $index == 1 ? [] : $this->predictionService->getPredictions($records);

            $data[] = [
                'id' => $index,
                'records' => $records,
                'weeklyMatches' => $weeklyMatches,
                'errors' => [],
                'isEditing' => false,
                'predictions' => $predictions
            ];
        }

        return $data;
    }

    /**
     * Get Team Statistics for particular week.
     *
     * @param int $weekId
     * @return array
     */
    private function getRecordsForWeek(int $weekId): array
    {
        $matches = $this->matchRepository->whereUsingOperator('week_id', '<=', $weekId);
        $teams = $this->teamRepository->getAll();

        $data = [];

        foreach ($teams as $team) {
            $matchesResults = $this->getMatchesResults($team, $matches);

            $data[] = [
                'teamName' => $team->name,
                'playedCount' => $matchesResults['playedCount'],
                'winCount' => $matchesResults['winCount'],
                'drawCount' => $matchesResults['drawCount'],
                'lostCount' => $matchesResults['lostCount'],
                'goalDifference' => $matchesResults['goalDifference'],
                'points' => $this->getPoints(
                    $matchesResults['winCount'],
                    $matchesResults['drawCount'],
                    $matchesResults['lostCount']
                ),
            ];
        }

        return collect($data)->sortByDesc('points')->values()->toArray();
    }

    /**
     * Get all matches results played by team.
     *
     * @param Team $team
     * @param Collection $matches
     * @return array
     */
    private function getMatchesResults(Team $team, Collection $matches): array
    {
        $winCount = 0;
        $drawCount = 0;
        $lostCount = 0;
        $goalDifference = 0;

        foreach ($matches as $match) {
            if ($match->home_team != $team->id && $match->away_team != $team->id) {
                continue;
            }

            if ($this->hasTeamWon($team, $match)) {
                $winCount++;
            } elseif ($this->hasTeamLost($team, $match)) {
                $lostCount++;
            } else {
                $drawCount++;
            }

            $goalDifference = $this->getUpdatedGoalDifference($team, $match, $goalDifference);
        }

        return [
            'winCount' => $winCount,
            'drawCount' => $drawCount,
            'lostCount' => $lostCount,
            'playedCount' => $winCount + $drawCount + $lostCount,
            'goalDifference' => $goalDifference,
        ];
    }

    /**
     * Checks if team has won or not.
     *
     * @param Team $team
     * @param Match $match
     * @return bool
     */
    private function hasTeamWon(Team $team, Match $match): bool
    {
        if ($this->isHomeTeam($team, $match)) {
            return $match->home_team_score > $match->away_team_score;
        }

        if ($this->isAwayTeam($team, $match)) {
            return $match->home_team_score < $match->away_team_score;
        }

        return false;
    }

    /**
     * Check if team is playing match on home ground.
     *
     * @param Team $team
     * @param Match $match
     * @return bool
     */
    private function isHomeTeam(Team $team, Match $match): bool
    {
        return $team->id === $match->home_team;
    }

    /**
     * Check if team is playing match on away ground.
     *
     * @param Team $team
     * @param Match $match
     * @return bool
     */
    private function isAwayTeam(Team $team, Match $match): bool
    {
        return $team->id === $match->away_team;
    }

    /**
     * Checks if team has lost or not.
     *
     * @param Team $team
     * @param Match $match
     * @return bool
     */
    private function hasTeamLost(Team $team, Match $match): bool
    {
        if ($this->isHomeTeam($team, $match)) {
            return $match->home_team_score < $match->away_team_score;
        }

        if ($this->isAwayTeam($team, $match)) {
            return $match->home_team_score > $match->away_team_score;
        }

        return false;
    }

    /**
     * Get goal difference of the match.
     *
     * @param Team $team
     * @param Match $match
     * @param int $goalDifference
     * @return mixed
     */
    private function getUpdatedGoalDifference(Team $team, Match $match, int $goalDifference)
    {
        if ($this->isHomeTeam($team, $match)) {
            $goalDifference += $match->home_team_score - $match->away_team_score;
        } else {
            $goalDifference += $match->away_team_score - $match->home_team_score;
        }

        return $goalDifference;
    }

    /**
     * Get total points scored by the team from given matches.
     *
     * @param int $winCount
     * @param int $drawCount
     * @param int $lostCount
     * @return int
     */
    private function getPoints(int $winCount, int $drawCount, int $lostCount): int
    {
        $winPoints = config('simulation.points.win') * $winCount;
        $drawPoints = config('simulation.points.draw') * $drawCount;
        $lostPoints = config('simulation.points.loss') * $lostCount;

        return $winPoints + $drawPoints + $lostPoints;
    }

    /**
     * Get weekly matches statistics.
     *
     * @param int $weekId
     * @return array
     */
    private function getWeeklyMatchesStatistics(int $weekId): array
    {
        $matches = $this->matchRepository->whereUsingOperator('week_id', '=', $weekId);

        $data = [];

        foreach ($matches as $match) {
            $data[] = [
                'homeTeam' => $match->homeTeam->name,
                'homeTeamScore' => $match->home_team_score,
                'awayTeam' => $match->awayTeam->name,
                'awayTeamScore' => $match->away_team_score,
            ];
        }

        return $data;
    }
}
