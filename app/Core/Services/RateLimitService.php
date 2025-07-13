<?php

namespace App\Core\Services;

use App\Constants\Constants;
use App\Constants\RateLimitConstants;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Exceptions\ErrorResponseException;
use App\Helpers\TimeHelper;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitService implements RateLimitServiceInterface
{
    public function __construct() {}

    public function isRateLimited(string $ip, string $phoneNumber): void
    {
        $maxAttemptsVerifyLogin = 20;
        $maxAttemptsVerification = 1;

        $this->isVerifyLoginRateLimited($ip, $phoneNumber, Constants::ERROR_RATE_LIMITER_100, $maxAttemptsVerifyLogin);
        $this->isPhoneVerificationRateLimited($ip, $phoneNumber, Constants::ERROR_PHONE_VERIFICATION_RATE_LIMIT_100, $maxAttemptsVerification);
    }

    public function isVerifyLoginRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 20): void
    {
        $prefix = Constants::PREFIX_VERIFY_LOGIN;
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        $this->validateRateLimit($ipKey, $phoneKey, $maxAttempts, $messageCode);
    }

    private function isPhoneVerificationRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 1): void
    {
        $prefix = Constants::PREFIX_VERIFY_CODE;
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        $this->validateRateLimit($ipKey, $phoneKey, $maxAttempts, $messageCode);
    }

    private function validateRateLimit(string $ipKey, string $phoneKey, int $maxAttemptsLimit, string $messageCode): void
    {
        if (RateLimiter::tooManyAttempts($ipKey, $maxAttemptsLimit) or
            RateLimiter::tooManyAttempts($phoneKey, $maxAttemptsLimit)) {
            $seconds = max(
                RateLimiter::availableIn($ipKey),
                RateLimiter::availableIn($phoneKey)
            );

            $time = TimeHelper::translateSeconds($seconds);
            $message = sprintf($messageCode, $time);

            throw new ErrorResponseException(false, ['seconds' => $seconds], $messageCode, $message);
        }
    }

    public function rateLimitHitLogin(): void
    {
        $decaySeconds = RateLimitConstants::DECAY_SECONDS;

        $this->hit(Constants::PREFIX_VERIFY_LOGIN, $decaySeconds);
        $this->hit(Constants::PREFIX_VERIFY_CODE, $decaySeconds);
    }

    public function rateLimitHitVerifyLogin(string $ip, string $phoneNumber): void
    {
        $decaySeconds = RateLimitConstants::DECAY_SECONDS;
        $prefix = Constants::PREFIX_VERIFY_LOGIN;
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        $this->hit($ipKey, $decaySeconds);
        $this->hit($phoneKey, $decaySeconds);
    }

    public function hit(string $key, int $decaySeconds = RateLimitConstants::DECAY_SECONDS): void
    {
        RateLimiter::hit($key, $decaySeconds);
    }
}
