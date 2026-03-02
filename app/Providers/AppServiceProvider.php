<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
// ⬇️ EKLEMEN GEREKEN KRİTİK SATIR BURASI ⬇️
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure rate limiter for AI requests
        RateLimiter::for('ai-requests', function ($request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        // Render ve diğer Load Balancer kullanan platformlarda HTTPS zorunluluğu
        if (config('app.env') === 'production' || $this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}