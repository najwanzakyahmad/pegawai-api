<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors; // ⬅️ tambah ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // middleware global (jalan di semua request)
        $middleware->append(HandleCors::class);

        $middleware->web(append: [
            // middleware untuk Sanctum stateful requests (kalau perlu)
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
