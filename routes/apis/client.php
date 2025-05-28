<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Clients\RoleController;
use App\Http\Controllers\Api\Clients\UserController;
use App\Http\Controllers\Api\Clients\PermissionController;
use App\Http\Controllers\Api\Clients\OrganizationController;

Route::controller(RoleController::class)->prefix('roles')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::controller(UserController::class)->prefix('users')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::controller(OrganizationController::class)->prefix('organizations')->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});
