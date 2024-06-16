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
use App\Contracts\Tasks\User\DestroyAllTaskContract;
use App\Tasks\User\DestroyAllTask;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DestroyAllTaskContract::class, DestroyAllTask::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
