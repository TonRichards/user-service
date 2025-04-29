<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\AuthController;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::post('/switch-organization', 'switchOrganization')->middleware(['auth:api']);
    Route::get('/check', 'getCurrentUser')->middleware(['auth:api']);
});
