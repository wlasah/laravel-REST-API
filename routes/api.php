<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolePermissionController;

// Test endpoint
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is now working'
    ]);
});

// Public authentication routes (no token required)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Temporary public route to delete old user
Route::delete('/users/1/temp-delete', [UserController::class, 'destroy']);

// Protected routes (require Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes (require token)
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // User CRUD routes (require token)
    Route::apiResource('users', UserController::class);

    // Role and Permission management routes
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolePermissionController::class, 'getAllRoles']);                    // Get all roles
        Route::post('/assign/{userId}', [RolePermissionController::class, 'assignRole']);    // Assign role to user
        Route::post('/remove/{userId}', [RolePermissionController::class, 'removeRole']);    // Remove role from user
    });

    Route::prefix('permissions')->group(function () {
        Route::get('/', [RolePermissionController::class, 'getAllPermissions']);             // Get all permissions
    });

    // Get user's roles and permissions
    Route::get('/users/{userId}/roles', [RolePermissionController::class, 'getUserRoles']);
});
