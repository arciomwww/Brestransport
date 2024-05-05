<?php

namespace App\Providers;

use App\Actions\API\DeleteUserAction;
use App\Actions\API\ShowUserAction;
use App\Actions\API\StoreUserAction;
use App\Contracts\Actions\DeleteUserActionContract;
use App\Contracts\Actions\ShowUserActionContract;
use App\Contracts\Actions\StoreUserActionContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StoreUserActionContract::class, StoreUserAction::class);
        $this->app->bind(ShowUserActionContract::class, ShowUserAction::class);
        $this->app->bind(DeleteUserActionContract::class, DeleteUserAction::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
