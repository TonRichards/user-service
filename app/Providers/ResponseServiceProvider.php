<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

        Response::macro('unauthenticated', function () {
            return Response::json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        });

        Response::macro('unauthorized', function () {
            return Response::json([
                'success' => false,
                'message' => 'Unauthorized to this resources',
            ], 403);
        });

        Response::macro('withPaginated', function (LengthAwarePaginator $paginator, mixed $data) {
            return Response::json([
                'success' => true,
                'message' => 'Data retrived successfully',
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
