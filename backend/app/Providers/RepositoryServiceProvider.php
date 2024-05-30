<?php

namespace App\Providers;

use App\Contracts\Repositories\BusStopRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Repositories\BusStopRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(BusStopRepositoryContract::class, BusStopRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
