<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Catch all exceptions and return JSON response
        $exceptions->render(function (\Throwable $e) {
            // Handle authentication exceptions
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please provide a valid token.',
                    'error' => 'Authentication failed'
                ], 401);
            }

            // Handle authorization exceptions
            if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. You do not have permission to perform this action.',
                    'error' => 'Authorization failed'
                ], 403);
            }

            // Handle model not found exceptions
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found.',
                    'error' => 'Model not found'
                ], 404);
            }

            // Handle validation exceptions
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

            // Handle route not found exceptions
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Route not found.',
                    'error' => 'Not found'
                ], 404);
            }

            // Handle method not allowed exceptions
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Method not allowed.',
                    'error' => 'Method not allowed'
                ], 405);
            }

            // Handle all other exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        });
    })->create();
