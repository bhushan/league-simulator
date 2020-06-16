<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\WeekRepository;

class WeekService
{
    /**
     * @var WeekRepository
     */
    private $weekRepository;

    /**
     * WeekService constructor.
     *
     * @param WeekRepository $weekRepository
     */
    public function __construct(WeekRepository $weekRepository)
    {
        $this->weekRepository = $weekRepository;
    }

    /**
     * Get total week's count.
     *
     * @return int
     */
    public function getWeekCount(): int
    {
        return $this->weekRepository->getTotalCount();
    }
}
