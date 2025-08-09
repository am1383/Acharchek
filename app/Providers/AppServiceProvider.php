<?php

namespace App\Providers;

use App\Modules\Auth\Models\City;
use App\Modules\Auth\Models\Information;
use App\Modules\Auth\Models\MobileDevice;
use App\Modules\Auth\Models\Province;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\InformationRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\MobileDeviceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use App\Modules\Auth\Repositories\Eloquent\CityRepository;
use App\Modules\Auth\Repositories\Eloquent\InformationRepository;
use App\Modules\Auth\Repositories\Eloquent\MobileDeviceRepository;
use App\Modules\Auth\Repositories\Eloquent\ProvinceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryInterface::class, function ($app): CityRepositoryInterface {
            return new CityRepository($app->make(City::class));
        });

        $this->app->bind(ProvinceRepositoryInterface::class, function ($app): ProvinceRepositoryInterface {
            return new ProvinceRepository($app->make(Province::class));
        });

        $this->app->bind(InformationRepositoryInterface::class, function ($app): InformationRepositoryInterface {
            return new InformationRepository($app->make(Information::class));
        });

        $this->app->bind(MobileDeviceRepositoryInterface::class, function ($app): MobileDeviceRepositoryInterface {
            return new MobileDeviceRepository($app->make(MobileDevice::class));
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
