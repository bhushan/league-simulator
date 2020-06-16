<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Match;

class MatchRepository extends Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param Match $match
     */
    public function __construct(Match $match)
    {
        $this->model = $match;
    }
}
