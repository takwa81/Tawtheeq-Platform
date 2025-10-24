<?php

use App\Http\Middleware\CustomAuth;
use App\Http\Middleware\SetLocale;

use Illuminate\Foundation\Application;

use App\Http\Middleware\CustomAuthenticate;
use App\Http\Middleware\EmployeeAuthenticate;
use App\Http\Middleware\EnsureUserType;
use App\Http\Middleware\LanguageMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'set_language' => LanguageMiddleware::class,
            'custom.auth' => CustomAuth::class

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => __('messages.errors.route_not_found'),
                'data' => "",
            ], 404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => __('messages.errors.method_not_allowed'),
                'data' => "",
            ], 405);
        });

        // $exceptions->render(function (Throwable $e, $request) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => __('messages.errors.unexpected_error'),
        //         'data' => [
        //             'error' => $e->getMessage(),
        //         ],
        //     ], 500);
        // });
    })->withProviders([
        App\Providers\RepositoryServiceProvider::class,
    ])->create();