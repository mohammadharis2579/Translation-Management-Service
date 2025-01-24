<?php

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\TranslationAPIController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('register', [AuthAPIController::class, 'register']);
	Route::post('login', [AuthAPIController::class, 'login']);
    Route::post('logout', [AuthAPIController::class, 'logout'])->middleware('auth:api');
    Route::get('/export', [TranslationAPIController::class, 'export'])->middleware('auth:api');
});
