<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;

Route::controller(RoleController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});
