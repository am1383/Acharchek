<?php

namespace App\Modules\Admin\Providers;

use App\Modules\Admin\Repositories\Eloquent\MessageInboxRepository;
use App\Modules\Admin\Services\Contracts\MessageInboxServiceInterface;
use App\Modules\Admin\Services\MessageInboxService;
use App\Modules\Auth\Models\MessageInbox;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MessageInboxServiceInterface::class, MessageInboxService::class);

        $this->app->bind(MessageInboxRepository::class, function ($app): MessageInboxRepository {
            return new MessageInboxRepository($app->make(MessageInbox::class));
        });
    }
}
