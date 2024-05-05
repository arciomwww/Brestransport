<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\API'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::post('/', 'UserController@store');
        Route::post('/show', 'UserController@show');
        Route::delete('/{user}', 'UserController@destroy');
    });
});
