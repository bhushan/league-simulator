<?php

declare(strict_types=1);

namespace App\Services;

interface PredictionInterface
{
    /**
     * Get predictions.
     *
     * @param array $records
     * @return array
     */
    public function getPredictions(array $records): array;
}
