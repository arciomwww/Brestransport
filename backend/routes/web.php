<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::controller(UserController::class)
    ->prefix('users')
    ->group(function () {
        Route::GET('/export', 'export');
    });
