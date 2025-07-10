<?php

namespace App\Core\Services;

use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Core\Services\Contracts\ResponseServiceInterface;
use Constants;
use Illuminate\Support\Facades\RateLimiter;
use TimeHelper;

class RateLimitService implements RateLimitServiceInterface
{
    public function __construct(private ResponseServiceInterface $responseService) {}

    public function isRateLimited(string $ip, string $phoneNumber): ?array
    {
        $maxAttemptsVerifyLogin = 20;
        $maxAttemptsVerification = 1;

        return $this->isVerifyLoginRateLimited($ip, $phoneNumber, $maxAttemptsVerifyLogin, Constants::ERROR_RATE_LIMITER_100);
        $this->isPhoneVerificationRateLimited($ip, $phoneNumber, $maxAttemptsVerification, Constants::ERROR_PHONE_VERIFICATION_RATE_LIMIT_100);
    }

    private function isVerifyLoginRateLimited(string $ip, string $phoneNumber, int $maxAttempts, string $messageCode): ?array
    {
        $prefix = 'rl_verify_login_';
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        return $this->validateRateLimit($ipKey, $phoneKey, $maxAttempts, $messageCode);
    }

    private function isPhoneVerificationRateLimited(string $ip, string $phoneNumber, int $maxAttempts, $messageCode): ?array
    {
        $prefix = 'rl_verify_code_';
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        return $this->validateRateLimit($ipKey, $phoneKey, $maxAttempts, $messageCode);
    }

    private function validateRateLimit(string $ipKey, string $phoneKey, int $maxAttemptsLimit, string $messageCode): ?array
    {
        if (RateLimiter::tooManyAttempts($ipKey, $maxAttemptsLimit) or
            RateLimiter::tooManyAttempts($phoneKey, $maxAttemptsLimit)) {
            $seconds = max(
                RateLimiter::availableIn($ipKey),
                RateLimiter::availableIn($phoneKey)
            );

            $time = TimeHelper::translateSeconds($seconds);
            $message = sprintf($messageCode, $time);

            return $this->responseService->result(false, ['seconds' => $seconds], $messageCode, $message);
        }

        return null;
    }

    public function rateLimitHit(): void
    {
        $prefixVerifyLogin = 'rl_verify_login_';
        $prefixVerifyCode = 'rl_verify_code_';
        $decaySeconds = 60 * 60;

        $this->hit($prefixVerifyLogin, $decaySeconds);
        $this->hit($prefixVerifyCode, $decaySeconds);
    }

    private function hit(string $key, int $decaySeconds): void
    {
        RateLimiter::hit($key, $decaySeconds);
    }
}
