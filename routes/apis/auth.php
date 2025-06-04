<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware(['auth:api']);

    Route::post('/switch-organization', 'switchOrganization')->middleware(['auth:api']);
    Route::get('/check', 'getCurrentUser')->middleware(['auth:api']);
});
