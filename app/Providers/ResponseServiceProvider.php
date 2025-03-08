<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\LengthAwarePaginator;

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

        Response::macro('paginated', function ($data = [], LengthAwarePaginator $paginator, string $message = 'Success') {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $data,
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                    'next_page_url' => $paginator->nextPageUrl(),
                    'prev_page_url' => $paginator->previousPageUrl(),
                ],
            ], 200);
        });
    }
}
