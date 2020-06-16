<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Services\WeekService;

class HomeController extends Controller
{
    /**
     * Displays Home Page.
     *
     * @param WeekService $weekService
     * @return View
     */
    public function index(WeekService $weekService): View
    {
        return view('index', [
            'weekCount' => $weekService->getWeekCount(),
            'showPredictionFrom' => config('simulation.predictions.showFrom'),
        ]);
    }
}
