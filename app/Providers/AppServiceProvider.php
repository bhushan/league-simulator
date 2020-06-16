<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\{PredictionService, PredictionInterface};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PredictionInterface::class, function ($app) {
            return new PredictionService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
