<?php

namespace EdenLife\SuperBan;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\Repository as CacheRepository;

class SuperBanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SuperBanMiddleware::class, function ($app) {
            return new SuperBanMiddleware(
                $app->make(CacheRepository::class),
                $app->make(RateLimiter::class),
            );
        });

    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/SuperBan.php' => config_path('SuperBan.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/config/SuperBan.php', 'SuperBan'
        );
    }
}
