<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'teacher.approved' => \App\Http\Middleware\TeacherApprovedMiddleware::class,
        ]);

        $middleware->appendToGroup('web', \App\Http\Middleware\CheckSingleSession::class);
        
        $middleware->validateCsrfTokens(except: [
            '/payment/webhook',
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
