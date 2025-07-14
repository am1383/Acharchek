<?php

namespace App\Core\Services\Contracts;

use App\Constants\RateLimitConstants;

interface RateLimitServiceInterface
{
    public function isRateLimited(string $ip, string $phoneNumber): void;

    public function isVerifyLoginRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 20): void;

    public function rateLimitHitVerifyLogin(string $ip, string $phoneNumber): void;

    public function rateLimitHitLogin(): void;

    public function hit(string $key, int $decaySeconds = RateLimitConstants::DECAY_SECONDS): void;
}
