<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/refresh', 'refresh');
    Route::post('/logout', 'logout')->middleware(['auth.jwt']);

    Route::post('/switch-organization', 'switchOrganization')->middleware(['auth.jwt']);
    Route::get('/check', 'getCurrentUser')->middleware(['auth.jwt']);
});
