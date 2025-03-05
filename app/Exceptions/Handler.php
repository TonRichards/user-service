<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function report(Throwable $e): void
    {
        Log::error("Exception caught: " . $e->getMessage(), [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    public function render(Request $request, Throwable $e): JsonResponse
    {
        if ($request->wantsJson()) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Record not found !!',
                ], 404);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => class_basename($e->getModel()).' Not found',
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

            $statusCode = $this->validStatusCode($e->getCode()) ? $e->getCode() : 500;

            return response()->json([
                'message' => $e->getMessage(),
            ], $statusCode);
        }

        return parent::render($request, $e);
    }

    private function validStatusCode($code): bool
    {
        return is_int($code) && $code >= 100 && $code < 600;
    }

    public function shouldReport(Throwable $e): bool
    {
        return true;
    }

    public function renderForConsole($output, Throwable $e): void
    {
        $output->writeln("<error>{$e->getMessage()}</error>");
    }
}
