<?php

namespace App\Providers;

use App\Contracts\Presenters\BusStopPresenterContract;
use App\Contracts\Presenters\UserPresenterContract;
use App\Presenters\BusStopPresenter;
use App\Presenters\UserPresenter;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BusStopPresenterContract::class, BusStopPresenter::class);
        $this->app->bind(UserPresenterContract::class, UserPresenter::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
