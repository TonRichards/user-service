<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = []) {
            return Response::json([
                'success' => true,
                'data' => $data,
            ], 200);
        });

        Response::macro('created', function ($data = []) {
            return Response::json([
                'success' => true,
                'data' => $data,
            ], 201);
        });

        Response::macro('unauthorized', function () {
            return Response::json([
                'success' => false,
                'message' => 'Unauthorized to this resources',
            ], 401);
        });
    }
}
