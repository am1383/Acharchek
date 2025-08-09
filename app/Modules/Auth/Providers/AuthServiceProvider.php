<?php

namespace App\Modules\Auth\Providers;

use App\Modules\Auth\Services\Contracts\LoginServiceInterface;
use App\Modules\Auth\Services\LoginService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
