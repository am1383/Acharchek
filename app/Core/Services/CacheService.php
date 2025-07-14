<?php

namespace App\Core\Services;

use App\Constants\CacheConstants;
use App\Constants\MessageCode;
use App\Constants\PrefixConstants;
use App\Core\Services\Contracts\CacheServiceInterface;
use App\Exceptions\ErrorResponseException;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceInterface
{
    public function forgetPhoneVerificationCode(string $phoneNumber): void
    {
        $keyPhone = PrefixConstants::PREFIX_PHONE_VERIFICATION.$phoneNumber;

        $this->forget($keyPhone);
    }

    public function putVerificationCode(string $phoneNumber, string $verificationCode): int
    {
        $phoneVerificationTime = CacheConstants::PHONE_VERIFICATION_TIME;
        $key = PrefixConstants::PREFIX_PHONE_VERIFICATION.$phoneNumber;

        $this->put($key, $verificationCode, $phoneVerificationTime);

        return $phoneVerificationTime;
    }

    public function getVerificationCodeOrFail(): string
    {
        $verificationCode = $this->get(PrefixConstants::PREFIX_PHONE_VERIFICATION);

        throw_if(
            ! $verificationCode,
            throw new ErrorResponseException(false, null, MessageCode::ERROR_PHONE_VERIFICATION_102)
        );

        return $verificationCode;
    }

    public function putSessionKey(string $sessionKey, array $sessionData): void
    {
        $this->put($sessionKey, $sessionData, CacheConstants::SESSION_TIME);
    }

    public function put(string $key, mixed $value, int $ttl): void
    {
        Cache::put($key, $value, $ttl);
    }

    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    public function get(string $key): mixed
    {
        return Cache::get($key);
    }
}
