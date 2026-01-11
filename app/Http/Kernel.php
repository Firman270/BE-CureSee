<?php

namespace App\Http;
dd('INI KERNEL YANG TERPAKAI');


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
    'firebase.auth' => \app\Http\Middleware\FirebaseAuth::class,
<<<<<<< HEAD
    // 'admin-only' => \app\Http\Middleware\AdminOnly::class,
=======
    'admin-only' => \app\Http\Middleware\AdminOnly::class,
>>>>>>> 5c6469d (push kode awal)
];
}
