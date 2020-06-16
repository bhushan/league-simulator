<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Team;

class TeamRepository extends Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param Team $team
     */
    public function __construct(Team $team)
    {
        $this->model = $team;
    }
}
