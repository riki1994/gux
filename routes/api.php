<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [\App\Http\Controllers\Api\AuthenticatedApiController::class, 'login']);
    Route::group([
        'middleware' => ['auth:api', 'throttle:3,1']
    ], function() {
        Route::get('me', [\App\Http\Controllers\Api\AuthenticatedApiController::class, 'me']);
        Route::post('logout', [\App\Http\Controllers\Api\AuthenticatedApiController::class, 'logout']);
        Route::post('refresh', [\App\Http\Controllers\Api\AuthenticatedApiController::class, 'refresh']);
    });
});
