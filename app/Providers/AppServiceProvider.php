<?php

namespace App\Providers;

use App\Modules\Auth\Models\City;
use App\Modules\Auth\Models\Information;
use App\Modules\Auth\Models\LoginTries;
use App\Modules\Auth\Models\MobileDevice;
use App\Modules\Auth\Models\Province;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\InformationRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\LoginTriesRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\MobileDeviceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Repositories\Eloquent\CityRepository;
use App\Modules\Auth\Repositories\Eloquent\InformationRepository;
use App\Modules\Auth\Repositories\Eloquent\LoginTriesRepository;
use App\Modules\Auth\Repositories\Eloquent\MobileDeviceRepository;
use App\Modules\Auth\Repositories\Eloquent\ProvinceRepository;
use App\Modules\Auth\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app): UserRepository {
            return new UserRepository($app->make(User::class));
        });

        $this->app->bind(CityRepositoryInterface::class, function ($app): CityRepository {
            return new CityRepository($app->make(City::class));
        });

        $this->app->bind(ProvinceRepositoryInterface::class, function ($app): ProvinceRepository {
            return new ProvinceRepository($app->make(Province::class));
        });

        $this->app->bind(InformationRepositoryInterface::class, function ($app): InformationRepository {
            return new InformationRepository($app->make(Information::class));
        });

        $this->app->bind(LoginTriesRepositoryInterface::class, function ($app): LoginTriesRepository {
            return new LoginTriesRepository($app->make(LoginTries::class));
        });

        $this->app->bind(MobileDeviceRepositoryInterface::class, function ($app): MobileDeviceRepository {
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
