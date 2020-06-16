<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};

class Match extends Model
{
    /**
     * To get Home Team of current match.
     *
     * @return BelongsTo
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team');
    }

    /**
     * To get Away Team of current match.
     *
     * @return BelongsTo
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team');
    }

    /**
     * To get week of current match.
     *
     * @return BelongsTo
     */
    public function week(): BelongsTo
    {
        return $this->belongsTo(Week::class, 'week_id');
    }
}
