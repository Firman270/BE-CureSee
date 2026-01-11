<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        \Illuminate\Http\Middleware\HandleCors::class,
    ];

    /**
     * Route middleware groups
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
        ],
    ];

    /**
     * Route middleware
     */
    protected $routeMiddleware = [
        'firebase-auth' => \App\Http\Middleware\FirebaseAuth::class,
        'admin-only'    => \App\Http\Middleware\AdminOnly::class,
    ];
}
