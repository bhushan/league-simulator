<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\{TeamRepository, MatchRepository};

class MatchService
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
     * MatchService constructor.
     *
     * @param MatchRepository $matchRepository
     * @param TeamRepository $teamRepository
     */
    public function __construct(MatchRepository $matchRepository, TeamRepository $teamRepository)
    {
        $this->matchRepository = $matchRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * Update matches of particular week.
     *
     * @param array $data
     * @return void
     */
    public function updateMatchesForWeek(array $data): void
    {
        foreach ($data['weeklyMatches'] as $match) {
            $homeTeam = $this->teamRepository->whereByFirst(['name' => $match['homeTeam']]);
            $awayTeam = $this->teamRepository->whereByFirst(['name' => $match['awayTeam']]);

            $this->matchRepository->update(
                [
                    'home_team' => $homeTeam->id,
                    'away_team' => $awayTeam->id,
                    'week_id' => $data['weekId'],
                ],
                [
                    'home_team_score' => $match['homeTeamScore'],
                    'away_team_score' => $match['awayTeamScore'],
                ]
            );
        }
    }

    /**
     * Reset all matches records.
     *
     * @return void
     */
    public function resetData(): void
    {
        $matches = $this->matchRepository->getAll();
        foreach ($matches as $match) {
            $this->matchRepository->update(
                ['id' => $match->id],
                [
                    'home_team_score' => 0,
                    'away_team_score' => 0,
                    'is_played' => 0,
                ]
            );
        }
    }

    /**
     * Generate unplayed match's score and update played status.
     *
     * @param int $weekId
     * @return void
     */
    public function generateUnplayedMatchScores(int $weekId): void
    {
        $matches = $this->matchRepository->whereUsingOperator('week_id', '<=', $weekId);

        $max = config('simulation.goals.max');
        $min = config('simulation.goals.min');

        $matches->filter(function ($match) {
            return $match->is_played == false;
        })->each(function ($match) use ($min, $max) {
            $this->matchRepository->update(['id' => $match->id], [
                'home_team_score' => rand($min, $max),
                'away_team_score' => rand($min, $max),
                'is_played' => true,
            ]);
        });
    }
}
