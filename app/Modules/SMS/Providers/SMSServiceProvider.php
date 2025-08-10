<?php

namespace App\Modules\SMS\Providers;

use App\Modules\Auth\Repositories\Eloquent\SMSPackRepository;
use App\Modules\SMS\Models\SMSPack;
use App\Modules\SMS\Repositories\Contracts\SMSPackRepositoryInterface;
use App\Modules\SMS\Services\Contracts\SMSPackServiceInterface;
use App\Modules\SMS\Services\Contracts\SMSServiceInterface;
use App\Modules\SMS\Services\SMSPackService;
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
        $this->app->bind(SMSPackServiceInterface::class, SMSPackService::class);

        $this->app->bind(SMSPackRepositoryInterface::class, function ($app): SMSPackRepository {
            return new SMSPackRepository($app->make(SMSPack::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
