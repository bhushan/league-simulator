<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Week;

class WeekRepository extends Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param Week $week
     */
    public function __construct(Week $week)
    {
        $this->model = $week;
    }

    /**
     * To get total number of weeks.
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->model->all()->count();
    }
}
