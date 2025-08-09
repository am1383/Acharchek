<?php

namespace App\Modules\User\Services\Contracts;

use App\Modules\Auth\Models\User;

interface UserServiceInterface
{
    public function getInformation(string $apiToken): User;

    public function getSecondUserInformation(string $apiToken): array;

    public function getFullUserInfo(string $apiToken): array;
}
