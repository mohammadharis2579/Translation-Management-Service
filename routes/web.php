<?php

use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/translations', [TranslationController::class, 'create']);
Route::put('/translations/{id}', [TranslationController::class, 'update']);
Route::get('/translations', [TranslationController::class, 'search']);
