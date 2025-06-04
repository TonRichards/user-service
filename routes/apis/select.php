<?php

use App\Http\Controllers\Api\SelectOptionController;

Route::controller(SelectOptionController::class)->prefix('option')->group(function () {
    Route::get('/users', 'users');
    Route::get('/organizations', 'organizations');
    Route::get('/roles', 'roles');
    Route::get('/permissions', 'permissions');
});
