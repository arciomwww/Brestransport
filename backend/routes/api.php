<?php


use App\Http\Controllers\API\BusStopController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)
    ->prefix('users')
    ->group(function () {
        Route::post('/', 'store');
        Route::post('/show', 'show');
        Route::post('/import', 'import');
        Route::post('/export', 'export');
        Route::delete('/delete', 'destroyAll');
        Route::delete('/{user}', 'destroy');
    });

Route::controller(BusStopController::class)
    ->prefix('bus-stops')
    ->group(function () {
        Route::get('/', 'index');
    });
