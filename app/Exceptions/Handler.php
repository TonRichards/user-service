<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error("Exception caught: " . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        });

        $this->renderable(function (Throwable $e, Request $request): JsonResponse {
            return $this->handleApiException($e, $request);
        });
    }

    private function handleApiException(Throwable $e, Request $request): JsonResponse
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'message' => class_basename($e->getModel()) . ' Not found',
            ], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Unauthorized access',
            ], 401);
        }

        $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

        return response()->json([
            'message' => $e->getMessage(),
        ], $statusCode);
    }
}
