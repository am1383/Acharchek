<?php

namespace App\Modules\SMS\Providers;

use App\Modules\SMS\Services\Contracts\SMSServiceInterface;
use App\Modules\SMS\Services\SMSService;
use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SMSServiceInterface::class, SMSService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
