<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is now working'
    ]);
});

// User CRUD routes using resource - automatically handles all HTTP methods
Route::apiResource('users', \App\Http\Controllers\UserController::class);
