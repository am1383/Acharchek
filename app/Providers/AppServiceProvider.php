<?php

namespace App\Providers;

use App\Modules\Admin\Providers\AdminServiceProvider;
use App\Modules\Auth\Models\City;
use App\Modules\Auth\Models\Information;
use App\Modules\Auth\Models\MobileDevice;
use App\Modules\Auth\Models\Province;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Providers\AuthServiceProvider;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\InformationRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\MobileDeviceRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use App\Modules\Auth\Repositories\Eloquent\CityRepository;
use App\Modules\Auth\Repositories\Eloquent\InformationRepository;
use App\Modules\Auth\Repositories\Eloquent\MobileDeviceRepository;
use App\Modules\Auth\Repositories\Eloquent\ProvinceRepository;
use App\Modules\Panel\Providers\PanelServiceProvider;
use App\Modules\Panel\Services\PanelService;
use App\Modules\SMS\Providers\SMSServiceProvider;
use App\Modules\User\Providers\UserServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AdminServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(PanelServiceProvider::class);
        $this->app->register(SMSServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
