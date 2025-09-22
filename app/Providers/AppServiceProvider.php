<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register NoCaptcha service properly
        $this->app->singleton('NoCaptcha', function ($app) {
            return new \Anhskohbo\NoCaptcha\NoCaptcha(
                config('captcha.secret'),
                config('captcha.sitekey'),
                config('captcha.options', [])
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL::forceScheme('https');
        
        // Register reCAPTCHA validation rule
        \Illuminate\Support\Facades\Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            if (empty($value)) {
                return false;
            }
            
            $nocaptcha = app('NoCaptcha');
            return $nocaptcha->verifyResponse($value, request()->ip());
        });
        
        // Register model observers
        \App\Models\ContactMessage::observe(\App\Observers\ContactMessageObserver::class);
        \App\Models\PendingChange::observe(\App\Observers\PendingChangeObserver::class);
        \App\Models\AuditLog::observe(\App\Observers\AuditLogObserver::class);
    }
}
