<?php

namespace App\Modules\Auth\Providers;

use App\Modules\Auth\Services\Contracts\LoginServiceInterface;
use App\Modules\Auth\Services\Contracts\RegisterServiceInterface;
use App\Modules\Auth\Services\LoginService;
use App\Modules\Auth\Services\RegisterService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
        $this->app->bind(RegisterServiceInterface::class, RegisterService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
