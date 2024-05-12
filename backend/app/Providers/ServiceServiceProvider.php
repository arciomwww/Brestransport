<?php

namespace App\Providers;

use App\Contracts\Services\ExcelServiceContract;
use App\Services\ExcelService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ExcelServiceContract::class, ExcelService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
