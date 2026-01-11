<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
<<<<<<< HEAD
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'firebase-auth' => \App\Http\Middleware\FirebaseAuth::class,
        ]);
=======
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
)
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
    'firebase-auth' => \App\Http\Middleware\FirebaseAuth::class,
    'admin-only' => \App\Http\Middleware\AdminOnly::class,
]);
>>>>>>> 5c6469d (push kode awal)
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
