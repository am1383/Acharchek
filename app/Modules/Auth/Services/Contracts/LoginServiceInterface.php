<?php

namespace App\Modules\Auth\Services\Contracts;

interface LoginServiceInterface
{
    public function handleLogin(string $phoneNumber, string $verifyCode, string $deviceInfo): array;
}
