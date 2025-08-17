<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LocaleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            LocaleMiddleware::class,
        ]);
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'employee.permission' => \App\Http\Middleware\EmployeePermissionMiddleware::class,
            'secure.session' => \App\Http\Middleware\SecureSession::class,
            'prevent.back.history' => \App\Http\Middleware\PreventBackHistory::class,
            'prevent.back.after.logout' => \App\Http\Middleware\PreventBackAfterLogout::class,
        ]);

        // Configure authentication redirects
        $middleware->redirectGuestsTo('/admin/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
