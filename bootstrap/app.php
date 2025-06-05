<?php

use App\Exceptions\Handler;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthenticateJwt;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function (Router $router) {
        require __DIR__.'/../routes/web.php';
        require __DIR__.'/../routes/api.php';
        require __DIR__.'/../routes/console.php';

        $router->get('/up', function () {
            return response()->json(['status' => 'OK']);
        });

        $router->prefix('api/auth')->group(function () {
            require __DIR__.'/../routes/apis/auth.php';
        });

        $router->middleware(['auth.jwt'])->prefix('api/users')->group(function () {
            require __DIR__.'/../routes/apis/user.php';
        });

        $router->middleware(['auth.jwt'])->prefix('api/roles')->group(function () {
            require __DIR__.'/../routes/apis/role.php';
        });

        $router->middleware(['auth.jwt'])->prefix('api/permissions')->group(function () {
            require __DIR__.'/../routes/apis/permission.php';
        });

        $router->middleware(['auth.jwt'])->prefix('api/organizations')->group(function () {
            require __DIR__.'/../routes/apis/organization.php';
        });

        $router->middleware(['auth.jwt'])->prefix('api/select')->group(function () {
            require __DIR__.'/../routes/apis/select.php';
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.jwt' => AuthenticateJwt::class,
        ]);

        $middleware->append([
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

    $app->singleton(ExceptionHandler::class, Handler::class);

return $app;