<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\AuthController;
use App\Http\Controllers\Api\Dashboard\RoleController;
use App\Http\Controllers\Api\Dashboard\ApplicationController;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(RoleController::class)->prefix('roles')->group(function () {
    Route::post('/', 'store');
});

Route::controller(ApplicationController::class)->prefix('applications')->group(function () {
    Route::post('/', 'store');
});