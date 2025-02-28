<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users/home', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::get('/index', function () {
    return response()->json(['message' => 'API is working!']);
});
