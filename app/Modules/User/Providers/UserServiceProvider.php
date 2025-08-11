<?php

namespace App\Modules\User\Providers;

use App\Core\Models\User;
use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Core\Repositories\UserRepository;
use App\Modules\User\Services\Contracts\UserServiceInterface;
use App\Modules\User\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);

        $this->app->bind(UserRepositoryInterface::class, function ($app): UserRepositoryInterface {
            return new UserRepository($app->make(User::class));
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
