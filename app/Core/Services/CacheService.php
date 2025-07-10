<?php

namespace App\Core\Services;

use App\Core\Services\Contracts\CacheServiceInterface;
use App\Exceptions\VerificationCodeException;
use Constants;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceInterface
{
    public function forgetPhoneVerificationCode(string $phoneNumber): void
    {
        $keyPhone = Constants::PREFIX_PHONE_VERIFICATION.$phoneNumber;

        $this->forget($keyPhone);
    }

    private function forget(string $key): void
    {
        Cache::forget($key);
    }

    public function putVerificationCode(string $phoneNumber, string $verificationCode): int
    {
        $phoneVerificationTime = 60 * 4;
        $key = Constants::PREFIX_PHONE_VERIFICATION.$phoneNumber;

        $this->put($key, $verificationCode, $phoneVerificationTime);

        return $phoneVerificationTime;
    }

    private function put(string $key, string $value, int $ttl): void
    {
        Cache::put($key, $value, $ttl);
    }

    public function getVerificationCodeOrFail(): string
    {
        $verificationCode = $this->get(Constants::PREFIX_PHONE_VERIFICATION);

        if (! $verificationCode) {
            throw new VerificationCodeException;
        }

        return $verificationCode;
    }

    private function get(string $key): mixed
    {
        return Cache::get($key);
    }
}
