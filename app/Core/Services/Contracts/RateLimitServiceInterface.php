<?php

namespace App\Core\Services\Contracts;

interface RateLimitServiceInterface
{
    public function isRateLimited(string $ip, string $phoneNumber): ?array;

    public function rateLimitHit(): void;
}
