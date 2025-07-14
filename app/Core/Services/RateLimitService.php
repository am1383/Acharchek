<?php

namespace App\Core\Services;

use App\Constants\MessageCode;
use App\Constants\PrefixConstants;
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
        $maxAttemptsVerifyLogin = RateLimitConstants::MAX_ATTEMPTS_VERIFY_LOGIN;
        $maxAttemptsVerification = RateLimitConstants::MAX_ATTEMPTS_VERIFICATION;

        $this->isVerifyLoginRateLimited($ip, $phoneNumber,
            Messagecode::messageText(MessageCode::ERROR_RATE_LIMITER_100), $maxAttemptsVerifyLogin);
        $this->isPhoneVerificationRateLimited($ip, $phoneNumber,
            MessageCode::messageText(MessageCode::ERROR_PHONE_VERIFICATION_RATE_LIMIT_100), $maxAttemptsVerification);
    }

    public function isVerifyLoginRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 20): void
    {
        $prefix = PrefixConstants::PREFIX_VERIFY_LOGIN;
        $ipKey = $prefix.$ip;
        $phoneKey = $prefix.$phoneNumber;

        $this->validateRateLimit($ipKey, $phoneKey, $maxAttempts, $messageCode);
    }

    private function isPhoneVerificationRateLimited(string $ip, string $phoneNumber, string $messageCode, int $maxAttempts = 1): void
    {
        $prefix = PrefixConstants::PREFIX_VERIFY_CODE;
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

        $this->hit(PrefixConstants::PREFIX_VERIFY_LOGIN, $decaySeconds);
        $this->hit(PrefixConstants::PREFIX_VERIFY_CODE, $decaySeconds);
    }

    public function rateLimitHitVerifyLogin(string $ip, string $phoneNumber): void
    {
        $decaySeconds = RateLimitConstants::DECAY_SECONDS;
        $prefix = PrefixConstants::PREFIX_VERIFY_LOGIN;
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
