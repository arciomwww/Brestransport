<?php

namespace App\Providers;

use App\Actions\API\DeleteUserAction;
use App\Actions\API\ExportAction;
use App\Actions\API\ImportAction;
use App\Actions\API\ShowUserAction;
use App\Actions\API\StoreUserAction;
use App\Contracts\Actions\DeleteUserActionContract;
use App\Contracts\Actions\ExportActionContract;
use App\Contracts\Actions\ImportActionContract;
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
        $this->app->bind(ImportActionContract::class, ImportAction::class);
        $this->app->bind(ExportActionContract::class, ExportAction::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
