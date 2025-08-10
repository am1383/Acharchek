<?php

namespace App\Modules\Location\Providers;

use App\Modules\Location\Services\CityService;
use App\Modules\Location\Services\Contracts\CityServiceInterface;
use App\Modules\Location\Services\Contracts\ProvinceServiceInterface;
use App\Modules\Location\Services\ProvinceService;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityServiceInterface::class, CityService::class);
        $this->app->bind(ProvinceServiceInterface::class, ProvinceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
