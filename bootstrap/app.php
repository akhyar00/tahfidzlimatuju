<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php', // Pastikan ini menunjuk ke file route Anda yang benar (web.php atau web1.php)
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // DAFTARKAN NAMA PANGGILAN MIDDLEWARE DI SINI
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\CheckAdminLogin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();