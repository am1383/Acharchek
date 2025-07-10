<?php

namespace App\Providers;

use App\Core\Services\CacheService;
use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\ResponseServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;
use App\Core\Services\RateLimitService;
use App\Core\Services\SMSService;
use App\Services\Response\ResponseService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
        $this->app->bind(RateLimitServiceInterface::class, RateLimitService::class);
        $this->app->bind(SMSServiceInterface::class, SMSService::class);
        $this->app->bind(ResponseServiceInterface::class, ResponseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
