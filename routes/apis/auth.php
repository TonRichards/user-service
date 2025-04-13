<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\AuthController;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::get('/user', 'getCurrentUser')->middleware(['auth:api']);
});
