<?php

namespace App\Core\Services\Contracts;

interface RateLimitServiceInterface
{
    public function isRateLimited(string $ip, string $phoneNumber): void;

    public function isVerifyLoginRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 20): void;

    public function rateLimitHitVerifyLogin(string $ip, string $phoneNumber): void;

    public function rateLimitHitLogin(): void;
}
