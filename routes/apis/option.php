<?php

use App\Http\Controllers\Api\Option\SelectOptionController;

Route::controller(SelectOptionController::class)->prefix('select/option')->group(function () {
    Route::get('/users', 'users');
    Route::get('/organizations', 'organizations');
    Route::get('/roles', 'roles');
    Route::get('/permissions', 'permissions');
});