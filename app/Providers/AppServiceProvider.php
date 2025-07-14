<?php

namespace App\Providers;

use App\Core\Services\CacheService;
use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;
use App\Core\Services\RateLimitService;
use App\Core\Services\SMSService;
use App\Modules\Auth\Models\Business;
use App\Modules\Auth\Models\BusinesService;
use App\Modules\Auth\Models\BusinessType;
use App\Modules\Auth\Models\City;
use App\Modules\Auth\Models\Province;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\BusinessRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\BusinessServiceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Repositories\Eloquent\BusinessRepository;
use App\Modules\Auth\Repositories\Eloquent\BusinessServiceRepository;
use App\Modules\Auth\Repositories\Eloquent\BusinessTypeRepository;
use App\Modules\Auth\Repositories\Eloquent\CityRepository;
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
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
        $this->app->bind(RateLimitServiceInterface::class, RateLimitService::class);
        $this->app->bind(SMSServiceInterface::class, SMSService::class);

        $this->app->bind(UserRepositoryInterface::class, function ($app): UserRepository {
            return new UserRepository($app->make(User::class));
        });

        $this->app->bind(CityRepositoryInterface::class, function ($app): CityRepository {
            return new CityRepository($app->make(City::class));
        });

        $this->app->bind(ProvinceRepositoryInterface::class, function ($app): ProvinceRepository {
            return new ProvinceRepository($app->make(Province::class));
        });

        $this->app->bind(BusinessTypeRepository::class, function ($app): BusinessRepository {
            return new BusinessRepository($app->make(BusinessType::class));
        });

        $this->app->bind(BusinessServiceRepositoryInterface::class, function ($app): BusinessServiceRepository {
            return new BusinessServiceRepository($app->make(BusinesService::class));
        });

        $this->app->bind(BusinessRepositoryInterface::class, function ($app): BusinessRepository {
            return new BusinessRepository($app->make(Business::class));
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
